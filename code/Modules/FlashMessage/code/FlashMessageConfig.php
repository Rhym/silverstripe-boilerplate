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
    public function setFlash($message = '', $type = 'info')
    {
        Session::set('FlashMessage', array(
            'FlashMessageType' => (string)$type,
            'FlashMessage' => (string)$message
        ));
    }

    /**
     * @return HTMLText
     */
    public function getFlashMessage()
    {
        if ((string)$message = Session::get('FlashMessage')) {
            Session::clear('FlashMessage');
            /** @var ArrayData $array */
            $array = ArrayData::create($message);
            return $array->renderWith('FlashMessage');
        }
        return false;
    }

}
