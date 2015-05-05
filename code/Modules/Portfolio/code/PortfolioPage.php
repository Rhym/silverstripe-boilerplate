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

    private static $allowed_children = 'none';

    private static $can_be_root = false;

    private static $description = 'Portfolio content page';

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $fields->removeByName('Slider');
        $fields->removeByName('PageBuilder');

        $fields->addFieldToTab('Root.Main', $subTitle = TextField::create('SubTitle', 'Sub Title'), 'Content');
        $subTitle->setRightTitle('Subtitles are displayed on PortfolioHolder pages under the title.');

        /** -----------------------------------------
         * Portfolio Images
        -------------------------------------------*/

        $fields->addFieldToTab('Root.PortfolioImages', HeaderField::create('', 'Portfolio Images'));
        $fields->addFieldToTab('Root.PortfolioImages', LiteralField::create('',
            '<p>Portfolio Images are displayed under the page\'s content. Items can be full width, or have content displayed to the left or right hand side of the image.</p>'
        ));
        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldSortableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $gridField = GridField::create(
            'PortfolioImages',
            'Images',
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
            return ArrayData::create(array(
                'Link' => $page->Link(),
                'MenuTitle' => $page->MenuTitle,
                'Title' => $page->Title,
                'Image' => $image
            ));
        }
        return false;
    }

}

/**
 * Class PortfolioPage_Controller
 */
class PortfolioPage_Controller extends Page_Controller {}