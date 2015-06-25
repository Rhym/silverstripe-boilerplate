<?php

/**
 * Class BlogHolder
 *
 * @property string BlogSidebarContent
 * @property string Items
 *
 * @mixin Hierarchy
 */
class BlogHolder extends Page {

    private static $icon = 'boilerplate/code/Modules/Blog/images/blogs-stack.png';

    private static $db = array(
        'BlogSidebarContent'    => 'HTMLText',
        'Items'                 => 'Int'
    );

    private static $allowed_children = array('BlogPage');

    private static $description = 'Displays all blog child pages';

    private static $defaults = array(
        'Items' => 10
    );

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        /** =========================================
         * @var FieldList       $fields
         * @var NumericField    $items
         * @var HtmlEditorField $blogSidebarContent
        ===========================================*/

        $fields = parent::getCMSFields();

        /** -----------------------------------------
         * Fields
        -------------------------------------------*/

        $fields->addFieldToTab('Root.Main', $items = NumericField::create('Items', 'Items'), 'Content');
        $items->setRightTitle('Items outside of this limit will be displayed in a paginated list i.e "Page 1 - 2 - 3."');

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
     * @param SS_HTTPRequest $request
     * @return array|HTMLText
     */
    public function index(SS_HTTPRequest $request) {
        /** =========================================
         * @var PaginatedList $pagination
        ===========================================*/

        /**
         * Return a ArrayList of all BlogPage children of this page.
         *
         * @return PaginatedList
         */
        $pagination = PaginatedList::create($this->liveChildren(true), Controller::curr()->request);
        $items = ($this->Items > 0 ? $this->Items : 10);
        $pagination->setPageLength($items);
        $data = array (
            'PaginatedPages' => $pagination
        );

        /** If the request is AJAX */
        if($request->isAjax()) {
            return $this->customise($data)
                ->renderWith('BlogHolder_Item');
        }

        return $data;
    }

}

/**
 * Class BlogHolder_Controller
 */
class BlogHolder_Controller extends Page_Controller {}