<?php

/**
 * Class ContactPage
 *
 * @property string MailTo
 * @property string MailCC
 * @property string MailBCC
 * @property string SubmitText
 * @property string GoogleAPI
 * @property string Latitude
 * @property string Longitude
 * @property string MapColor
 * @property string WaterColor
 * @property string MapZoom
 * @property string MapSaturation
 * @property string MapMarker
 * @property string ReCaptchaSiteKey
 * @property string ReCaptchaSecretKey
 */
class ContactPage extends Page
{
    /**
     * @var string
     */
    private static $icon = 'boilerplate/code/Modules/ContactForm/images/envelope-at-sign.png';

    /**
     * @var array
     */
    private static $db = array(
        'MailTo' => 'Varchar(100)',
        'MailCC' => 'Text',
        'MailBCC' => 'Text',
        'SubmitText' => 'Text',
        'GoogleAPI' => 'Varchar(100)',
        'Latitude' => 'Varchar(100)',
        'Longitude' => 'Varchar(100)',
        'MapColor' => 'Varchar(7)',
        'WaterColor' => 'Varchar(7)',
        'MapZoom' => 'Int(14)',
        'MapSaturation' => 'Int(0)',
        'MapMarker' => 'Boolean(1)',
        'ReCaptchaSiteKey' => 'Varchar(100)',
        'ReCaptchaSecretKey' => 'Varchar(100)'
    );

    /**
     * @var array
     */
    private static $defaults = array(
        'MapZoom' => 14,
        'MapSaturation' => 0,
        'SubmitText' => 'Thank you for contacting us, we will get back to you as soon as possible.'
    );

    /**
     * @var string
     */
    private static $description = 'Contact form page';

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** @var  $fields */
        $fields = parent::getCMSFields();

        /** =========================================
         * Settings
         * ==========================================*/

        /** -----------------------------------------
         * Contact Page
         * ----------------------------------------*/

        $fields->addFieldToTab('Root.Main',
            HeaderField::create('Settings', _t('ContactPage.SettingsHeading', 'Settings')), 'Content');
        /** @var TextField $mailTo */
        $fields->addFieldToTab('Root.Main', $mailTo = TextField::create('MailTo', _t('ContactPage.Email', 'Email')),
            'Content');
        $mailTo->setRightTitle('Choose an email address for the contact page to send to');
        /** @var TextField $mailCC */
        $fields->addFieldToTab('Root.Main', $mailCC = TextField::create('MailCC', _t('ContactPage.MailCC', 'Cc')),
            'Content');
        $mailCC->setRightTitle(_t('ContactPage.MailCCRightTitle',
            'Choose an email, or emails to CC (separate emails with a comma and no space e.g: email1@website.com,email2@website.com)'));
        /** @var TextField $mailBCC */
        $fields->addFieldToTab('Root.Main', $mailBCC = TextField::create('MailBCC', _t('ContactPage.MailBCC', 'Bcc')),
            'Content');
        /** @var TextareaField $submissionText */
        $fields->addFieldToTab('Root.Main',
            $submissionText = TextareaField::create('SubmitText', _t('ContactPage.SubmitText', 'Submission Text')),
            'Content');
        $submissionText->setRightTitle(_t('ContactPage.SubmitTextRightTitle',
            'Text for contact form submission once the email has been sent i.e "Thank you for your enquiry"'));
        $fields->addFieldToTab('Root.Main',
            HeaderField::create('RecaptchaHeading', _t('ContactPage.RecaptchaHeading', 'reCaptcha'), 4), 'Content');
        $fields->addFieldToTab('Root.Main', LiteralField::create('RecaptchaDescription',
            _t('ContactPage.RecaptchaDescription',
                '<p>By filling in the Site Key, and Secret Key fields a reCaptcha field will be added to the form to protect against spam.</p>')
        ), 'Content');
        $fields->addFieldToTab('Root.Main', LiteralField::create('RecaptchaDescriptionInstructions',
            _t('ContactPage.RecaptchaDescriptionInstructions',
                '<div class="message"><p><strong>Note:</strong> you can get your SiteKey, and SecretKey at this address <a href="https://www.google.com/recaptcha/" target="_blank">https://www.google.com/recaptcha/</a></p></div>')
        ), 'Content');
        $fields->addFieldToTab('Root.Main',
            TextField::create('ReCaptchaSiteKey', _t('ContactPage.RecaptchaSiteKey', 'Site Key')), 'Content');
        $fields->addFieldToTab('Root.Main',
            TextField::create('ReCaptchaSecretKey', _t('ContactPage.RecaptchaSecretKey', 'Secret Key')), 'Content');

        /** -----------------------------------------
         * Google Map
         * ----------------------------------------*/

        $fields->addFieldToTab('Root.Map', HeaderField::create('MapHeading', _t('ContactPage.MapHeading', 'Map')));
        $fields->addFieldToTab('Root.Map', LiteralField::create('MapDescription',
            _t('ContactPage.MapDescription',
                '<p>The Latitude and Longitude fields are required to be populated in order for the map to be displayed.</p>')
        ));
        $fields->addFieldToTab('Root.Map',
            Textfield::create('GoogleAPI', _t('ContactPage.GoogleAPI', 'Maps API (Optional)')));
        $fields->addFieldToTab('Root.Map', Textfield::create('Latitude', _t('ContactPage.Latitude', 'Latitude')));
        $fields->addFieldToTab('Root.Map', Textfield::create('Longitude', _t('ContactPage.Longitude', 'Longitude')));
        $fields->addFieldToTab('Root.Map', LiteralField::create('MapDescriptionInstructions',
            _t('ContactPage.MapDescriptionInstructions',
                '<div class="field"><label class="right"><a href="https://support.google.com/maps/answer/18539" target="_blank">How do I find my latitude/longitude?</a></label></div>')));
        /** @var NumericField $mapZoom */
        $fields->addFieldToTab('Root.Map', $mapZoom = NumericField::create('MapZoom', _t('ContactPage.Zoom', 'Zoom')));
        $mapZoom->setRightTitle(_t('ContactPage.Zoom',
            'Zoom level: 1-22 - The higher the number the more zoomed in the map will be.'));
        /**
         * If only one of the colours is set, display a warning.
         */
        if (!$this->MapColor && $this->WaterColor || $this->MapColor && !$this->WaterColor) {
            $fields->addFieldToTab('Root.Map', LiteralField::create('MApColorWarning',
                _t('ContactPage.MapColorWarning',
                    '<div class="message warning"><p><strong>Note:</strong> To activate the map styling, both Map Colour and Water Colour must be set.</p></div>')
            ));
        }
        $fields->addFieldToTab('Root.Map',
            ColorField::create('MapColor', _t('ContactPage.MapColor', 'Map Colour (Optional)')));
        $fields->addFieldToTab('Root.Map',
            ColorField::create('WaterColor', _t('ContactPage.WaterColor', 'Water Colour (Optional)')));
        /** @var TextField $mapSaturation */
        $fields->addFieldToTab('Root.Map',
            $mapSaturation = TextField::create('MapSaturation',
                _t('ContactPage.MapSaturation', 'Saturation (Optional)')));
        $mapSaturation->setRightTitle(_t('ContactPage.MapSaturationRightTitle',
            'A range of -100 to 100, -100 being completely grayscale.'));
        $fields->addFieldToTab('Root.Map',
            CheckboxField::create('MapMarker', _t('ContactPage.MapMarker', 'Show map marker')));

        return $fields;

    }

}

/**
 * Class ContactPage_Controller
 */
class ContactPage_Controller extends Page_Controller
{
    /**
     * @var array
     */
    private static $allowed_actions = array('ContactForm');

    public function init()
    {
        parent::init();

        /** reCaptcha */
        if ($this->ReCaptchaSiteKey && $this->ReCaptchaSecretKey) {
            Requirements::javascript('https://www.google.com/recaptcha/api.js');
        }

        /** Set defaults for map. */
        $latitude = ($this->Latitude ? $this->Latitude : "false");
        $longitude = ($this->Longitude ? $this->Longitude : "false");
        $mapColor = ($this->MapColor != '' ? "'" . $this->MapColor . "'" : "false");
        $waterColor = ($this->WaterColor != '' ? "'" . $this->WaterColor . "'" : "false");
        $mapMarker = ($this->MapMarker ? $this->MapMarker : "false");
        $mapZoom = ($this->MapZoom ? $this->MapZoom : 14);
        $mapSaturation = ($this->MapSaturation ? $this->MapSaturation : 0);

        /** Map scripts */
        if ($latitude && $longitude) {
            Requirements::javascript('https://maps.googleapis.com/maps/api/js?key=' . $this->GoogleAPI . '&sensor=false');
            Requirements::javascriptTemplate(CONTACT_FORM_MODULE_DIR . '/javascript/mapScript.js', array(
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
    public function ContactForm()
    {
        $form = new ContactForm($this, 'ContactForm', array(
            'MailTo' => $this->MailTo,
            'MailCC' => $this->MailCC,
            'MailBCC' => $this->MailBCC,
            'SubmitText' => $this->SubmitText,
            'ReCaptchaSiteKey' => $this->ReCaptchaSiteKey,
            'ReCaptchaSecretKey' => $this->ReCaptchaSecretKey
        ));
        $this->extend('updateContactForm', $form);
        return $form;
    }

    /**
     * @return bool
     */
    public function Success()
    {
        return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
    }

}
