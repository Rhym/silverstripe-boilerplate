<?php

/**
 * Class ContactForm
 */
class ContactForm extends Form
{

    /**
     * form constructor
     *
     * @param Controller $controller
     * @param String $name
     */
    public function __construct($controller, $name, $arguments = array())
    {
        /** -----------------------------------------
         * Fields
         * ----------------------------------------*/

        $clearfix = LiteralField::create('', '<div class="clearfix"></div><!-- /.clearfix -->');

        /** @var TextField $firstName */
        $firstName = TextField::create('FirstName', 'First Name');
        $firstName->setAttribute('data-parsley-required-message', 'Please enter your <strong>First Name</strong>')
            ->setAttribute('autocomplete', 'fname given-name')
            ->setCustomValidationMessage('Please enter your <strong>First Name</strong>');

        /** @var TextField $lastName */
        $lastName = TextField::create('LastName', 'Last Name');
        $lastName->setAttribute('data-parsley-required-message', 'Please enter your <strong>Last Name</strong>')
            ->setAttribute('autocomplete', 'lname family-name')
            ->setCustomValidationMessage('Please enter your <strong>Last Name</strong>');

        /** @var EmailField $email */
        $email = EmailField::create('Email', 'Email Address');
        $email->setAttribute('data-parsley-required-message', 'Please enter your <strong>Email</strong>')
            ->setAttribute('autocomplete', 'email')
            ->setCustomValidationMessage('Please enter your <strong>Email</strong>');

        /** @var TextField $phone */
        $phone = TextField::create('Phone', 'Phone Number (optional)')
            ->setAttribute('autocomplete', 'tel');
        $phone->addExtraClass('form-control');

        /** @var TextField $suburb */
        $suburb = TextField::create('Suburb', 'Suburb');
        $suburb->setAttribute('data-parsley-required-message', 'Please enter your <strong>Suburb</strong>')
            ->setAttribute('autocomplete', 'region')
            ->setCustomValidationMessage('Please enter your <strong>Suburb</strong>');

        /** @var TextField $city */
        $city = TextField::create('City', 'City');
        $city->setAttribute('data-parsley-required-message', 'Please enter your <strong>City</strong>')
            ->setAttribute('autocomplete', 'city')
            ->setCustomValidationMessage('Please enter your <strong>City</strong>');

        /** @var TextareaField $message */
        $message = TextareaField::create('Message', 'Message');
        $message->setAttribute('placeholder', 'Enter your message')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>Message</strong>')
            ->setCustomValidationMessage('Please enter your <strong>Message</strong>');

        /** @var LiteralField $reCaptcha */
        $reCaptcha = LiteralField::create('', '');
        if (isset($arguments['ReCaptchaSiteKey']) && isset($arguments['ReCaptchaSecretKey'])) {
            $reCaptcha = LiteralField::create('ReCaptcha',
                '<div class="recaptcha g-recaptcha" data-sitekey="' . $arguments['ReCaptchaSiteKey'] . '"></div>');
        }

        $fields = FieldList::create(
            $firstName,
            $lastName,
            $clearfix,
            $email,
            $phone,
            $message,
            $clearfix,
            $reCaptcha
        );

        /** -----------------------------------------
         * Actions
         * ----------------------------------------*/

        $actions = FieldList::create(
            FormAction::create('Submit')->setTitle('Submit')->addExtraClass('btn--primary')
        );

        /** -----------------------------------------
         * Validation
         * ----------------------------------------*/

        $required = RequiredFields::create(
            'FirstName',
            'LastName',
            'Email',
            'Message'
        );

        /** @var Form $form */
        $form = Form::create($this, $name, $fields, $actions, $required);
        if ($formData = Session::get('FormInfo.Form_' . $name . '.data')) {
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
    public function Submit($data, $form)
    {
        $recaptchaResponse = $recaptchaResponse = $data['g-recaptcha-response'];
        /** @var Form $form */
        $data = $form->getData();

        /** Set the form state */
        Session::set('FormInfo.Form_' . $this->name . '.data', $data);

        /**
         * reCAPTCHA
         * Based on https://github.com/google/recaptcha
         */
        if ($this->controller->data()->ReCaptchaSiteKey && $this->controller->data()->ReCaptchaSecretKey) {
            $recaptcha = new \ReCaptcha\ReCaptcha($this->controller->data()->ReCaptchaSecretKey);
            $resp = $recaptcha->verify($recaptchaResponse);
            if ($resp->isSuccess()) {
                /**
                 * Verified
                 */
            } else {
                /**
                 * Not Verified
                 *
                 * @var HTMLText $errors
                 */
                $errors = HTMLText::create();
                $html = '';
                /**
                 * Error code reference
                 * https://developers.google.com/recaptcha/docs/verify
                 */
                foreach ($resp->getErrorCodes() as $code) {
                    switch ($code) {
                        case 'missing-input-secret':
                            $html .= 'The secret parameter is missing.';
                            break;
                        case 'invalid-input-secret':
                            $html .= 'The secret parameter is invalid or malformed.';
                            break;
                        case 'missing-input-response':
                            $html .= 'Please check the reCAPTCHA below to confirm you\'re human.';
                            break;
                        case 'invalid-input-response':
                            $html .= 'The response parameter is invalid or malformed.';
                            break;
                        default:
                            $html .= 'There was an error submitting the reCAPTCHA, please try again.';
                    }
                }
                $errors->setValue($html);
                $this->controller->setFlash('Your message has not been sent, please fill out all of the <strong>required fields.</strong>',
                    'warning');
                $form->addErrorMessage('ReCaptcha', $errors, 'bad', false);
                return $this->controller->redirect($this->controller->Link());
            }
        }

        /** -----------------------------------------
         * Email
         * ----------------------------------------*/

        $data['Logo'] = SiteConfig::current_site_config()->LogoImage();
        $From = $data['Email'];
        $To = $this->controller->data()->MailTo;
        $Subject = SiteConfig::current_site_config()->Title . ' - Contact message';
        /** @var Email $email */
        $email = Email::create($From, $To, $Subject);
        if ($cc = $this->controller->data()->MailCC) {
            $email->setCc($cc);
        }
        if ($bcc = $this->controller->data()->MailBCC) {
            $email->setBcc($bcc);
        }
        $email->setTemplate('ContactEmail')
            ->populateTemplate($data)
            ->send();
        if ($this->controller->data()->SubmitText) {
            $submitText = $this->controller->data()->SubmitText;
        } else {
            $submitText = 'Thank you for contacting us, we will get back to you as soon as possible.';
        }
        $this->controller->setFlash($submitText, 'success');

        /** -----------------------------------------
         * Records
         * ----------------------------------------*/

        /** @var ContactMessage $contactMessage */
        $contactMessage = ContactMessage::create();
        $form->saveInto($contactMessage);
        $contactMessage->write();

        /** Clear the form state */
        Session::clear('FormInfo.Form_' . $this->name . '.data');

        return $this->controller->redirect($this->controller->data()->Link('?success=1'));
    }

    /**
     * @return bool
     */
    public function validate()
    {
        $result = parent::validate();
        if (!$result) {
            $this->controller->setFlash('Your message has not been sent, please fill out all of the <strong>required fields.</strong>',
                'warning');
        }
        return $result;
    }

}
