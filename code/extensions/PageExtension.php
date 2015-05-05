<?php

/**
 * Class PageExtension
 */
class PageExtension extends DataExtension {

    private static $db = array(
        'HideSidebar' => 'Boolean(0)'
    );

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateSettingsFields(FieldList $fields) {
        /**
         * Use FieldGroups to set left titles for the checkboxes.
         */
        $fields->addFieldToTab('Root.Settings', $hideSidebar = FieldGroup::create(
            CheckboxField::create('HideSidebar', 'Hide the sidebar from this page')
        ));
        $hideSidebar->setTitle('Sidebar');
        return $fields;
    }

    /**
     * If the Tracking Code contains Google Tag Manager then
     * return the tracking code directly after the <body> tag.
     *
     * @return bool|mixed
     */
    public function getTrackingCodeTop() {
        $siteConfig = SiteConfig::current_site_config();
        if($siteConfig->TagManager) {
            return $siteConfig->TrackingCode;
        }
        return false;
    }

    /**
     * If there's no Google Tag Manager in the tracking code
     * return in the footer.
     *
     * @return bool|mixed
     */
    public function getTrackingCodeBottom() {
        $siteConfig = SiteConfig::current_site_config();
        if(!$siteConfig->TagManager) {
            return $siteConfig->TrackingCode;
        }
        return false;
    }

}