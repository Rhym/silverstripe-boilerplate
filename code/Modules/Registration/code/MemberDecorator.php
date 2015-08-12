<?php

/**
 * Class MemberDecorator
 *
 * @property string JobTitle
 * @property string Blurb
 * @property string Website
 */
class MemberDecorator extends DataExtension
{

    /**
     * @var array
     */
    private static $db = array(
        'JobTitle' => 'Varchar',
        'Blurb' => 'Text',
        'Website' => 'Varchar(100)'
    );

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->addFieldToTab('Root.Profile', TextField::create('JobTitle', 'Job Title'));
        $fields->addFieldToTab('Root.Profile', TextField::create('Website', 'Website', 'http://'));
        $fields->addFieldToTab('Root.Profile', TextareaField::create('Blurb', 'Blurb'));
    }

    /**
     * @return SS_HTTPResponse
     */
    public function Link()
    {
        /** =========================================
         * @var EditProfilePage $profilePage
        ===========================================*/

        if ($profilePage = DataObject::get_one('EditProfilePage')) {
            return $profilePage->Link();
        } else {
            return Controller::curr()->redirect(Director::absoluteBaseURL());
        }
    }

}
