<?php

/**
 * Class MailChimpAction
 */
class MailChimpAction extends Page {}

class MailChimpAction_Controller extends Page_Controller {

    public function init() {
        parent::init();
        Requirements::css('boilerplate/css/colorpicker.css');
    }

}