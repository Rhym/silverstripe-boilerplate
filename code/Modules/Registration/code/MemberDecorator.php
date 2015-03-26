<?php

/**
 * Class MemberDecorator
 */
class MemberDecorator extends DataExtension {

    private static $db = array(
        'JobTitle' => 'Varchar',
        'Blurb' => 'Text',
        'Website' => 'Varchar(100)'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Profile', new TextField('JobTitle', _t('MemberDecorator.JobTitleLabel', 'Job Title')));
        $fields->addFieldToTab('Root.Profile', new TextField('Website', _t('MemberDecorator.WebsiteLabel', 'Website'), 'http://'));
        $fields->addFieldToTab('Root.Profile', new TextareaField('Blurb', _t('MemberDecorator.BlurbLabel', 'Blurb')));
    }

    /**
     * @return SS_HTTPResponse
     */
    function Link(){
        if($ProfilePage = DataObject::get_one('EditProfilePage')){
            return $ProfilePage->Link();
        }else{
            return Controller::curr()->redirect(Director::absoluteBaseURL());
        }
    }

}