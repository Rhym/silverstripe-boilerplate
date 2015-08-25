<?php

/**
 * Class MemberDecorator
 */
class MemberDecorator extends DataExtension
{

    /**
     * @var array
     */
    private static $db = array();

    /**
     * @param FieldList $fields
     */
    public function updateCMSFields(FieldList $fields)
    {

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
