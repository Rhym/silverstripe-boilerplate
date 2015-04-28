<?php

/**
 * Class EditProfilePage
 */
class EditProfilePage extends Page {

    private static $icon = 'boilerplate/code/Modules/Registration/images/user--pencil.png';
    private static $description = 'Edit profile content page';

}

/**
 * Class EditProfilePage_Controller
 */
class EditProfilePage_Controller extends Page_Controller {

    private static $allowed_actions = array('EditProfileForm');

    /**
     * @return EditProfilePage|SS_HTTPResponse
     */
    public function EditProfileForm() {
        if(!Member::currentUser()) {
            return Security::PermissionFailure($this->controller, null);
        } else {
            return new EditProfileForm($this, 'EditProfileForm');
        }
    }

}