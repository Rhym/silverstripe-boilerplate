<?php

class StyleField extends FormField {

    protected $selector = '';

    /**
     * @param string $name
     * @param null $title
     * @param string $selector
     * @param string $value
     */
    public function __construct($name, $title = null, $selector = '', $value = '') {
        if(is_string($selector)) $this->setSelector($selector);
        parent::__construct($name, $title, $value);
    }

    /**
     * @param array $properties
     * @return string
     */
    public function Field($properties = array()) {

        Requirements::css(BOILERPLATE_MODULE.'/css/styleField.min.css');
        Requirements::css(BOILERPLATE_MODULE.'/css/colorpicker.css');
        Requirements::javascript(BOILERPLATE_MODULE.'/javascript/lib/colorpicker.min.js');
        Requirements::javascript(BOILERPLATE_MODULE.'/javascript/colorpicker.init.js');

        $name = $this->name . '[]';
        $out = '';

        // Selector
        $out .= FormField::create_tag('input', array(
            'type' => 'hidden',
            'id' => $this->id().':0',
            'value' => $this->selector,
            'name' => $name
        ));

        $out .= '<h4>CSS</h4>';
        $out .= '<div class="field size">';
            $out .= '<div class="size-container">';
                $out .= '<span class="margin label">Margin</span>';
                $out .= '<span class="border label">Border</span>';
                $out .= '<span class="padding label">Padding</span>';
                $out .= '<div class="inner"><div class="inner"></div></div>';
                $out .= $this->createTextField($name, 1, 'marginTop');
                $out .= $this->createTextField($name, 2, 'marginRight');
                $out .= $this->createTextField($name, 3, 'marginBottom');
                $out .= $this->createTextField($name, 4, 'marginLeft');
                $out .= $this->createTextField($name, 5, 'borderTop');
                $out .= $this->createTextField($name, 6, 'borderRight');
                $out .= $this->createTextField($name, 7, 'borderBottom');
                $out .= $this->createTextField($name, 8, 'borderLeft');
                $out .= $this->createTextField($name, 9, 'paddingTop');
                $out .= $this->createTextField($name, 10, 'paddingRight');
                $out .= $this->createTextField($name, 11, 'paddingBottom');
                $out .= $this->createTextField($name, 12, 'paddingLeft');
            $out .= '</div>';
            $out .= '<div class="color-container">';
                $out .= '<h4>Border</h4>';
                $out .= $this->createColorField($name, 13, 'borderColor');
                $out .= '<h4>Text</h4>';
                $out .= $this->createColorField($name, 14, 'Text');
                $out .= $this->createColorField($name, 15, 'Heading');
                $out .= '<h4>Background</h4>';
                $out .= $this->createColorField($name, 16, 'Color');
            $out .= '</div>';
        $out .= '</div>';

        return $out;
    }

    /**
     * @param $str
     * @return $this
     */
    public function setSelector($str) {
        $this->selector = $str;
        return $this;
    }

    /**
     * @return string
     */
    public function getSelector() {
        return $this->selector;
    }

    /**
     * @param $name
     * @param $id
     * @return string
     */
    public function createTextField($name, $id, $extraClass = null, $value = ''){
        //$value = '';
        if(isset($this->value[$id])){
            $value = $this->value[$id];
        }
        return '<div class="input-group">'.FormField::create_tag('input', array(
            'class' => 'text '.$extraClass,
            'id' => $this->id().':'.$id,
            'value' => $value,
            'name' => $name,
            'placeholder' => '-'
        )).'</div>';
    }

    /**
     * @param $name
     * @param $id
     * @return string
     */
    public function createColorField($name, $id, $label = null){
        $value = '';
        if(isset($this->value[$id])){
            $value = $this->value[$id];
        }
        $out = '';

        $color = '#000000';
        if($value) {
            $c = intval(str_replace("#", "", $value), 16);
            $r = $c >> 16;
            $g = ($c >> 8) & 0xff;
            $b = $c & 0xff;
            $mid = ($r + $g + $b) / 3;
            $color = ($mid > 127) ? '#000000' : '#ffffff';
        }
        $style = 'background-image: none;background-color:' . ($value ? $value : '#ffffff'). ';color:' . $color . ';';

        $out .= '<div class="field color text">';
            $out .= '<label class="left" for="'.$this->id().':'.$id.'">'.$label.'</label>';
            $out .= '<div class="middleColumn">';
                $out .= '<div class="iris-container">';
                    $out .= '<label class="iris-color-label" for="'.$this->id().':'.$id.'"><span class="ss-ui-button">Select a color</span></label>';
                    $out .= FormField::create_tag('input',array(
                        'class' => 'text color-picker color',
                        'id' => $this->id().':'.$id,
                        'value' => $value,
                        'name' => $name,
                        'maxlength' => 7,
                        'size' => 7,
                        'style' => $style
                    ));
                $out .= '</div>';
            $out .= '</div>';
        $out .= '</div>';

        return $out;
    }

    /**
     * @param mixed $v
     * @return FormField|void
     */
    public function setValue($v) {
        if (is_array($v)) {
            /**
             * we've been set directly via the post - lets prune any empty values
             */
            foreach ($v as $key => $val) {
                if (!strlen($val)) {
                    unset($v[$key]);
                }
            }
        }
        if ($v instanceof MultiValueField) {
            $v = $v->getValues();
        }
        if (!is_array($v)) {
            $v = array();
        }
        parent::setValue($v);
    }
}