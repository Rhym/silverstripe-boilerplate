<?php

/**
 * Class BoilerplatePageExtension
 *
 * @property boolean HideSidebar
 */
class BoilerplatePageExtension extends DataExtension
{
    /**
     * @var string
     */
    private static $theme_color = '';

    /**
     * @var array
     */
    private static $db = array(
        'HideSidebar' => 'Boolean'
    );

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateCMSFields(FieldList $fields)
    {
        /** =========================================
         * @var HtmlEditorField $content
        ===========================================*/

        $fields->removeByName('Content');
        $fields->addFieldToTab('Root.Main', $content = HtmlEditorField::create('Content'), 'Metadata');
        $content->setRows(20);
    }

    /**
     * @param FieldList $fields
     * @return FieldList
     */
    public function updateSettingsFields(FieldList $fields)
    {
        /** =========================================
         * @var FieldGroup $hideSidebar
        ===========================================*/

        /** Use FieldGroups to set left titles for the checkboxes. */
        $fields->addFieldToTab('Root.Settings', $hideSidebar = FieldGroup::create(
            CheckboxField::create('HideSidebar', 'Hide the sidebar from this page')
        ));
        $hideSidebar->setTitle('Sidebar');
    }

    /**
     * @param string $direction
     * @return ArrayData|bool
     */
    public function DirectionLink($direction = 'next')
    {
        /** =========================================
         * @var Page $page
        ===========================================*/

        switch ($direction) {
            case 'previous':
                $sortDirection = 'Sort:LessThan';
                $sort = 'Sort DESC';
                break;
            default:
                $sortDirection = 'Sort:GreaterThan';
                $sort = 'Sort ASC';
        }
        $page = Page::get()->filter(array(
            'ParentID' => $this->owner->ParentID,
            $sortDirection => $this->owner->Sort
        ))->sort($sort)->first();
        if (isset($page)) {
            return new ArrayData(array(
                'Title' => $page->Title,
                'MenuTitle' => $page->MenuTitle,
                'Link' => $page->Link()
            ));
        }
        return false;
    }

    /**
     * Set a colour to to display in the header of mobile browsers.
     *
     * @return string|bool
     */
    public function getThemeColor()
    {
        $color = $this->owner->config()->theme_color;
        if ($color) {
            return '<meta name="mobile-web-app-capable" content="yes"/><meta name="theme-color" content="' . $color . '">';
        }
        return false;
    }

    /**
     * @return ArrayData|bool
     */
    public function getPreviousLink()
    {
        return $this->DirectionLink('previous');
    }

    /**
     * @return ArrayData|bool
     */
    public function getNextLink()
    {
        return $this->DirectionLink('next');
    }

    /**
     * If the Tracking Code contains Google Tag Manager then
     * return the tracking code directly after the <body> tag.
     *
     * @return bool|mixed
     */
    public function getTrackingCodeTop()
    {
        $siteConfig = SiteConfig::current_site_config();
        if ($siteConfig->TagManager) {
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
    public function getTrackingCodeBottom()
    {
        $siteConfig = SiteConfig::current_site_config();
        if (!$siteConfig->TagManager) {
            return $siteConfig->TrackingCode;
        }
        return false;
    }

}
