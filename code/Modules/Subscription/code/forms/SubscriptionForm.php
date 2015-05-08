<?php

/**
 * Class SubscriptionForm
 */
class SubscriptionForm extends Form {

    /**
     * form constructor
     *
     * @param Controller $controller
     * @param String $name
     */
    public function __construct($controller, $name, $arguments = array()) {

        /**
         * Add front-end validation
         */
        Requirements::javascript(BOWER_COMPONENTS_DIR . '/parsleyjs/dist/parsley.min.js');

        /** -----------------------------------------
         * Fields
        -------------------------------------------*/

        $email = EmailField::create('Email', 'Email Address');
        $email->addExtraClass('form-control')
            ->setAttribute('data-parsley-required-message', 'Please enter your <strong>Email</strong>')
            ->setCustomValidationMessage('Please enter your <strong>Email</strong>');

        $fields = FieldList::create(
            $email
        );

        /** -----------------------------------------
         * Actions
        -------------------------------------------*/

        $actions = FieldList::create(
            FormAction::create('Subscribe')->setTitle('Subscribe')->addExtraClass('btn btn-primary')
        );

        /** -----------------------------------------
         * Validation
        -------------------------------------------*/

        $required = RequiredFields::create(
            'Email'
        );

        $form = Form::create($this, $name, $fields, $actions, $required);
        if($formData = Session::get('FormInfo.Form_'.$name.'.data')) {
            $form->loadDataFrom($formData);
        }

        parent::__construct($controller, $name, $fields, $actions, $required);

        $this->setAttribute('data-parsley-validate', true);
        $this->addExtraClass('form');
    }

    /**
     * Submit the form
     *
     * @param $data
     * @param $form
     * @return bool|SS_HTTPResponse
     */
    public function Subscribe($data, $form) {

        /**
         * Set the form state
         */
        Session::set('FormInfo.Form_'.$this->name.'.data', $data);

        $siteConfig = SiteConfig::current_site_config();
        /**
         * Check if the API key, and List ID have been set.
         */
        if($siteConfig->MailChimpAPI && $siteConfig->MailChimpListID) {
            $mailChimp = new \Drewm\MailChimp($siteConfig->MailChimpAPI);
            $result = $mailChimp->call('lists/subscribe', array(
                'id'    => $siteConfig->MailChimpListID,
                'email' => array(
                    'email' => $data['Email']
                )
            ));
        } else {
            /**
             * If not, redirect back and display a flash error.
             */
            $this->controller->setFlash('Missing API key, or List ID', 'danger');
            return $this->controller->redirectBack();
        }

        /**
         * If the status of the request returns an error,
         * display the error
         */
        if(isset($result['status'])) {
            if ($result['status'] == 'error') {
                $this->controller->setFlash($result['error'], 'danger');
                return $this->controller->redirectBack();
            }
        }

        /**
         * Clear the form state
         */
        Session::clear('FormInfo.Form_'.$this->name.'.data');
        if($siteConfig->MailChimpSuccessMessage) {
            $this->controller->setFlash($siteConfig->MailChimpSuccessMessage, 'success');
        } else {
            $this->controller->setFlash('Your subscription has been received, you will be sent a confirmation email shortly.', 'success');
        }
        return $this->controller->redirect($this->controller->data()->Link());
    }

}