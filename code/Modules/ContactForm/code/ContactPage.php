<?php

/**
 * Class ContactPage
 */
class ContactPage extends Page {

    private static $icon = 'boilerplate/code/Modules/ContactForm/images/envelope-at-sign.png';

    private static $db = array(
        'MailTo'                => 'Varchar(100)',
        'MailCC'                => 'Text',
        'MailBCC'               => 'Text',
        'SubmitText'            => 'Text',
        'GoogleAPI'             => 'Varchar(255)',
        'Latitude'              => 'Varchar(255)',
        'Longitude'             => 'Varchar(255)',
        'MapColor'              => 'Varchar(255)',
        'WaterColor'            => 'Varchar(255)',
        'MapZoom'               => 'Int(14)',
        'MapSaturation'         => 'Int(0)',
        'MapMarker'             => 'Boolean(1)',
        'ReCaptchaSiteKey'      => 'Varchar(255)',
        'ReCaptchaSecretKey'    => 'Varchar(255)'
    );

    private static $defaults = array(
        'MapZoom'       => 14,
        'MapSaturation' => 0,
        'SubmitText'    => 'Thank you for contacting us, we will get back to you as soon as possible.'
    );

    private static $description = 'Contact form page';

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        /** =========================================
         * Settings
         ==========================================*/

        /** -----------------------------------------
         * Contact Page
        -------------------------------------------*/

        $fields->addFieldToTab('Root.Main', HeaderField::create('Settings'), 'Content');
        $fields->addFieldToTab('Root.Main', $mailTo = TextField::create('MailTo', 'Email'), 'Content');
        $mailTo->setRightTitle('Choose an email address for the contact page to send to');
        $fields->addFieldToTab('Root.Main', $mailCC = TextField::create('MailCC', 'Cc'), 'Content');
        $mailCC->setRightTitle('Choose an email, or emails to CC (separate emails with a comma and no space e.g: email1@website.com,email2@website.com)');
        $fields->addFieldToTab('Root.Main', $mailBCC = TextField::create('MailBCC', 'Bcc'), 'Content');
        $fields->addFieldToTab('Root.Main', $submissionText = TextareaField::create('SubmitText', 'Submission Text'), 'Content');
        $submissionText->setRightTitle('Text for contact form submission once the email has been sent i.e "Thank you for your enquiry"');
        $fields->addFieldToTab('Root.Main', HeaderField::create('', 'reCaptcha', 4), 'Content');
        $fields->addFieldToTab('Root.Main', LiteralField::create('',
            '<p>By filling in the Site Key, and Secret Key fields a reCaptcha field will be added to the form to protect against spam.</p>'
        ), 'Content');
        $fields->addFieldToTab('Root.Main', LiteralField::create('',
            '<div class="message"><p><strong>Note:</strong> you can get your SiteKey, and SecretKey at this address <a href="https://www.google.com/recaptcha/" target="_blank">https://www.google.com/recaptcha/</a></p></div>'
        ), 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('ReCaptchaSiteKey', 'Site Key'), 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('ReCaptchaSecretKey', 'Secret Key'), 'Content');

        /** -----------------------------------------
         * Google Map
        -------------------------------------------*/

        $fields->addFieldToTab('Root.Map', HeaderField::create('', 'Map'));
        $fields->addFieldToTab('Root.Map', LiteralField::create('',
            '<p>The map is displayed below the contact form. The Latitude and Longitude fields are required to be populated in order for the map to be displayed.</p>'
        ));
        $fields->addFieldToTab('Root.Map', Textfield::create('GoogleAPI', 'Maps API (Optional)'));
        $fields->addFieldToTab('Root.Map', Textfield::create('Latitude', 'Latitude'));
        $fields->addFieldToTab('Root.Map', Textfield::create('Longitude', 'Longitude'));
        $fields->addFieldToTab('Root.Map', LiteralField::create('', '<div class="field"><label class="right"><a href="https://support.google.com/maps/answer/18539" target="_blank">How do I find my latitude/longitude?</a></label></div>'));
        $fields->addFieldToTab('Root.Map', $mapZoom = NumericField::create('MapZoom', 'Zoom'));
        $mapZoom->setRightTitle('Zoom level: 1-22 - The higher the number the more zoomed in the map will be.');
        /**
         * If only one of the colours is set, display a warning.
         */
        if(!$this->MapColor && $this->WaterColor || $this->MapColor && !$this->WaterColor) {
            $fields->addFieldToTab('Root.Map', LiteralField::create('',
                '<div class="message warning"><p><strong>Note:</strong> To activate the map styling, both Map Colour and Water Colour must be set.</p></div>'
            ));
        }
        $fields->addFieldToTab('Root.Map', ColorField::create('MapColor', 'Map Colour (Optional)'));
        $fields->addFieldToTab('Root.Map', ColorField::create('WaterColor', 'Water Colour (Optional)'));
        $fields->addFieldToTab('Root.Map', $mapSaturation = TextField::create('MapSaturation', 'Saturation (Optional)'));
        $mapSaturation->setRightTitle('A range of -100 to 100, -100 being completely grayscale.');
        $fields->addFieldToTab('Root.Map', CheckboxField::create('MapMarker', 'Show map marker'));

        return $fields;

    }

}

class ContactPage_Controller extends Page_Controller {

    private static $allowed_actions = array('ContactForm');

    public function init() {

		parent::init();

        /**
         * reCaptcha
         */
        if($this->ReCaptchaSiteKey && $this->ReCaptchaSecretKey) {
            Requirements::javascript('https://www.google.com/recaptcha/api.js');
        }

        /**
         * Set defaults for map.
         */
        $latitude = ($this->Latitude ? $this->Latitude : "false");
        $longitude = ($this->Longitude ? $this->Longitude : "false");
        $mapColor = ($this->MapColor != '' ? "'".$this->MapColor."'" : "false");
        $waterColor = ($this->WaterColor != '' ? "'".$this->WaterColor."'" : "false");
        $mapMarker = ($this->MapMarker ? $this->MapMarker : "false");
        $mapZoom = ($this->MapZoom ? $this->MapZoom : 14);
        $mapSaturation = ($this->MapSaturation ? $this->MapSaturation : 0);

        /**
         * Map scripts
         */
        if($latitude && $longitude){
            Requirements::javascript('https://maps.googleapis.com/maps/api/js?key='.$this->GoogleAPI.'&sensor=false');
            Requirements::javascriptTemplate(CONTACT_FORM_MODULE_DIR.'/javascript/mapScript.js', array(
                'latitude' => $latitude,
                'longitude' => $longitude,
                'mapColor' => $mapColor,
                'waterColor' => $waterColor,
                'mapMarker' => $mapMarker,
                'mapZoom' => $mapZoom,
                'mapSaturation' => $mapSaturation
            ));
        }

	}

    /**
     * @return ContactForm
     */
    public function ContactForm() {
        return new ContactForm($this, 'ContactForm', array(
            'MailTo'                => $this->MailTo,
            'MailCC'                => $this->MailCC,
            'MailBCC'               => $this->MailBCC,
            'SubmitText'            => $this->SubmitText,
            'ReCaptchaSiteKey'      => $this->ReCaptchaSiteKey,
            'ReCaptchaSecretKey'    => $this->ReCaptchaSecretKey
        ));
    }

    /**
     * @return bool
     */
    public function Success() {
        return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
    }

}