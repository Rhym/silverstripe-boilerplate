<?php

/**
 * Class RegistrationForm
 */
class RegistrationForm extends Form {

    /**
     * RegistrationForm constructor
     *
     * @param Controller $controller
     * @param String $name
     * @param array $arguments
     */
    public function __construct($controller, $name, $arguments = array()) {

        /** -----------------------------------------
         * Fields
        -------------------------------------------*/

        $firstName = new TextField('FirstName');
        $firstName->setAttribute('placeholder', 'Enter your first name')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $email = new EmailField('Email');
        $email->setAttribute('placeholder', 'Enter your email address')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $password = new PasswordField('Password');
        $password->setAttribute('placeholder', 'Enter your password')
            ->setCustomValidationMessage('Your passwords do not match', 'validation')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $fields = new FieldList(
            $email,
            $password
        );

        /**
         * Actions
         */
        $actions = new FieldList(
            FormAction::create('Register')->setTitle('Register')->addExtraClass('btn btn-primary')
        );

        /**
         * Validation
         */
        $required = new RequiredFields(
            'FirstName',
            'Email',
            'Password'
        );

        $form = Form::create($this, $name, $fields, $actions, $required);
        if($formData = Session::get('FormInfo.Form_'.$name.'.data')) {
            $form->loadDataFrom($formData);
        }

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('form');
    }

    /**
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function Register($data, $form){

        /**
         * Set session array individually as setting the password breaks the form.
         */
        $sessionArray = array(
            'Email' => $data['Email']
        );

        /**
         * Check for existing member email address
         */
        if($existingUser = DataObject::get_one('Member', "Email = '".Convert::raw2sql($data['Email'])."'")) {
            $form->AddErrorMessage('Email', 'Sorry, that email address already exists. Please choose another.', 'validation');
            Session::set('FormInfo.Form_'.$this->name.'.data', $sessionArray);
            return $this->controller->redirectBack();
        }

        /**
         * Otherwise create new member and log them in
         */
        $Member = new Member();
        $form->saveInto($Member);
        $Member->write();
        $Member->login();

        /**
         * Find or create the 'user' group
         */
        if(!$userGroup = DataObject::get_one('Group', "Code = 'users'")) {
            $userGroup = new Group();
            $userGroup->Code = 'users';
            $userGroup->Title = 'Users';
            $userGroup->Write();
            $userGroup->Members()->add($Member);
        }
        /**
         * Add member to user group
         */
        $userGroup->Members()->add($Member);

        /**
         * Get profile page otherwise display warning.
         */
        if($ProfilePage = DataObject::get_one('EditProfilePage')) {
            $this->controller->setFlash('Welcome ' .$data['Email'].', your account has been created!', 'success');
            return $this->controller->redirect($ProfilePage->Link());
        } else {
            $this->controller->setFlash('Please add a "Edit Profile Page" in your SiteTree to enable profile editing', 'warning');
            return $this->controller->redirect(Director::absoluteBaseURL());
        }

    }

}