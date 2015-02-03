<?php

/**
 * Class NewsletterPage
 */
class NewsletterPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Newsletter/images/newspaper.png';

    private static $db = array();

    private static $description = 'Newsletter Page';

    private static $allowed_children = 'none';

    private static $can_be_root = false;

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }

}

class NewsletterPage_Controller extends Page_Controller {}