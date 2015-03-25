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
        $firstName->addExtraClass('form-control')
            ->setCustomValidationMessage('Please enter your <strong>First Name</strong>');

        $lastName = new TextField('LastName', 'Last Name');
        $lastName->addExtraClass('form-control')
            ->setCustomValidationMessage('Please enter your <strong>Last Name</strong>');

        $email = new EmailField('Email', 'Email Address');
        $email->addExtraClass('form-control')
            ->setCustomValidationMessage('Please enter your <strong>Email</strong>');

        $phone = new TextField('Phone', 'Phone Number (optional)');
        $phone->addExtraClass('form-control');

        $suburb = new TextField('Suburb', 'Suburb');
        $suburb->addExtraClass('form-control')
            ->setCustomValidationMessage('Please enter your <strong>Suburb</strong>');

        $city = new TextField('City', 'City');
        $city->addExtraClass('form-control')
            ->setCustomValidationMessage('Please enter your <strong>City</strong>');

        $message = new TextareaField('Message', 'Message');
        $message->setAttribute('placeholder', 'Enter your message')
            ->addExtraClass('form-control')
            ->setCustomValidationMessage('Please enter your <strong>Message</strong>');

        $reCaptcha = new LiteralField('', '');
        if(isset($arguments['ReCaptchaSiteKey']) && isset($arguments['ReCaptchaSecretKey'])) {
            $reCaptcha = new LiteralField('ReCaptcha', '<div class="recaptcha g-recaptcha" data-sitekey="'.$arguments['ReCaptchaSiteKey'].'"></div>');
        }

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
            $message,
            $reCaptcha
        );

        /**
         * Actions
         */
        $action = new FormAction('Submit', 'Submit');
        $action->addExtraClass('btn btn-primary');
        $actions = new FieldList(
            $action
        );

        /**
         * Required
         */
        $required = new RequiredFields(
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

        $this->addExtraClass('form');
    }

    /**
     * Submit the form
     *
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function Submit($data, $form) {

        /**
         * Set the form state
         */
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

        $data['Logo'] = SiteConfig::current_site_config()->LogoImage();
        $From = $data['Email'];
        $To = $this->controller->data()->MailTo;
        $Subject = SiteConfig::current_site_config()->Title.' - Contact message';
        $email = new Email($From, $To, $Subject);
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

        /**
         * Create Record
         */
        $contactMessage = new ContactMessage();
        $form->saveInto($contactMessage);
        $contactMessage->write();

        /**
         * Clear the form state
         */
        Session::clear('FormInfo.Form_'.$this->name.'.data');

        return $this->controller->redirect($this->controller->data()->Link);
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