<?php

/**
 * Class PortfolioHolder
 *
 * @property int Items
 * @mixin Hierarchy
 */
class PortfolioHolder extends Page
{

    private static $icon = 'boilerplate/code/Modules/Portfolio/images/blogs-stack.png';

    private static $db = array(
        'Items' => 'Int'
    );

    private static $allowed_children = array('PortfolioPage');

    private static $description = 'Displays all portfolio child pages';

    private static $defaults = array(
        'Items' => 10
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** =========================================
         * @var FieldList $fields
         * @var NumericField $items
        ===========================================*/

        $fields = parent::getCMSFields();

        /** -----------------------------------------
         * Fields
         * ----------------------------------------*/

        $fields->addFieldToTab('Root.Main', $items = NumericField::create('Items', 'Items'), 'Content');
        $items->setRightTitle('Items outside of this limit will be displayed in a paginated list i.e "Page 1 - 2 - 3."');

        return $fields;
    }

    public function index(SS_HTTPRequest $request)
    {
        /** =========================================
         * @var PaginatedList $pagination
        ===========================================*/

        /**
         * Return a ArrayList of all blog children of this page.
         *
         * @return PaginatedList
         */
        $pagination = PaginatedList::create($this->liveChildren(true), Controller::curr()->request);
        $items = ($this->Items > 0 ? $this->Items : 10);
        $pagination->setPageLength($items);

        $data = array(
            'PaginatedPages' => $pagination
        );
        if ($request->isAjax()) {
            return $this->customise($data)
                ->renderWith('PortfolioHolder_Item');
        }
        return $data;
    }

}

/**
 * Class PortfolioHolder_Controller
 */
class PortfolioHolder_Controller extends Page_Controller
{
}