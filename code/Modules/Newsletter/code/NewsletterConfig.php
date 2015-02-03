<?php
//
//class NewsletterConfig extends DataExtension {
//
//    public static $db = array(
//        'MailChimpAPI' => 'Varchar(255)'
//    );
//
//    public static $defaults = array();
//
//    public function updateCMSFields(FieldList $fields) {
//
//        /* -----------------------------------------
//         * MailChimp
//        ------------------------------------------*/
//
//        $toggleFields = ToggleCompositeField::create(
//            'Newsletter',
//            'Newsletter',
//            array(
//                new TextField('MailChimpAPI', 'MailChimp API')
//            )
//        )->setHeadingLevel(4)->setStartClosed(true);
//        $fields->addFieldToTab('Root.'.SiteConfig::current_site_config()->Title.'Settings', $toggleFields);
//
//    }
//
//}