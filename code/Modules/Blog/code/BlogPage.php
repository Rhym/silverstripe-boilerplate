<?php

/**
 * Class BlogPage
 */
class BlogPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Blog/images/blog.png';

    private static $db = array(
        'Date' => 'Date',
        'Author' => 'Text'
    );

    private static $has_one = array(
        'Image' => 'Image'
    );

    private static $many_many = array(
        'Tags' => 'BlogTag'
    );

    private static $defaults = array(
        'ShowInMenus' => 0
    );

    private static $description = 'Blog content page';

    private static $allowed_children = 'none';

    private static $can_be_root = false;

    public static $many_many_extraFields=array(
        'Tags' => array(
            'SortOrder' => 'Int'
        )
    );

    /**
     * @return FieldList
     */
    public function getCMSFields() {

        $fields = parent::getCMSFields();

        $fields->removeByName('Slider');
        $fields->removeByName('PageBuilder');

        $fields->addFieldToTab('Root.Main', $blogImage = new UploadField('Image', 'Image'), 'Content');
        $blogImage->setRightTitle('Image is used on BlogHolder pages as a thumbnail, as well as at the top of this page\'s content.');
        $blogImage->setFolderName('Uploads/blog');
        $fields->addFieldToTab('Root.Main', $dateField = new DateField('Date', 'Article Date (optional)'), 'Content');
        $dateField->setConfig('showcalendar', true);
        $fields->addFieldToTab('Root.Main', $dateField, 'Content');
        $fields->addFieldToTab('Root.Main', new TextField('Author', 'Author (optional)'), 'Content');

        /* =========================================
         * Tags - Disabled by default
         =========================================*/

        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldSortableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $gridField = new GridField(
            'Tags',
            'Tags',
            $this->Tags(),
            $config
        );
        //$fields->addFieldToTab('Root.Tags', $gridField);

        return $fields;

    }

    /**
     * For use in the ImageNavigation method
     * @return mixed
     */
    public function FeaturedImage() {
        return $this->Image();
    }

    /**
     * @param $direction
     * @return bool|DataObject
     */
    public function NavigationLink($direction){

        switch($direction){
            case 'next':
                $sort = 'Sort:GreaterThan';
                $sortDirection = 'Sort ASC';
                break;
            case 'prev':
                $sort = 'Sort:LessThan';
                $sortDirection = 'Sort DESC';
                break;
            default:
                return false;
        }
        $page = BlogPage::get()->filter(array(
            'ParentID' => $this->ParentID,
            $sort => $this->Sort
        ))->sort($sortDirection)->first();

        return $page;
    }

    /**
     * @return ArrayData|bool
     * Check for prev/next post in the blog and display an image and title.
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

class BlogPage_Controller extends Page_Controller {}