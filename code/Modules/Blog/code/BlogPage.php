<?php

/**
 * Class BlogPage
 */
class BlogPage extends Page {

    private static $icon = 'boilerplate/code/Modules/Blog/images/blog.png';

    private static $db = array(
        'Date'      => 'Date',
        'Author'    => 'Text'
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

        $fields->addFieldToTab('Root.Main', $blogImage = UploadField::create('Image', 'Image'), 'Content');
        $blogImage->setRightTitle('Image is used on BlogHolder pages as a thumbnail, as well as at the top of this page\'s content.');
        $blogImage->setFolderName('Uploads/blog');
        $fields->addFieldToTab('Root.Main', $dateField = DateField::create('Date', 'Article Date (optional)'), 'Content');
        $dateField->setConfig('showcalendar', true);
        $fields->addFieldToTab('Root.Main', $dateField, 'Content');
        $fields->addFieldToTab('Root.Main', TextField::create('Author', 'Author (optional)'), 'Content');

        /** -----------------------------------------
         * Tags - Disabled by Default
        -------------------------------------------*/

        $config = GridFieldConfig_RelationEditor::create(10);
        $config->addComponent(new GridFieldSortableRows('SortOrder'))
            ->addComponent(new GridFieldDeleteAction());
        $gridField = GridField::create(
            'Tags',
            'Tags',
            $this->Tags(),
            $config
        );
        //$fields->addFieldToTab('Root.Tags', $gridField);

        return $fields;

    }

}

/**
 * Class BlogPage_Controller
 */
class BlogPage_Controller extends Page_Controller {}