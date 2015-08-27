<?php

/**
 * Class ContactForm
 */
class ContactForm extends Form
{
    /**
     * @param Controller $controller
     * @param String $name
     * @param array $arguments
     */
    public function __construct($controller, $name, $arguments = array())
    {
        /** -----------------------------------------
         * Fields
         * ----------------------------------------*/

        $clearfix = LiteralField::create('', '<div class="clearfix"></div><!-- /.clearfix -->');

        /** @var TextField $firstName */
        $firstName = TextField::create('FirstName', _t('ContactForm.FirstName', 'First Name'));
        $firstName->setAttribute('data-parsley-required-message',
            _t('ContactForm.FirstNameRequiredMessage', 'Please enter your <strong>First Name</strong>'))
            ->setAttribute('autocomplete', 'fname given-name')
            ->setCustomValidationMessage(_t('ContactForm.FirstNameRequiredMessage',
                'Please enter your <strong>First Name</strong>'));

        /** @var TextField $lastName */
        $lastName = TextField::create('LastName', _t('ContactForm.LastName', 'Last Name'));
        $lastName->setAttribute('data-parsley-required-message',
            _t('ContactForm.LastNameRequiredMessage', 'Please enter your <strong>Last Name</strong>'))
            ->setAttribute('autocomplete', 'lname family-name')
            ->setCustomValidationMessage(_t('ContactForm.LastNameRequiredMessage',
                'Please enter your <strong>Last Name</strong>'));

        /** @var EmailField $email */
        $email = EmailField::create('Email', _t('ContactForm.Email', 'Email Address'));
        $email->setAttribute('data-parsley-required-message',
            _t('ContactForm.EmailRequiredMessage', 'Please enter your <strong>Email</strong>'))
            ->setAttribute('autocomplete', 'email')
            ->setCustomValidationMessage(_t('ContactForm.EmailRequiredMessage',
                'Please enter your <strong>Email</strong>'));

        /** @var TextField $phone */
        $phone = TextField::create('Phone', _t('ContactForm.Phone', 'Phone Number (optional)'))
            ->setAttribute('autocomplete', 'tel');
        $phone->addExtraClass('form-control');

        /** @var TextField $suburb */
        $suburb = TextField::create('Suburb', _t('ContactForm.Suburb', 'Suburb'));
        $suburb->setAttribute('data-parsley-required-message',
            _t('ContactForm.SuburbRequiredMessage', 'Please enter your <strong>Suburb</strong>'))
            ->setAttribute('autocomplete', 'region')
            ->setCustomValidationMessage(_t('ContactForm.SuburbRequiredMessage',
                'Please enter your <strong>Suburb</strong>'));

        /** @var TextField $city */
        $city = TextField::create('City', _t('ContactForm.City', 'City'));
        $city->setAttribute('data-parsley-required-message',
            _t('ContactForm.CityRequiredMessage', 'Please enter your <strong>City</strong>'))
            ->setAttribute('autocomplete', 'city')
            ->setCustomValidationMessage(_t('ContactForm.CityRequiredMessage',
                'Please enter your <strong>City</strong>'));

        /** @var TextareaField $message */
        $message = TextareaField::create('Message', _t('ContactForm.Message', 'Message'));
        $message->setAttribute('placeholder', _t('ContactForm.MessagePlaceholder', 'Enter your message'))
            ->setAttribute('data-parsley-required-message',
                _t('ContactForm.MessageRequiredMessage', 'Please enter your <strong>Message</strong>'))
            ->setCustomValidationMessage(_t('ContactForm.MessageRequiredMessage',
                'Please enter your <strong>Message</strong>'));

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
            FormAction::create('Submit')->setTitle(_t('ContactForm.Submit', 'Submit'))->addExtraClass('btn--primary')
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
                            $html .= _t('ContactForm.RecaptchaMissingInputSecret', 'The secret parameter is missing.');
                            break;
                        case 'invalid-input-secret':
                            $html .= _t('ContactForm.RecaptchaInvalidInputSecret',
                                'The secret parameter is invalid or malformed.');
                            break;
                        case 'missing-input-response':
                            $html .= _t('ContactForm.RecaptchaMissingInputResponse',
                                'Please check the reCAPTCHA below to confirm you\'re human.');
                            break;
                        case 'invalid-input-response':
                            $html .= _t('ContactForm.RecaptchaInvalidInputResponse',
                                'The response parameter is invalid or malformed.');
                            break;
                        default:
                            $html .= _t('ContactForm.RecaptchaDefaultError',
                                'There was an error submitting the reCAPTCHA, please try again.');
                    }
                }
                $errors->setValue($html);
                $this->controller->setFlash(_t('ContactForm.RecaptchaFormError',
                    'Your message has not been sent, please fill out all of the <strong>required fields.</strong>'),
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
        $Subject = SiteConfig::current_site_config()->Title . _t('ContactForm.EmailSubject', ' - Contact message');
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
            $submitText = _t('ContactForm.SubmitText',
                'Thank you for contacting us, we will get back to you as soon as possible.');
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
            $this->controller->setFlash(_t('ContactForm.ValidationError',
                'Your message has not been sent, please fill out all of the <strong>required fields.</strong>'),
                'warning');
        }
        return $result;
    }

}
