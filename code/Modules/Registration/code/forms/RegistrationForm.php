<?php

/**
 * Class RegistrationForm
 */
class RegistrationForm extends Form
{

    /**
     * RegistrationForm constructor
     *
     * @param Controller $controller
     * @param String $name
     * @param array $arguments
     */
    public function __construct($controller, $name, $arguments = array())
    {
        /** -----------------------------------------
         * Fields
         * ----------------------------------------*/

        /** @var TextField $firstName */
        $firstName = TextField::create('FirstName');
        $firstName->setAttribute('placeholder', 'Enter your first name')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>First Name</strong>')
            ->setCustomValidationMessage('Please enter your <strong>First Name</strong>');

        /** @var EmailField $email */
        $email = EmailField::create('Email');
        $email->setAttribute('placeholder', 'Enter your email address')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>Email</strong>')
            ->setCustomValidationMessage('Please enter your <strong>Email</strong>');

        /** @var PasswordField $password */
        $password = PasswordField::create('Password');
        $password->setAttribute('placeholder', 'Enter your password')
            ->setCustomValidationMessage('Please enter your <strong>Password</strong>')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>Password</strong>');

        $fields = FieldList::create(
            $email,
            $password
        );

        /** -----------------------------------------
         * Actions
         * ----------------------------------------*/

        $actions = FieldList::create(
            FormAction::create('Register')->setTitle('Register')->addExtraClass('btn--primary')
        );

        /** -----------------------------------------
         * Validation
         * ----------------------------------------*/

        $required = RequiredFields::create(
            'FirstName',
            'Email',
            'Password'
        );

        /** @var Form $form */
        $form = Form::create($this, $name, $fields, $actions, $required);
        if ($formData = Session::get('FormInfo.Form_' . $name . '.data')) {
            $form->loadDataFrom($formData);
        }

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->setAttribute('data-parsley-validate', true);
        $this->addExtraClass('form form--registration');
    }

    /**
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function Register($data, $form)
    {
        /** @var Form $form */
        $data = $form->getData();

        /** Set session array individually as setting the password breaks the form. */
        $sessionArray = array(
            'Email' => $data['Email']
        );

        /** Check for existing member email address */
        if ($existingUser = DataObject::get_one('Member', "Email = '" . Convert::raw2sql($data['Email']) . "'")) {
            $form->AddErrorMessage('Email', 'Sorry, that email address already exists. Please choose another.',
                'validation');
            Session::set('FormInfo.Form_' . $this->name . '.data', $sessionArray);
            return $this->controller->redirectBack();
        }

        /** Otherwise create new member and log them in
         *
         * @var Member $member
         */
        $member = Member::create();
        $form->saveInto($member);
        $member->write();
        $member->login();

        /** Find or create the 'user' group
         *
         * @var Group $userGroup
         */
        if (!$userGroup = DataObject::get_one('Group', "Code = 'users'")) {
            $userGroup = Group::create();
            $userGroup->Code = 'users';
            $userGroup->Title = 'Users';
            $userGroup->Write();
            $userGroup->Members()->add($member);
        }
        /** Add member to user group */
        $userGroup->Members()->add($member);

        /** Get profile page otherwise display warning. */
        if ($ProfilePage = DataObject::get_one('EditProfilePage')) {
            $this->controller->setFlash('Welcome ' . $data['Email'] . ', your account has been created!', 'success');
            return $this->controller->redirect($ProfilePage->Link());
        } else {
            $this->controller->setFlash('Please add a "Edit Profile Page" in your SiteTree to enable profile editing',
                'warning');
            return $this->controller->redirect(Director::absoluteBaseURL());
        }

    }

}
