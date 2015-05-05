<?php

/**
 * Class BlogHolder
 */
class BlogHolder extends Page {

    private static $icon = 'boilerplate/code/Modules/Blog/images/blogs-stack.png';

    private static $db = array(
        'BlogSidebarContent' => 'HTMLText'
    );

    private static $allowed_children = array('BlogPage');

    private static $description = 'Displays all blog child pages';

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();

        /** -----------------------------------------
         * Blog Sidebar
        -------------------------------------------*/

        $fields->addFieldToTab('Root.BlogSidebar', HeaderField::create('', 'Sidebar'));
        $fields->addFieldToTab('Root.BlogSidebar', LiteralField::create('',
            '<p>The content for the sidebar will be displayed in the left-hand side of this page.</p>'
        ));
        $fields->addFieldToTab('Root.BlogSidebar', $blogSidebarContent = HtmlEditorField::create('BlogSidebarContent', 'Content (optional)'));
        $blogSidebarContent->setRows(10);

        return $fields;
    }

    /**
     * Return a ArrayList of all blog children of this page.
     *
     * @return PaginatedList
     */
    public function PaginatedPages() {
        /**
         * Protect against "Division by 0" error
         */
        if($this->Items == null || $this->Items == 0) $this->Items = 10;
        $pagination = PaginatedList::create($this->AllChildren(), Controller::curr()->request);
        $pagination->setPageLength($this->Items);
        return $pagination;
    }

}

/**
 * Class BlogHolder_Controller
 */
class BlogHolder_Controller extends Page_Controller {}