<?php

/**
 * Class ContactPage
 */
class ContactPage extends Page {

    private static $icon = 'boilerplate/code/Modules/ContactForm/images/envelope-at-sign.png';

    private static $db = array(
        'MailTo' => 'Varchar(100)',
        'MailCC' => 'Text',
        'MailBCC' => 'Text',
        'SubmitText' => 'Text',
        'GoogleAPI' => 'Varchar(255)',
        'Latitude' => 'Varchar(255)',
        'Longitude' => 'Varchar(255)',
        'MapColor' => 'Varchar(255)',
        'WaterColor' => 'Varchar(255)',
        'MapZoom' => 'Int(14)',
        'MapSaturation' => 'Varchar(4)',
        'MapMarker' => 'Boolean(1)',
        'ReCaptchaSiteKey' => 'Varchar(255)',
        'ReCaptchaSecretKey' => 'Varchar(255)'
    );

    private static $has_many = array(
        'InfoWindows' => 'InfoWindow'
    );

    private static $defaults = array(
        'MapZoom' => 14,
        'MapSaturation' => 0,
        'SubmitText' => 'Thank you for contacting us, we will get back to you as soon as possible.'
    );

    private static $description = 'Contact form page';

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        /* =========================================
         * Settings
         =========================================*/

        /* -----------------------------------------
         * Contact Page
        ------------------------------------------*/

        $fields->addFieldToTab('Root.Main', new HeaderField('Settings'), 'Content');
        $fields->addFieldToTab('Root.Main', $mailTo = new TextField('MailTo', 'Email'), 'Content');
        $mailTo->setRightTitle('Choose an email address for the contact page to send to');
        $fields->addFieldToTab('Root.Main', $mailCC = new TextField('MailCC', 'Cc'), 'Content');
        $mailCC->setRightTitle('Choose an email, or emails to CC (separate emails with a comma and no space e.g: email1@website.com,email2@website.com)');
        $fields->addFieldToTab('Root.Main', $mailBCC = new TextField('MailBCC', 'Bcc'), 'Content');
        $fields->addFieldToTab('Root.Main', $submissionText = new TextareaField('SubmitText', 'Submission Text'), 'Content');
        $submissionText->setRightTitle('Text for contact form submission once the email has been sent i.e "Thank you for your enquiry"');
        $fields->addFieldToTab('Root.Main', new HeaderField('', 'reCaptcha', 4), 'Content');
        $fields->addFieldToTab('Root.Main', new LiteralField('',
            '<p>By filling in the Site Key, and Secret Key fields a reCaptcha field will be added to the form to protect against spam.</p>'
        ), 'Content');
        $fields->addFieldToTab('Root.Main', new LiteralField('',
            '<div class="message"><p><strong>Note:</strong> you can get your SiteKey, and SecretKey at this address <a href="https://www.google.com/recaptcha/" target="_blank">https://www.google.com/recaptcha/</a></p></div>'
        ), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('ReCaptchaSiteKey', 'Site Key'), 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('ReCaptchaSecretKey', 'Secret Key'), 'Content');

        /* -----------------------------------------
         * Google Map
        ------------------------------------------*/

        $fields->addFieldToTab('Root.Map', new HeaderField('', 'Map'));
        $fields->addFieldToTab('Root.Map', new LiteralField('',
            '<p>The map is displayed below the contact form. The Latitude and Longitude fields are required to be populated in order for the map to be displayed.</p>'
        ));
        $fields->addFieldToTab('Root.Map', new Textfield('GoogleAPI', 'Maps API (Optional)'));
        $fields->addFieldToTab('Root.Map', new Textfield('Latitude', 'Latitude'));
        $fields->addFieldToTab('Root.Map', new Textfield('Longitude', 'Longitude'));
        $fields->addFieldToTab('Root.Map', new LiteralField('', '<div class="field"><label class="right"><a href="https://support.google.com/maps/answer/18539" target="_blank">How do I find my latitude/longitude?</a></label></div>'));
        $fields->addFieldToTab('Root.Map', $mapZoom = new NumericField('MapZoom', 'Zoom'));
        $mapZoom->setRightTitle('Zoom level: 0-22 - The higher the number the more zoomed in the map will be.');
        $fields->addFieldToTab('Root.Map', new ColorField('MapColor', 'Map Colour (Optional)'));
        $fields->addFieldToTab('Root.Map', new ColorField('WaterColor', 'Water Colour (Optional)'));
        $fields->addFieldToTab('Root.Map', $mapSaturation = new TextField('MapSaturation', 'Saturation (Optional)'));
        $mapSaturation->setRightTitle('A range of -100 to 100, -100 being completely grayscale.');
        $fields->addFieldToTab('Root.Map', new CheckboxField('MapMarker', 'Show map marker'));

        /* -----------------------------------------
         * Info Windows
        ------------------------------------------*/

        $fields->addFieldToTab('Root.MapMarkers', new HeaderField('', 'Map Markers'));
        $fields->addFieldToTab('Root.MapMarkers', new LiteralField('',
            '<p>Map markers are used to display points of interest on your map.</p>'
        ));
        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldDeleteAction());
        $config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
            'Title' => 'Title'
        ));
        $gridField = new GridField(
            'InfoWindows',
            'Markers',
            $this->owner->InfoWindows(),
            $config
        );
        $fields->addFieldToTab('Root.MapMarkers', $gridField);

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
         * Get all info windows
         */
        $infoWindowList = $this->InfoWindows();
        if ($infoWindowList) {
            $InfoWindows = array();
            foreach($infoWindowList as $obj){
                $InfoWindows['Objects'][] = array(
                    'title' => $obj->Title,
                    'lat' => $obj->Lat,
                    'long' => $obj->Long
                );
            }
            $InfoWindows = Convert::array2json($InfoWindows);
            Requirements::customScript("var infoWindowObject = $InfoWindows;");
        }

        /**
         * Map
         */
        if($this->Latitude && $this->Longitude){
            if($this->MapColor != ''){
                $mapColor = "'".$this->MapColor."'";
            }else{
                $mapColor = 'false';
            }
            if($this->WaterColor != ''){
                $waterColor = "'".$this->WaterColor."'";
            }else{
                $waterColor = 'false';
            }
            Requirements::javascript('https://maps.googleapis.com/maps/api/js?key='.$this->GoogleAPI.'&sensor=false');
            Requirements::javascript(CONTACT_FORM_MODULE_DIR.'/javascript/mapScript.js');
            Requirements::customScript(<<<JS
(function($) {
    $(document).ready(function(){
        getMap('map-canvas', $this->Latitude, $this->Longitude, $mapColor, $waterColor, $this->MapMarker, infoWindowObject, $this->MapZoom, $this->MapSaturation)
    })
})(jQuery);
JS
);
        }

	}

    /**
     * @return ContactForm
     */
    public function ContactForm() {
        return new ContactForm($this, 'ContactForm', array(
            'MailTo' => $this->MailTo,
            'MailCC' => $this->MailCC,
            'MailBCC' => $this->MailBCC,
            'SubmitText' => $this->SubmitText,
            'Link' => $this->Link('?success=1'),
            'ReCaptchaSiteKey' => $this->ReCaptchaSiteKey,
            'ReCaptchaSecretKey' => $this->ReCaptchaSecretKey
        ));
    }

    /**
     * @return bool
     */
    public function Success() {
        return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
    }

}