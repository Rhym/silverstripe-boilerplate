<?php

/**
 * Class PortfolioHolder
 *
 * @property int Items
 * @mixin Hierarchy
 */
class PortfolioHolder extends Page
{
    /**
     * @var string
     */
    private static $icon = 'boilerplate/code/Modules/Portfolio/images/blogs-stack.png';

    /**
     * @var array
     */
    private static $db = array(
        'Items' => 'Int'
    );

    /**
     * @var array
     */
    private static $allowed_children = array('PortfolioPage');

    /**
     * @var string
     */
    private static $description = 'Displays all portfolio child pages';

    /**
     * @var array
     */
    private static $defaults = array(
        'Items' => 10
    );

    /**
     * @return FieldList
     */
    public function getCMSFields()
    {
        /** @var FieldList $fields */
        $fields = parent::getCMSFields();

        /** -----------------------------------------
         * Fields
         * ----------------------------------------*/

        /** @var NumericField $items */
        $fields->addFieldToTab('Root.Main', $items = NumericField::create('Items', 'Items'), 'Content');
        $items->setRightTitle('Items outside of this limit will be displayed in a paginated list i.e "Page 1 - 2 - 3."');

        return $fields;
    }

    /**
     * Return a ArrayList of all blog children of this page.
     *
     * @param SS_HTTPRequest $request
     * @return array|HTMLText
     * @throws Exception
     */
    public function index(SS_HTTPRequest $request)
    {
        /** @var PaginatedList $pagination */
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
