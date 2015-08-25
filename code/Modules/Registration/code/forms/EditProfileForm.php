<?php

/**
 * Class EditProfileForm
 */
class EditProfileForm extends Form
{

    /**
     * EditProfileForm constructor
     *
     * @param Controller $controller
     * @param String $name
     * @param array $arguments
     */
    public function __construct($controller, $name, $arguments = array())
    {
        /** =========================================
         * @var TextField $firstName
         * @var TextField $surname
         * @var EmailField $email
         * @var TextField $jobTitle
         * @var TextField $website
         * @var ConfirmedPasswordField $confirmPassword
         * @var TextField $firstName
         * @var TextField $firstName
         * @var Form $form
        ===========================================*/

        /** -----------------------------------------
         * Fields
         * ----------------------------------------*/

        $firstName = TextField::create('FirstName');
        $firstName->setAttribute('placeholder', 'Enter your first name')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>First Name</strong>')
            ->setCustomValidationMessage('Please enter your <strong>First Name</strong>');

        $surname = TextField::create('Surname');
        $surname->setAttribute('placeholder', 'Enter your surname')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>Surname</strong>')
            ->setCustomValidationMessage('Please enter your <strong>Surname</strong>');

        $email = EmailField::create('Email');
        $email->setAttribute('placeholder', 'Enter your email address')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>Email</strong>')
            ->setCustomValidationMessage('Please enter your <strong>Email</strong>');

        $confirmPassword = ConfirmedPasswordField::create('Password', 'New Password');
        $confirmPassword->canBeEmpty = true;
        $confirmPassword->setAttribute('placeholder', 'Enter your password');

        $passwordToggle = LiteralField::create('',
            '<p><button class="btn--default" type="button" data-toggle="collapse" data-target="#togglePassword" aria-expanded="false" aria-controls="togglePassword">Change Password</button></p><div class="collapse" id="togglePassword">');
        $passwordToggleClose = LiteralField::create('', '</div>');

        $fields = FieldList::create(
            $firstName,
            $surname,
            $email,
            $passwordToggle,
            $confirmPassword,
            $passwordToggleClose
        );

        /** -----------------------------------------
         * Actions
         * ----------------------------------------*/

        $actions = FieldList::create(
            FormAction::create('Save')->setTitle('Update Profile')->addExtraClass('btn--primary')
        );

        /** -----------------------------------------
         * Validation
         * ----------------------------------------*/

        $required = RequiredFields::create(
            'FirstName',
            'Surname',
            'Email'
        );

        /**
         * Create form
         */
        $form = Form::create($this, $name, $fields, $actions, $required);

        /**
         * Populate the form with the current members data
         */
        $Member = Member::currentUser();
        $form->loadDataFrom($Member->data());

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->setAttribute('data-parsley-validate', true);
        $this->addExtraClass('form form--profile');
    }

    /**
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse|void
     * @throws ValidationException
     * @throws null
     */
    public function Save($data, $form)
    {
        /** =========================================
         * @var Form $form
         * @var RegistrationPage $registerPage
        ===========================================*/

        if ($CurrentMember = Member::currentUser()) {
            if ($member = DataObject::get_one('Member',
                "Email = '" . Convert::raw2sql($data['Email']) . "' AND ID != " . $CurrentMember->ID)
            ) {
                $form->addErrorMessage('Email', 'Sorry, that Email already exists.', 'validation');
                return $this->controller->redirectBack();
            } else {
                /** If no password don't save the field */
                if (!isset($data['password'])) {
                    unset($data['password']);
                }
                $this->controller->setFlash('Your profile has been updated', 'success');
                $form->saveInto($CurrentMember);
                $CurrentMember->write();
                return $this->controller->redirect($this->controller->Link());
            }
        } else {
            /** Get registration page otherwise display warning. */
            if ($registerPage = DataObject::get_one('RegistrationPage')) {
                return Security::PermissionFailure($this->controller,
                    'You must <a href="' . $registerPage->Link() . '">registered</a> and logged in to edit your profile.');
            } else {
                $this->controller->setFlash('You must registered and logged in to edit your profile.', 'warning');
                return $this->controller->redirect(Director::absoluteBaseURL());
            }
        }

    }

    /**
     * @return mixed
     */
    public function Saved()
    {
        return $this->request->getVar('saved');
    }

    /**
     * @return mixed
     */
    public function Success()
    {
        return $this->request->getVar('success');
    }

}
