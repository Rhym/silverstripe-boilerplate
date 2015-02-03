<?php

/**
 * Class PortfolioPage
 */
class PortfolioPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Portfolio/images/blog.png';

    private static $db = array(
        'SubTitle' => 'Varchar(255)'
    );

    private static $has_many = array(
        'PortfolioImages' => 'PortfolioImage'
    );

    private static $defaults = array(
        'ShowInMenus' => 0
    );

    private static $description = 'Portfolio content page';

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $fields->removeByName('Slider');
        $fields->removeByName('PageBuilder');

        $fields->addFieldToTab('Root.Main', new TextField('SubTitle', _t('PortfolioPage.SubTitleLabel', 'Sub Title')), 'Content');

        /* -----------------------------------------
         * Images
        ------------------------------------------*/

        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldSortableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $config->getComponentByType('GridFieldDataColumns')->setDisplayFields(array(
            'Thumbnail' => 'Thumbnail'
        ));
        $gridField = new GridField(
            'PortfolioImages',
            _t('PortfolioPage.PortfolioImagesLabel', 'Images'),
            $this->owner->PortfolioImages(),
            $config
        );
        $fields->addFieldToTab('Root.PortfolioImages', $gridField);

        return $fields;

    }

    /**
     * For use in the ImageNavigation method
     * @return mixed
     */
    public function FeaturedImage() {
        return $this->PortfolioImages()->first()->Image();
    }

    /**
     * @param $direction
     * @return bool|DataObject
     */
    public function NavigationLink($direction){

        switch($direction){
            case 'next':
                $sort = 'Sort:GreaterThan';
                break;
            case 'prev':
                $sort = 'Sort:LessThan';
                break;
            default:
                return false;
        }
        $page = PortfolioPage::get()->filter(array(
            'ParentID' => $this->ParentID,
            $sort => $this->Sort
        ))->sort('Sort ASC')->first();

        return $page;
    }

    /**
     * @return ArrayData|bool
     * Check for prev/next post in thew blog and display an image and title.
     */
    public function ImageNavigation(){

        if($next = $this->NavigationLink('next')){
            $page = $next;
        } else if ($prev = $this->NavigationLink('prev')) {
            $page = $prev;
        } else {
            return false;
        }
        if($image = $page->FeaturedImage()) {
            return new ArrayData(array(
                'Link' => $page->Link(),
                'MenuTitle' => $page->MenuTitle,
                'Title' => $page->Title,
                'Image' => $image
            ));
        }
        return false;
    }

}

class PortfolioPage_Controller extends Page_Controller {}