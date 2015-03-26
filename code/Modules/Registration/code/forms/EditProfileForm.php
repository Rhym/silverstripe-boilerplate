<?php

/**
 * Class EditProfileForm
 */
class EditProfileForm extends Form {

    /**
     * EditProfileForm constructor
     *
     * @param Controller $controller
     * @param String $name
     * @param array $arguments
     */
    public function __construct($controller, $name, $arguments = array()) {

        $firstName = new TextField('FirstName');
        $firstName->setAttribute('placeholder', 'Enter your first name')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $surname = new TextField('Surname');
        $surname->setAttribute('placeholder', 'Enter your surname')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $email = new EmailField('Email');
        $email->setAttribute('placeholder', 'Enter your email address')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $jobTitle = new TextField('JobTitle');
        $jobTitle->setAttribute('placeholder', 'Enter your job title')
            ->addExtraClass('form-control');

        $website = new TextField('Website');
        $website->setAttribute('placeholder', 'Enter your website')
            ->addExtraClass('form-control');

        $blurb = new TextareaField('Blurb');
        $blurb->setAttribute('placeholder', 'Enter your blurb')
            ->addExtraClass('form-control');

        $confirmPassword = new ConfirmedPasswordField('Password', 'New Password');
        $confirmPassword->canBeEmpty = true;
        $confirmPassword->setAttribute('placeholder', 'Enter your password')
            ->addExtraClass('form-control');

        $passwordToggle = new LiteralField('', '<p><button class="btn btn-default btn-link" type="button" data-toggle="collapse" data-target="#togglePassword" aria-expanded="false" aria-controls="togglePassword">Change Password</button></p><div class="collapse" id="togglePassword">');
        $passwordToggleClose = new LiteralField('', '</div>');

        $fields = new FieldList(
            $firstName,
            $surname,
            $email,
            $jobTitle,
            $website,
            $blurb,
            $passwordToggle,
            $confirmPassword,
            $passwordToggleClose
        );

        $action = new FormAction('Save', 'Update Profile');
        $action->addExtraClass('btn btn-primary');
        $actions = new FieldList(
            $action
        );

        /**
         * Validation
         */
        $required = new RequiredFields('FirstName', 'Email');

        /**
         * Create form
         */
        $form = new Form($this, $name, $fields, $actions, $required);

        /**
         * Populate the form with the current members data
         */
        $Member = Member::currentUser();
        $form->loadDataFrom($Member->data());

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->addExtraClass('form');
    }

    /**
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse|void
     * @throws ValidationException
     * @throws null
     */
    public function Save($data, $form){

        if($CurrentMember = Member::currentUser()){
            if($member = DataObject::get_one('Member', "Email = '". Convert::raw2sql($data['Email']) . "' AND ID != " . $CurrentMember->ID)){
                $form->addErrorMessage('Email', 'Sorry, that Email already exists.', 'validation');
                return $this->controller->redirectBack();
            }else{
                /**
                 * If no password don't save the field
                 */
                if(!isset($data['password'])){
                    unset($data['password']);
                }
                $this->controller->setFlash('Your profile has been updated', 'success');
                $form->saveInto($CurrentMember);
                $CurrentMember->write();
                return $this->controller->redirect($this->controller->Link());
            }
        }else{
            /**
             * Get registration page otherwise display warning.
             */
            if($registerPage = DataObject::get_one('RegistrationPage')){
                return Security::PermissionFailure($this->controller, 'You must <a href="'.$registerPage->Link().'">registered</a> and logged in to edit your profile.');
            }else{
                $this->controller->setFlash('You must registered and logged in to edit your profile.', 'warning');
                return $this->controller->redirect(Director::absoluteBaseURL());
            }
        }

    }

    /**
     * @return mixed
     */
    public function Saved(){
        return $this->request->getVar('saved');
    }

    /**
     * @return mixed
     */
    public function Success(){
        return $this->request->getVar('success');
    }

}