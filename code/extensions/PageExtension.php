<?php

/**
 * Class PageExtension
 */
class PageExtension extends DataExtension {

    private static $db = array(
        'HideSidebar' => 'Boolean(0)',
        'HideDefaultSlider' => 'Boolean(0)'
    );

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateSettingsFields(FieldList $fields) {
        $fields->addFieldToTab('Root.Settings', new HeaderField('SidebarHeading', 'Sidebar', 4));
        $fields->addFieldToTab('Root.Settings', new CheckboxField('HideSidebar', 'Hide the sidebar from this page'));
        $fields->addFieldToTab('Root.Settings', new HeaderField('SliderHeading', 'Slider', 4));
        $fields->addFieldToTab('Root.Settings', new CheckboxField('HideDefaultSlider', 'Hide the slider from this page'));
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