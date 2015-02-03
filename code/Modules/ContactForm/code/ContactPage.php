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
        'MapMarker' => 'Boolean(1)'
    );

    private static $has_many = array(
        'InfoWindows' => 'InfoWindow'
    );

    private static $defaults = array(
        'MapZoom' => 14,
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
        $fields->addFieldToTab('Root.Main', $mailTo = new TextField('MailTo', _t('ContactPage.MailToLabel', 'Email')), 'Content');
        $mailTo->setRightTitle('Choose an email address for the contact page to send to');
        $fields->addFieldToTab('Root.Main', $mailCC = new TextField('MailCC', _t('ContactPage.MailCCLabel', 'Cc')), 'Content');
        $mailCC->setRightTitle('Choose an email, or emails to CC (separate emails with a comma and no space e.g: email1@website.com,email2@website.com)');
        $fields->addFieldToTab('Root.Main', $mailBCC = new TextField('MailBCC', _t('ContactPage.MailBCCLabel', 'Bcc')), 'Content');
        $fields->addFieldToTab('Root.Main', $submissionText = new TextareaField('SubmitText', _t('ContactPage.SubmitTextLabel', 'Submission Text')), 'Content');
        $submissionText->setRightTitle('Text for contact form submission once the email has been sent i.e "Thank you for your enquiry"');

        /* -----------------------------------------
         * Google Map
        ------------------------------------------*/

        $fields->addFieldToTab('Root.Map', new Textfield('GoogleAPI', _t('ContactPage.GoogleAPILabel', 'Maps API (Optional)')));
        $fields->addFieldToTab('Root.Map', new Textfield('Latitude', _t('ContactPage.LatitudeLabel', 'Latitude')));
        $fields->addFieldToTab('Root.Map', new Textfield('Longitude', _t('ContactPage.LongitudeLabel', 'Longitude')));
        $fields->addFieldToTab('Root.Map', new LiteralField('', '<div class="field"><label class="right"><a href="https://support.google.com/maps/answer/18539" target="_blank">How do I find my latitude/longitude?</a></label></div>'));
        $fields->addFieldToTab('Root.Map', $mapZoom = new NumericField('MapZoom', _t('ContactPage.MapZoomLabel', 'Zoom')));
        $mapZoom->setRightTitle(_t('ContactPage.MapZoomTitle', 'Zoom level: 0-22 - The higher the number the more zoomed in the map will be.'));
        $fields->addFieldToTab('Root.Map', new ColorField('MapColor', _t('ContactPage.MapColorLabel', 'Map Colour (Optional)')));
        $fields->addFieldToTab('Root.Map', new ColorField('WaterColor', _t('ContactPage.WaterColorLabel', 'Water Colour (Optional)')));
        $fields->addFieldToTab('Root.Map', new CheckboxField('MapMarker', _t('ContactPage.MapMarkerLabel', 'Show map marker')));

        /* -----------------------------------------
         * Info Windows
        ------------------------------------------*/

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
        getMap('map-canvas', $this->Latitude, $this->Longitude, $mapColor, $waterColor, $this->MapMarker, infoWindowObject, $this->MapZoom)
    })
})(jQuery);
JS
);
        }

	}

    /**
     * @return static
     */
    public function ContactForm() {

        /* -----------------------------------------
         * Scaffolding
        ------------------------------------------*/

        $row = new LiteralField('', '<div class="row">');
        $column = new LiteralField('', '<div class="col-xs-12 col-sm-6">');
        $close = new LiteralField('', '</div>');

        /* -----------------------------------------
         * Fields
        ------------------------------------------*/

        $firstName = new TextField('FirstName', 'First Name');
        $firstName->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $lastName = new TextField('LastName', 'Last Name');
        $lastName->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $email = new EmailField('Email', 'Email Address');
        $email->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $phone = new TextField('Phone', 'Phone Number (optional)');
        $phone->addExtraClass('form-control');

        $suburb = new TextField('Suburb', 'Suburb');
        $suburb->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $city = new TextField('City', 'City');
        $city->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $message = new TextareaField('Message', 'Message');
        $message->setAttribute('placeholder', _t('ContactPage.MessagePlaceholder', 'Enter your message'))
            ->setAttribute('required', 'required')
            ->addExtraClass('form-control');

        $fields = new FieldList(
            $row,
                $column,
                    $firstName,
                $close,
                $column,
                    $lastName,
                $close,
            $close,
            $row,
                $column,
                    $email,
                $close,
                $column,
                    $phone,
                $close,
            $close,
//            $row,
//                $column,
//                    $suburb,
//                $close,
//                $column,
//                    $city,
//                $close,
//            $close,
            $message
        );

        $action = new FormAction('SendContactForm', _t('ContactPage.SubmitText', 'Submit'));
        $action->addExtraClass('btn btn-primary');

        $actions = new FieldList(
            $action
        );

        $validator = new RequiredFields(
            'FirstName',
            'LastName',
            'Email',
            'Message'
        );

        $form = Form::create($this, 'ContactForm', $fields, $actions, $validator);
        if($formData = Session::get('FormInfo.Form_ContactForm.data')) {
            $form->loadDataFrom($formData);
        }

        return $form;
    }

    /**
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function SendContactForm($data, $form) {

        Session::set('FormInfo.Form_ContactForm.data', $data);

        $data['Logo'] = SiteConfig::current_site_config()->LogoImage();
        $From = $data['Email'];
        $To = $this->MailTo;
        $Subject = _t('ContactPage.EmailSubject', SiteConfig::current_site_config()->Title.' - Contact message');
        $email = new Email($From, $To, $Subject);
        if($cc = $this->MailCC){
            $email->setCc($cc);
        }
        if($bcc = $this->MailBCC){
            $email->setBcc($bcc);
        }
        $email->setTemplate('ContactEmail')
            ->populateTemplate($data)
            ->send();
        if($this->SubmitText){
            $submitText = $this->SubmitText;
        }else{
            $submitText = _t('ContactPage.SubmitText', 'Thank you for contacting us, we will get back to you as soon as possible.');
        }
        $this->setFlash($submitText, 'success');

        //Create record
        $contactMessage = new ContactMessage();
        $form->saveInto($contactMessage);
        $contactMessage->write();

        // Clear the form state
        Session::clear('FormInfo.Form_ContactForm.data');

        return $this->redirect($this->Link("?success=1"));

    }

    /**
     * @return bool
     */
    public function Success() {
        return isset($_REQUEST['success']) && $_REQUEST['success'] == "1";
    }

}