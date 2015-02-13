<?php

/**
 * Class NewsletterHolder
 */
class NewsletterHolder extends Page {

    private static $icon = 'boilerplate/code/Modules/Newsletter/images/newspaper.png';

    private static $description = 'Newsletter Holder Page';

    private static $can_be_root = false;

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }

}

class NewsletterHolder_Controller extends Page_Controller {}