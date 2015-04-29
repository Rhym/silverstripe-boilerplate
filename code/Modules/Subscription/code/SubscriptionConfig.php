<?php

/**
 * Class SubscriptionConfig
 */
class SubscriptionConfig extends DataExtension {

    public static $db = array(
        'MailChimpAPI' => 'Varchar(255)',
        'MailChimpListID' => 'Varchar(255)',
        'MailChimpSuccessMessage' => 'Text'
    );

    public static $defaults = array(
        'MailChimpSuccessMessage' => 'Your subscription has been received, you will be sent a confirmation email shortly.'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {

        /** -----------------------------------------
         * Subscription
        -------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Subscription', 'Subscription');
        $fields->addFieldsToTab('Root.Settings.Subscription',
            array(
                new HeaderField('', 'Newsletter Subscription'),
                new LiteralField('',
                    '<p>The API key, and list ID are necessary for the Newsletter Subscription form to function.</p>'
                ),
                $mailChimpAPI = new TextField('MailChimpAPI', 'API Key'),
                new TextField('MailChimpListID', 'List ID'),
                $mailChimpSuccessMessage = new TextareaField('MailChimpSuccessMessage', 'Success Message (optional)')
            )
        );
        $mailChimpAPI->setRightTitle('<a href="https://us9.admin.mailchimp.com/account/api-key-popup/" target="_blank"><i>How do I get my MailChimp API Key?</i></a>');
        $mailChimpSuccessMessage->setRows(2);
        $mailChimpSuccessMessage->setRightTitle('Message displayed when a user has successfully subscribed to a list.');

    }

}