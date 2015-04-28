<?php

/**
 * Class RegistrationPage
 */
class RegistrationPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Registration/images/user--plus.png';
    private static $description = 'Registration content page';

}

/**
 * Class RegistrationPage_Controller
 */
class RegistrationPage_Controller extends Page_Controller {

    private static $allowed_actions = array('RegistrationForm');

    /**
     * @return RegistrationForm
     */
    public function RegistrationForm(){
        /**
         * If the user is logged in, redirect to the Homepage with an alert message prompting logout.
         */
        if($member = Member::currentUser()){
            return '<div class="alert alert-warning">You\'re currently logged in as <strong>'.$member->Name.'</strong>. To register as a different user <a href="'.Director::absoluteBaseURL().'Security/logout?BackURL='.$this->Link().'">log out.</a></div>';
        } else {
            return new RegistrationForm($this, 'RegistrationForm');
        }
    }

}