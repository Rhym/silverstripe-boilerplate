<?php

/**
 * Class BoilerplateSiteConfigExtension
 *
 * @property string Phone
 * @property string Email
 * @property string Address
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
class BoilerplateSiteConfigExtension extends DataExtension {

    public static $db = array(
        'Phone'                     => 'Varchar(255)',
        'Email'                     => 'Varchar(255)',
        'Address'                   => 'Text',
        'TrackingCode'              => 'Text',
        'TagManager'                => 'Boolean',
        'GoogleSiteVerification'    => 'Text',
        'Facebook'                  => 'Varchar(255)',
        'Twitter'                   => 'Varchar(255)',
        'Youtube'                   => 'Varchar(255)',
        'GooglePlus'                => 'Varchar(255)'
    );

    public static $has_one = array(
        'LogoImage'         => 'Image',
        'MobileLogoImage'   => 'Image',
        'Favicon'           => 'Image'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {
        /** =========================================
         * @var UploadField     $logo
         * @var UploadField     $mobileLogo
         * @var UploadField     $favicon
         * @var TextareaField   $address
         * @var TextareaField   $googleSiteVerification
         * @var TextareaField   $trackingCode
         * @var FieldGroup      $tagManagerFieldGroup
        ===========================================*/

        /** -----------------------------------------
         * Settings
        -------------------------------------------*/

        if (!$fields->fieldByName('Root.Settings')){
            $fields->addFieldToTab('Root', TabSet::create('Settings'));
        }

        /** -----------------------------------------
         * Images
        -------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Images', 'Images');
        $fields->addFieldsToTab('Root.Settings.Images',
            array(
                $logo = UploadField::create('LogoImage', 'Logo'),
                $mobileLogo = UploadField::create('MobileLogoImage', 'Mobile Menu Logo'),
                $favicon = UploadField::create('Favicon', 'Favicon')
            )
        );
        $logo->setRightTitle('Choose an Image For Your Logo');
        $mobileLogo->setRightTitle('(optional) Choose a Logo to Display in the Pop-out Menu');
        $favicon->setRightTitle('Choose an Image For Your Favicon (16x16)');

        /** -----------------------------------------
         * Company Details
        -------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Details', 'Details');
        $fields->addFieldsToTab('Root.Settings.Details',
            array(
                Textfield::create('Phone', 'Phone Number'),
                Textfield::create('Email', 'Public Email Address'),
                $address = TextareaField::create('Address', 'Address'),
                HeaderField::create('', 'Social Media'),
                TextField::create('Facebook'),
                TextField::create('Twitter'),
                TextField::create('Youtube'),
                TextField::create('GooglePlus', 'Google+'),
            )
        );
        $address->setRows(8);

        /** -----------------------------------------
         * Analytics
        -------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Analytics', 'Analytics');
        $fields->addFieldsToTab('Root.Settings.Analytics',
            array(
                $googleSiteVerification = TextareaField::create('GoogleSiteVerification', 'Google Site Verification Code'),
                $trackingCode = TextareaField::create('TrackingCode', 'Tracking Code'),
                $tagManagerFieldGroup = FieldGroup::create(
                    $tagManager = CheckboxField::create('TagManager', 'Does the tracking code above contain Google Tag Manager?')
                )
            )
        );
        $googleSiteVerification->setRows(2);
        $trackingCode->setRows(20);
        $tagManagerFieldGroup->setTitle('Tag Manager');

    }

    /**
     * @return string
     */
    public function getFormattedPhone() {
        if ($phone = (string)SiteConfig::current_site_config()->Phone) {
            return preg_replace('/\s+/', '', $phone);
        }
        return false;
    }

}