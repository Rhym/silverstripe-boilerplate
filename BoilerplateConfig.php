<?php

/**
 * Class BoilerplateConfig
 */
class BoilerplateConfig extends DataExtension {

    public static $db = array(
		'Phone' => 'Varchar(255)',
		'Email' => 'Varchar(255)',
        'Address' => 'Text',
        'TrackingCode' => 'Text',
        'TagManager' => 'Boolean',
        'GoogleSiteVerification' => 'Text',
        'Facebook' => 'Varchar(255)',
        'Twitter' => 'Varchar(255)',
        'Youtube' => 'Varchar(255)',
        'GooglePlus' => 'Varchar(255)'
	);

	public static $has_one = array(
		'LogoImage' => 'Image',
		'MobileLogoImage' => 'Image',
		'Favicon' => 'Image'
	);

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {

        /* =========================================
         * Settings
         =========================================*/

        if (!$fields->fieldByName('Root.Settings')){
            $fields->addFieldToTab('Root', new TabSet('Settings'));
        }

        /* -----------------------------------------
         * Images
        ------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Images', 'Images');
        $fields->addFieldsToTab('Root.Settings.Images',
            array(
                $logo = new UploadField('LogoImage', _t('BoilerplateConfig.LogoImageLabel', 'Logo')),
                $mobileLogo = new UploadField('MobileLogoImage', _t('BoilerplateConfig.MobileLogoImageLabel', 'Mobile Menu Logo')),
                $favicon = new UploadField('Favicon', _t('BoilerplateConfig.FaviconLabel', 'Favicon'))
            )
        );
        $logo->setRightTitle('Choose an Image For Your Logo');
        $mobileLogo->setRightTitle('(optional) Choose a Logo to Display in the Pop-out Menu');
        $favicon->setRightTitle('Choose an Image For Your Favicon (16x16)');

        /* -----------------------------------------
         * Company Details
        ------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Details', 'Details');
        $fields->addFieldsToTab('Root.Settings.Details',
            array(
                new Textfield('Phone', _t('BoilerplateConfig.PhoneLabel', 'Phone Number')),
                new Textfield('Email', _t('BoilerplateConfig.EmailLabel', 'Public Email Address')),
                $address = new TextareaField('Address', _t('BoilerplateConfig.AddressLabel', 'Address')),
                new HeaderField('', 'Social Media'),
                new TextField('Facebook'),
                new TextField('Twitter'),
                new TextField('Youtube'),
                new TextField('GooglePlus', 'Google+'),
            )
        );
        $address->setRows(8);

        /* -----------------------------------------
         * Analytics
        ------------------------------------------*/

        $fields->findOrMakeTab('Root.Settings.Analytics', 'Analytics');
        $fields->addFieldsToTab('Root.Settings.Analytics',
            array(
                $googleSiteVerification = new TextareaField('GoogleSiteVerification', _t('BoilerplateConfig.GoogleSiteVerificationLabel', 'Google Site Verification Code')),
                $trackingCode = new TextareaField('TrackingCode', _t('BoilerplateConfig.TrackingCodeLabel', 'Tracking Code')),
                $tagManager = new CheckboxField('TagManager', 'Does the tracking code above contain Google Tag Manager?')
            )
        );
        $googleSiteVerification->setRows(2);
        $trackingCode->setRows(20);

    }

}