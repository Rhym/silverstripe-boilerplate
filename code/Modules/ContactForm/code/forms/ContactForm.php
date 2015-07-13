<?php

/**
 * Class ContactForm
 */
class ContactForm extends Form {

    /**
     * form constructor
     *
     * @param Controller $controller
     * @param String $name
     */
    public function __construct($controller, $name, $arguments = array()) {
        /** =========================================
         * @var TextField       $firstName
         * @var TextField       $lastName
         * @var EmailField      $email
         * @var TextField       $phone
         * @var TextField       $suburb
         * @var TextField       $city
         * @var TextareaField   $message
         * @var Form            $form
        ===========================================*/

        /** -----------------------------------------
         * Fields
        -------------------------------------------*/

        $firstName = TextField::create('FirstName', 'First Name');
        $firstName->setAttribute('data-parsley-required-message', 'Please enter your <strong>First Name</strong>')
            ->setAttribute('autocomplete', 'fname given-name')
            ->setCustomValidationMessage('Please enter your <strong>First Name</strong>');

        $lastName = TextField::create('LastName', 'Last Name');
        $lastName->setAttribute('data-parsley-required-message', 'Please enter your <strong>Last Name</strong>')
            ->setAttribute('autocomplete', 'lname family-name')
            ->setCustomValidationMessage('Please enter your <strong>Last Name</strong>');

        $email = EmailField::create('Email', 'Email Address');
        $email->setAttribute('data-parsley-required-message', 'Please enter your <strong>Email</strong>')
            ->setAttribute('autocomplete', 'email')
            ->setCustomValidationMessage('Please enter your <strong>Email</strong>');

        $phone = TextField::create('Phone', 'Phone Number (optional)')
            ->setAttribute('autocomplete', 'tel');
        $phone->addExtraClass('form-control');

        $suburb = TextField::create('Suburb', 'Suburb');
        $suburb->setAttribute('data-parsley-required-message', 'Please enter your <strong>Suburb</strong>')
            ->setAttribute('autocomplete', 'region')
            ->setCustomValidationMessage('Please enter your <strong>Suburb</strong>');

        $city = TextField::create('City', 'City');
        $city->setAttribute('data-parsley-required-message', 'Please enter your <strong>City</strong>')
            ->setAttribute('autocomplete', 'city')
            ->setCustomValidationMessage('Please enter your <strong>City</strong>');

        $message = TextareaField::create('Message', 'Message');
        $message->setAttribute('placeholder', 'Enter your message')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>Message</strong>')
            ->setCustomValidationMessage('Please enter your <strong>Message</strong>');

        $reCaptcha = LiteralField::create('', '');
        if(isset($arguments['ReCaptchaSiteKey']) && isset($arguments['ReCaptchaSecretKey'])) {
            $reCaptcha = LiteralField::create('ReCaptcha', '<div class="recaptcha g-recaptcha" data-sitekey="'.$arguments['ReCaptchaSiteKey'].'"></div>');
        }

        $fields = FieldList::create(
            $firstName,
            $lastName,
            $email,
            $phone,
//            $suburb,
//            $city,
            $message,
            $reCaptcha
        );

        /** -----------------------------------------
         * Actions
        -------------------------------------------*/

        $actions = FieldList::create(
            $action = FormAction::create('Submit')->setTitle('Submit')->addExtraClass('btn--primary')
        );

        /** -----------------------------------------
         * Validation
        -------------------------------------------*/

        $required = RequiredFields::create(
            'FirstName',
            'LastName',
            'Email',
            'Message'
        );

        $form = Form::create($this, $name, $fields, $actions, $required);
        if($formData = Session::get('FormInfo.Form_'.$name.'.data')) {
            $form->loadDataFrom($formData);
        }

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->setAttribute('data-parsley-validate', true);
        $this->setAttribute('autocomplete', 'on');

        $this->addExtraClass('form form--contact');
    }

    /**
     * Submit the form
     *
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function Submit($data, $form) {
        /** =========================================
         * @var Form            $form
         * @var HTMLText        $errors
         * @var ContactMessage  $contactMessage
        ===========================================*/

        /** Set the form state */
        Session::set('FormInfo.Form_'.$this->name.'.data', $data);

        /**
         * reCAPTCHA
         * Based on https://github.com/google/recaptcha
         */
        if($this->controller->data()->ReCaptchaSiteKey && $this->controller->data()->ReCaptchaSecretKey) {
            $recaptchaResponse = $data['g-recaptcha-response'];
            $recaptcha = new \ReCaptcha\ReCaptcha($this->controller->data()->ReCaptchaSecretKey);
            $resp = $recaptcha->verify($recaptchaResponse);
            if ($resp->isSuccess()) {
                /**
                 * Verified
                 */
            } else {
                /**
                 * Not Verified
                 */
                $errors = HTMLText::create();
                $html = '';
                /**
                 * Error code reference
                 * https://developers.google.com/recaptcha/docs/verify
                 */
                foreach ($resp->getErrorCodes() as $code) {
                    switch($code) {
                        case 'missing-input-secret':
                            $html.= 'The secret parameter is missing.';
                            break;
                        case 'invalid-input-secret':
                            $html.= 'The secret parameter is invalid or malformed.';
                            break;
                        case 'missing-input-response':
                            $html.= 'Please check the reCAPTCHA below to confirm you\'re human.';
                            break;
                        case 'invalid-input-response':
                            $html.= 'The response parameter is invalid or malformed.';
                            break;
                        default:
                            $html.= 'There was an error submitting the reCAPTCHA, please try again.';
                    }
                }
                $errors->setValue($html);
                $this->controller->setFlash('Your message has not been sent, please fill out all of the <strong>required fields.</strong>', 'warning');
                $form->addErrorMessage('ReCaptcha', $errors, 'bad', false);
                return $this->controller->redirect($this->controller->Link());
            }
        }

        /** -----------------------------------------
         * Email
        -------------------------------------------*/

        $data['Logo'] = SiteConfig::current_site_config()->LogoImage();
        $From = $data['Email'];
        $To = $this->controller->data()->MailTo;
        $Subject = SiteConfig::current_site_config()->Title.' - Contact message';
        $email = Email::create($From, $To, $Subject);
        if($cc = $this->controller->data()->MailCC){
            $email->setCc($cc);
        }
        if($bcc = $this->controller->data()->MailBCC){
            $email->setBcc($bcc);
        }
        $email->setTemplate('ContactEmail')
            ->populateTemplate($data)
            ->send();
        if($this->controller->data()->SubmitText){
            $submitText = $this->controller->data()->SubmitText;
        }else{
            $submitText = 'Thank you for contacting us, we will get back to you as soon as possible.';
        }
        $this->controller->setFlash($submitText, 'success');

        /** -----------------------------------------
         * Records
        -------------------------------------------*/

        $contactMessage = ContactMessage::create();
        $form->saveInto($contactMessage);
        $contactMessage->write();

        /** Clear the form state */
        Session::clear('FormInfo.Form_'.$this->name.'.data');

        return $this->controller->redirect($this->controller->data()->Link('?success=1'));
    }

    /**
     * @return bool
     */
    public function validate() {
        $result = parent::validate();
        if(!$result) {
            $this->controller->setFlash('Your message has not been sent, please fill out all of the <strong>required fields.</strong>', 'warning');
        }
        return $result;
    }

}