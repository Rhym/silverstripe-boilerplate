<?php

/**
 * Class SecurityExtension
 */
class SecurityExtension extends Extension {

    public function onAfterInit(){

        /* =========================================
         * CSS
         =========================================*/

        /**
         * Add CSS to Login, and Lost Password pages.
         */
        if($action = $this->owner->getURLParams('Action')){
            if($action['Action'] =='lostpassword' || $action['Action'] == 'login'){
                Requirements::css(BOILERPLATE_MODULE.'/css/main.min.css');
            }
        }

    }

}