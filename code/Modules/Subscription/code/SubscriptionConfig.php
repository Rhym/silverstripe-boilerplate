<?php

/**
 * Class SubscriptionConfig
 *
 * @property string MailChimpAPI
 * @property string MailChimpListID
 * @property string MailChimpSuccessMessage
 */
class SubscriptionConfig extends DataExtension {

    public static $db = array(
        'MailChimpAPI'              => 'Varchar(255)',
        'MailChimpListID'           => 'Varchar(255)',
        'MailChimpSuccessMessage'   => 'Text'
    );

    public static $defaults = array(
        'MailChimpSuccessMessage' => 'Your subscription has been received, you will be sent a confirmation email shortly.'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {
        /** =========================================
         * @var TextField       $mailChimpAPI
         * @var TextareaField   $mailChimpSuccessMessage
        ===========================================*/

        /** -----------------------------------------
         * Subscription
        -------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Subscription', 'Subscription');
        $fields->addFieldsToTab('Root.Settings.Subscription',
            array(
                HeaderField::create('', 'Newsletter Subscription'),
                LiteralField::create('',
                    '<p>The API key, and list ID are necessary for the Newsletter Subscription form to function.</p>'
                ),
                $mailChimpAPI = TextField::create('MailChimpAPI', 'API Key'),
                TextField::create('MailChimpListID', 'List ID'),
                $mailChimpSuccessMessage = TextareaField::create('MailChimpSuccessMessage', 'Success Message (optional)')
            )
        );
        $mailChimpAPI->setRightTitle('<a href="https://us9.admin.mailchimp.com/account/api-key-popup/" target="_blank"><i>How do I get my MailChimp API Key?</i></a>');
        $mailChimpSuccessMessage->setRows(2);
        $mailChimpSuccessMessage->setRightTitle('Message displayed when a user has successfully subscribed to a list.');

    }

}