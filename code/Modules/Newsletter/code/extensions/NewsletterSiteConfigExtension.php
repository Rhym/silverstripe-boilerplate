<?php

/**
 * Class NewsletterSiteConfigExtension
 */
class NewsletterSiteConfigExtension extends DataExtension {

    public static $db = array(
        'MailChimpAPI' => 'Text'
    );

    public static $defaults = array();

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {
        $fields->findOrMakeTab('Root.Settings.Newsletter', 'Newsletter');
        $fields->addFieldsToTab('Root.Settings.Newsletter',
            array(
                new TextField('MailChimpAPI')
            )
        );
    }

}