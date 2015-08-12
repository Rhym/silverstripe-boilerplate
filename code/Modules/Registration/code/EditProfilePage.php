<?php

/**
 * Class EditProfilePage
 */
class EditProfilePage extends Page
{

    /**
     * @var string
     */
    private static $icon = 'boilerplate/code/Modules/Registration/images/user--pencil.png';

    /**
     * @var string
     */
    private static $description = 'Edit profile content page';

}

/**
 * Class EditProfilePage_Controller
 */
class EditProfilePage_Controller extends Page_Controller
{

    private static $allowed_actions = array('Form');

    /**
     * @return EditProfilePage|SS_HTTPResponse
     */
    public function Form()
    {
        if (!Member::currentUser()) {
            return Security::PermissionFailure($this->controller, null);
        } else {
            $form = EditProfileForm::create($this, 'Form');;
            $this->extend('updateEditProfileForm', $form);
            return $form;
        }
    }

}
