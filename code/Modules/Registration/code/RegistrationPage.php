<?php

/**
 * Class RegistrationPage
 */
class RegistrationPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Registration/images/user--plus.png';
    private static $description = 'Registration content page';

}

class RegistrationPage_Controller extends Page_Controller {

    private static $allowed_actions = array('RegistrationForm');

    /**
     * @return static
     */
    public function RegistrationForm(){

        // Email
        $email = new EmailField('Email');
        $email->setAttribute('placeholder', _t('RegistrationPage.EmailPlaceholder', 'Enter your email address'))
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        // Password Conformation
        $password = new PasswordField('Password');
        $password->setAttribute('placeholder', _t('RegistrationPage.PasswordPlaceholder', 'Enter your password'))
            ->setCustomValidationMessage(_t('RegistrationPage.PasswordValidationText', 'Your passwords do not match'), 'validation')
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        // Generate the fields
        $fields = new FieldList(
            $email,
            $password
        );

        // Submit Button
        $action = new FormAction('Register', 'Register');
        $action->addExtraClass('btn btn-primary btn-lg');

        $actions = new FieldList($action);

        $validator = new RequiredFields('Email', 'Password');

        $form = Form::create($this, 'RegistrationForm', $fields, $actions, $validator);
        if($formData = Session::get('FormInfo.Form_RegistrationForm.data')) {
            $form->loadDataFrom($formData);
        }

        return $form;

    }

    /**
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function Register($data, $form){

        // Set session array individually as setting the password breaks the form.
        $sessionArray = array(
            'Email' => $data['Email']
        );

        // Check for existing member email address
        if($existingUser = DataObject::get_one('Member', "Email = '".Convert::raw2sql($data['Email'])."'")) {
            $form->AddErrorMessage('Email', _t('RegistrationPage.EmailValidationText', 'Sorry, that email address already exists. Please choose another.'), 'validation');
            Session::set('FormInfo.Form_RegistrationForm.data', $sessionArray);
            return $this->redirectBack();
        }

        // Otherwise create new member and log them in
        $Member = new Member();
        $form->saveInto($Member);
        $Member->write();
        $Member->login();

        // Find or create the 'user' group
        if(!$userGroup = DataObject::get_one('Group', "Code = 'users'")){
            $userGroup = new Group();
            $userGroup->Code = 'users';
            $userGroup->Title = 'Users';
            $userGroup->Write();
            $userGroup->Members()->add($Member);
        }
        // Add member to user group
        $userGroup->Members()->add($Member);

        // Get profile page otherwise display warning.
        if($ProfilePage = DataObject::get_one('EditProfilePage')){
            $this->setFlash(_t('RegistrationPage.RegisteredSuccessText', 'Welcome ' .$data['Email'].', your account has been created!'), 'success');
            return $this->redirect($ProfilePage->Link());
        }else{
            $this->setFlash(_t('RegistrationPage.RegisteredWarningText', 'Please add a "Edit Profile Page" in your SiteTree to enable profile editing'), 'warning');
            return $this->redirect(Director::absoluteBaseURL());
        }

    }

}