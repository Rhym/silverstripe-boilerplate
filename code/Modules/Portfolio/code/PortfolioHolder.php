<?php

/**
 * Class PortfolioHolder
 */
class PortfolioHolder extends Page {

    private static $icon = 'boilerplate/code/Modules/Portfolio/images/blogs-stack.png';

    private static $allowed_children = array('PortfolioPage');

    private static $description = 'Displays all portfolio child pages';

    /**
     * @return FieldList
     */
    public function getCMSFields() {
        $fields = parent::getCMSFields();
        return $fields;
    }

    /**
     * @return PaginatedList
     */
    public function PaginatedPages() {
        /**
         * Protect against "Division by 0" error
         */
        if($this->Items == null || $this->Items == 0) $this->Items = 1;
        $pagination = new PaginatedList($this->AllChildren(), Controller::curr()->request);
        $pagination->setPageLength($this->Items);
        return $pagination;
    }

}

/**
 * Class PortfolioHolder_Controller
 */
class PortfolioHolder_Controller extends Page_Controller {

    /**
     * @return string
     */
    public function PortfolioThumbnailWidth(){
        switch($this->Columns){
            case 0:
                return '1140';
                break;
            default:
                return '722';
        }
    }

    /**
     * @return string
     */
    public function PortfolioThumbnailHeight(){
        switch($this->Columns){
            case 0:
                return '555';
                break;
            default:
                return '722';
        }
    }

}