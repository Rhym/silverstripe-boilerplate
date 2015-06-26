<?php

/**
 * Class ColorField
 */
class ColorField extends TextField {

    private static $primary_color = '#3f51b5';

    private static $secondary_color = '#ff4081';

    /**
     * @param string $name
     * @param null $title
     * @param string $value
     * @param null $form
     */
    public function __construct($name, $title = null, $value = '', $form = null) {
		parent::__construct($name, $title, $value, 7, $form);

        Requirements::css(BOILERPLATE_MODULE.'/css/colorpicker.css');
        Requirements::javascript(BOILERPLATE_MODULE.'/javascript/lib/colorpicker.min.js');
        Requirements::javascript(BOILERPLATE_MODULE.'/javascript/colorpicker.init.js');

        $this->addExtraClass('text');
	}

    /**
     * @param array $properties
     * @return HTMLText
     */
    public function Field($properties = array()) {
		$this->addExtraClass('color-picker');
        $style = 'background-image: none;background-color:' . ($this->value ? $this->value : '#ffffff'). '; color: ' . ($this->getTextColor()) . ';';
        $this->setAttribute('style', $style);
        $this->setAttribute('data-palette', '["'.$this->stat('primary_color').'", "'.$this->stat('secondary_color').'", "#212121", "#fff"]');

        $properties['type'] = 'text';
        $properties['class'] = 'text' . ($this->extraClass() ? $this->extraClass() : '');
        $properties['tabindex'] = $this->getAttribute('tabindex');
        $properties['maxlength'] = ($this->maxLength) ? $this->maxLength : null;
        $properties['size'] = ($this->maxLength) ? min( $this->maxLength, 30 ) : null;
		if ($this->disabled) $properties['disabled'] = 'disabled';

        $obj = ($properties) ? $this->customise($properties) : $this;
        return $obj->renderWith($this->getTemplates());
	}

    /**
     * @param $validator
     * @return bool
     */
    function validate($validator) {
		return true;
	}

    /**
     * Set the colour to be white or black
     * depending on the shade of the background
     * colour of the Field.
     *
     * @return string
     */
    protected function getTextColor() {
		if ($this->value) {
			$c = intval(str_replace("#", "", $this->value), 16);
			$r = $c >> 16;
			$g = ($c >> 8) & 0xff;
			$b = $c & 0xff;
			$mid = ($r + $g + $b) / 3;
			return ($mid > 127) ? '#000000' : '#ffffff';
		} else {
			return '#000000';
		}
	}
    
}