<?php

/**
 * Class FlashMessageConfig
 */
class FlashMessageConfig extends DataExtension
{

    /**
     * @param $message
     * @param string $type
     */
    public function setFlash($message, $type = 'info')
    {
        Session::set('FlashMessage', array(
            'FlashMessageType' => $type,
            'FlashMessage' => $message
        ));
    }

    /**
     * @return HTMLText
     */
    public function getFlashMessage()
    {
        /** =========================================
         * @var ArrayData $array
        ===========================================*/

        if ($message = Session::get('FlashMessage')) {
            Session::clear('FlashMessage');
            $array = ArrayData::create($message);
            return $array->renderWith('FlashMessage');
        }
        return false;
    }

}