<?php

/**
 * Class BoilerplateSiteConfigExtension
 *
 * @property string Phone
 * @property string Email
 * @property string Address
 * @property string PostalAddress
 * @property string Directions
 * @property string TrackingCode
 * @property boolean TagManager
 * @property string GoogleSiteVerification
 * @property string Facebook
 * @property string Twitter
 * @property string Youtube
 * @property string GooglePlus
 * @method Image LogoImage
 * @method Image MobileLogoImage
 * @method Image Favicon
 */
class BoilerplateSiteConfigExtension extends DataExtension
{

    /**
     * @var array
     */
    public static $db = array(
        'Phone' => 'Varchar(255)',
        'Email' => 'Varchar(255)',
        'Address' => 'Text',
        'PostalAddress' => 'Text',
        'Directions' => 'Text',
        'TrackingCode' => 'Text',
        'TagManager' => 'Boolean',
        'GoogleSiteVerification' => 'Text',
        'Facebook' => 'Varchar(255)',
        'Twitter' => 'Varchar(255)',
        'Youtube' => 'Varchar(255)',
        'GooglePlus' => 'Varchar(255)'
    );

    /**
     * @var array
     */
    public static $has_one = array(
        'LogoImage' => 'Image',
        'MobileLogoImage' => 'Image',
        'Favicon' => 'Image'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        /** =========================================
         * @var UploadField $logo
         * @var UploadField $mobileLogo
         * @var UploadField $favicon
         * @var TextareaField $address
         * @var TextareaField $postalAddress
         * @var TextareaField $directions
         * @var TextareaField $googleSiteVerification
         * @var TextareaField $trackingCode
         * @var FieldGroup $tagManagerFieldGroup
        ===========================================*/

        /** -----------------------------------------
         * Settings
         * ----------------------------------------*/

        if (!$fields->fieldByName('Root.Settings')) {
            $fields->addFieldToTab('Root', TabSet::create('Settings'));
        }

        /** -----------------------------------------
         * Images
         * ----------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Images', 'Images');
        $fields->addFieldsToTab('Root.Settings.Images',
            array(
                HeaderField::create('', 'Images'),
                $logo = UploadField::create('LogoImage', 'Logo'),
                $mobileLogo = UploadField::create('MobileLogoImage', 'Mobile Menu Logo (optional)'),
                $favicon = UploadField::create('Favicon', 'Favicon')
            )
        );
        $favicon->setRightTitle('Choose an Image For Your Favicon (16px by 16px)');

        /** -----------------------------------------
         * Company Details
         * ----------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Details', 'Details');
        $fields->addFieldsToTab('Root.Settings.Details',
            array(
                HeaderField::create('', 'General'),
                Textfield::create('Phone', 'Phone Number'),
                Textfield::create('Email', 'Public Email Address'),
                $address = TextareaField::create('Address'),
                $postalAddress = TextareaField::create('PostalAddress'),
                $directions = TextareaField::create('Directions', 'Google Map Directions'),
                HeaderField::create('', 'Social Media'),
                TextField::create('Facebook'),
                TextField::create('Twitter'),
                TextField::create('Youtube'),
                TextField::create('GooglePlus', 'Google+'),
            )
        );
        $address->setRows(8);
        $postalAddress->setRows(8);
        $directions->setRows(3);
        $directions->setRightTitle('The URL of the Address on <a href="https://www.google.com/maps" title="Google Maps" rel="nofollow" target="_blank">Google Maps</a>. This is useful for users on mobile granting the ability to open directions in their native applications.');

        /** -----------------------------------------
         * Analytics
         * ----------------------------------------*/

        if (Permission::check('ADMIN')) {
            $fields->findOrMakeTab('Root.Settings.Analytics', 'Analytics');
            $fields->addFieldsToTab('Root.Settings.Analytics',
                array(
                    HeaderField::create('', 'Analytics'),
                    $googleSiteVerification = TextareaField::create('GoogleSiteVerification',
                        'Google Site Verification Code'),
                    $trackingCode = TextareaField::create('TrackingCode', 'Tracking Code'),
                    $tagManagerFieldGroup = FieldGroup::create(
                        $tagManager = CheckboxField::create('TagManager',
                            'Does the tracking code above contain Google Tag Manager?')
                    )
                )
            );
            $googleSiteVerification->setRows(2);
            $trackingCode->setRows(20);
            $tagManagerFieldGroup->setTitle('Tag Manager');
        }

    }

    /**
     * @return bool|mixed
     */
    public function getFormattedPhone()
    {
        if ($phone = (string)SiteConfig::current_site_config()->Phone) {
            return preg_replace('/\s+/', '', $phone);
        }
        return false;
    }

}
