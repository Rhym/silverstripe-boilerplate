<?php

/**
 * Class BlogHolder
 */
class BlogHolder extends Page {

    private static $icon = 'boilerplate/code/Modules/Blog/images/blogs-stack.png';

    private static $db = array(
        'Columns' => 'Int',
        'Items' => 'Int',
        'BlogSidebarContent' => 'HTMLText'
    );

    private static $allowed_children = array('BlogPage');

    private static $defaults = array(
        'Columns' => 0,
        'Items' => 10
    );

    private static $description = 'Displays all blog child pages';

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();

        /* -----------------------------------------
         * Settings
        ------------------------------------------*/

        $fields->addFieldToTab('Root.Main', $columns = new OptionsetField('Columns', 'Columns (items)', array(
            'One (full width)',
            'Two',
            'Three',
            'Four'
        )), 'Content');
        $columns->setRightTitle('Items per row');
        $fields->addFieldToTab('Root.Main', $items = new NumericField('Items', 'Items'), 'Content');
        $items->setRightTitle('Items displayed per page');

        /* -----------------------------------------
         * Blog Sidebar
        ------------------------------------------*/

        $fields->addFieldToTab('Root.BlogSidebar', new HeaderField('', 'Sidebar'));
        $fields->addFieldToTab('Root.BlogSidebar', new LiteralField('',
            '<p>The content for the sidebar will be displayed in the left-hand side of this page.</p>'
        ));
        $fields->addFieldToTab('Root.BlogSidebar', new HtmlEditorField('BlogSidebarContent', 'Content'));

        return $fields;
    }

    /**
     * Return a ArrayList of all blog children of this page.
     *
     * @return PaginatedList
     */
    public function PaginatedPages() {
        // Protect against "Division by 0" error
        if($this->Items == null || $this->Items == 0) $this->Items = 10;
        $pagination = new PaginatedList($this->AllChildren(), Controller::curr()->request);
        $pagination->setPageLength($this->Items);
        return $pagination;
    }

}
class BlogHolder_Controller extends Page_Controller {

    /**
     * @return string
     */
    public function ColumnClass(){
        switch($this->Columns){
            case 1:
                return 'col-sm-6';
                break;
            case 2:
                return 'col-sm-4';
                break;
            case 3:
                return 'col-sm-3';
                break;
            default:
                return 'col-sm-12';
        }
    }

    /**
     * @return int
     */
    public function ColumnMultiple(){
        switch($this->Columns){
            case 1:
                return 2;
                break;
            case 2:
                return 3;
                break;
            case 3:
                return 4;
                break;
            default:
                return 1;
        }
    }

}