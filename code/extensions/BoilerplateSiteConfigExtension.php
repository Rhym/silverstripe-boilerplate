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
        /** @var UploadField $favicon */
        $fields->addFieldsToTab('Root.Settings.Images',
            array(
                HeaderField::create('ImagesTabHeading',
                    _t('BoilerplateSiteConfigExtension.ImagesTabHeading', 'Images')),
                $logo = UploadField::create('LogoImage', _t('BoilerplateSiteConfigExtension.Logo', 'Logo')),
                $mobileLogo = UploadField::create('MobileLogoImage',
                    _t('BoilerplateSiteConfigExtension.MobileLogoImage', 'Mobile Menu Logo (optional)')),
                $favicon = UploadField::create('Favicon', _t('BoilerplateSiteConfigExtension.Favicon', 'Favicon'))
            )
        );
        $favicon->setRightTitle(_t('BoilerplateSiteConfigExtension.FaviconRightTitle',
            'Choose an Image For Your Favicon (16px by 16px)'));

        /** -----------------------------------------
         * Company Details
         * ----------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Details', 'Details');
        /**
         * @var TextareaField $address
         * @var TextareaField $postalAddress
         * @var TextareaField $directions
         */
        $fields->addFieldsToTab('Root.Settings.Details',
            array(
                HeaderField::create('DetailsTabHeading',
                    _t('BoilerplateSiteConfigExtension.DetailsTabHeading', 'General')),
                Textfield::create('Phone', _t('BoilerplateSiteConfigExtension.Phone', 'Phone Number')),
                Textfield::create('Email', _t('BoilerplateSiteConfigExtension.Email', 'Public Email Address')),
                $address = TextareaField::create('Address', _t('BoilerplateSiteConfigExtension.Address', 'Address')),
                $postalAddress = TextareaField::create('PostalAddress',
                    _t('BoilerplateSiteConfigExtension.PostalAddress', 'Postal Address')),
                $directions = TextareaField::create('Directions',
                    _t('BoilerplateSiteConfigExtension.Directions', 'Google Map Directions')),
                HeaderField::create('DetailsTabSocialMediaHeading',
                    _t('BoilerplateSiteConfigExtension.DetailsTabSocialMediaHeading', 'Social Media')),
                TextField::create('Facebook', _t('BoilerplateSiteConfigExtension.Facebook', 'Facebook')),
                TextField::create('Twitter', _t('BoilerplateSiteConfigExtension.Twitter', 'Twitter')),
                TextField::create('Youtube', _t('BoilerplateSiteConfigExtension.Youtube', 'Youtube')),
                TextField::create('GooglePlus', _t('BoilerplateSiteConfigExtension.GooglePlus', 'Google+')),
            )
        );
        $address->setRows(8);
        $postalAddress->setRows(8);
        $directions->setRows(3);
        $directions->setRightTitle(_t('DirectionsRightTitle',
            'The URL of the Address on <a href="https://www.google.com/maps" title="Google Maps" rel="nofollow" target="_blank">Google Maps</a>. This is useful for users on mobile granting the ability to open directions in their native applications.'));

        /** -----------------------------------------
         * Analytics
         * ----------------------------------------*/

        if (Permission::check('ADMIN')) {
            $fields->findOrMakeTab('Root.Settings.Analytics', 'Analytics');
            /**
             * @var TextareaField $googleSiteVerification
             * @var TextareaField $trackingCode
             * @var TextareaField $tagManagerFieldGroup
             */
            $fields->addFieldsToTab('Root.Settings.Analytics',
                array(
                    HeaderField::create('', 'Analytics'),
                    $googleSiteVerification = TextareaField::create('GoogleSiteVerification',
                        _t('BoilerplateSiteConfigExtension.GoogleSiteVerification', 'Google Site Verification Code')),
                    $trackingCode = TextareaField::create('TrackingCode',
                        _t('BoilerplateSiteConfigExtension.TrackingCode', 'Tracking Code')),
                    $tagManagerFieldGroup = FieldGroup::create(
                        CheckboxField::create('TagManager',
                            _t('BoilerplateSiteConfigExtension.TagManager',
                                'Does the tracking code above contain Google Tag Manager?'))
                    )
                )
            );
            $googleSiteVerification->setRows(2);
            $trackingCode->setRows(20);
            $tagManagerFieldGroup->setTitle(_t('BoilerplateSiteConfigExtension.TagManagerRightTitle', 'Tag Manager'));
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
