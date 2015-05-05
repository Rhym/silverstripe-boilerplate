<?php

/**
 * A DB field that serialises an array before writing it to the db, and returning the array
 * back to the end user.
 *
 * @author Marcus Nyeholt <marcus@silverstripe.com.au>
 */
class MultiValueField extends DBField implements CompositeDBField {
    protected $changed = false;

    /**
     * @param array
     */
    static $composite_db = array(
        "Value" => "Text",
    );

    /**
     * Returns the value of this field.
     * @return mixed
     */
    function getValue() {
        // if we're not deserialised yet, do so
        if ($this->exists() && is_string($this->value)) {
            $this->value = unserialize($this->value);
        }
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getValues() {
        return $this->getValue();
    }

    /**
     * Overridden to make sure that the user_error that gets triggered if this is already is set
     * ... doesn't. DataObject tries setting this at times that it shouldn't :/
     *
     * @param string $name
     */
    public function setName($name) {
        if (!$this->name) {
            parent::setName($name);
        }
    }

    /**
     * Set the value on the field.
     *
     * For a multivalue field, this will deserialise the value if it is a string
     * @param mixed $value
     * @param array $record
     */
    function setValue($value, $record = null, $markChanged = true) {
        if ($markChanged) {
            if (is_array($value)) {
                $this->value = $value;
                $this->changed = true;
            } else if (is_object($value)) {
                $this->value = isset($value->value) && is_array($value->value) ? $value->value : array();
                $this->changed = true;
            } else if (!$value) {
                $this->value   = array();
                $this->changed = true;
            }
            return;
        }

        if (!is_array($value) && $record && isset($record[$this->name.'Value'])) {
            $value = $record[$this->name.'Value'];
        }

        if ($value && is_string($value)) {
            $this->value = unserialize($value);
        } else if ($value) {
            $this->value = $value;
        }

        $this->changed = $this->changed || $markChanged;
    }

    /**
     * (non-PHPdoc)
     * @see core/model/fieldtypes/DBField#prepValueForDB($value)
     */
    function prepValueForDB($value) {
        if (!$this->nullifyEmpty && $value === '') {
            return "'" . Convert::raw2sql($value) . "'";
        } else {
            if ($value instanceof MultiValueField) {
                $value = $value->getValue();
            }
            if (is_object($value) || is_array($value)) {
                $value = serialize($value);
            }
            return parent::prepValueForDB($value);
        }
    }

    function requireField() {
        $parts=Array('datatype'=>'mediumtext', 'character set'=>'utf8', 'collate'=>'utf8_general_ci', 'arrayValue'=>$this->arrayValue);
        $values=Array('type'=>'text', 'parts'=>$parts);
        DB::requireField($this->tableName, $this->name . 'Value', $values);
    }

    function compositeDatabaseFields() {
        return self::$composite_db;
    }

    function writeToManipulation(&$manipulation) {
        if($this->getValue()) {
            $manipulation['fields'][$this->name.'Value'] = $this->prepValueForDB($this->getValue());
        } else {
            $manipulation['fields'][$this->name.'Value'] = DBField::create_field('Text', $this->getValue())->nullValue();
        }
    }

    function addToQuery(&$query) {
        parent::addToQuery($query);
        $name = sprintf('%sValue', $this->name);
        $val = sprintf('"%sValue"', $this->name);
        $select = $query->getSelect();
        if (!isset($select[$name])) {
            $query->addSelect(array($name => $val));
        }
    }

    function isChanged() {
        return $this->changed;
    }

    public function scaffoldFormField($title = null) {
        return StyleField::create($this->name, $title);
    }

    /**
     * Convert to a textual list of items
     */
    public function csv() {
        return $this->Implode(',');
    }

    /**
     * @param null $value
     * @return bool|string
     */
    public function generateCSS($backgroundImage = null){
        $value = $this->Value;

        if(isset($value)) {
            $out = '';

            /** -----------------------------------------
             * Sizing
            -------------------------------------------*/

            $out .= '@media (min-width: 768px){' . $value[0] . '{';

                // Margin
                $out .= (isset($value[1]) ? 'margin-top: ' . $value[1] . ';' : '');
                $out .= (isset($value[2]) ? 'margin-right: ' . $value[2] . ';' : '');
                $out .= (isset($value[3]) ? 'margin-bottom: ' . $value[3] . ';' : '');
                $out .= (isset($value[4]) ? 'margin-left: ' . $value[4] . ';' : '');

                // Border
                if(isset($value[5]) || isset($value[6]) || isset($value[7]) || isset($value[8])) {
                    $borderWidth = 'border-width: %s %s %s %s;';
                    $borderWidth = sprintf($borderWidth,
                        (isset($value[5]) ? $value[5] : 0),
                        (isset($value[6]) ? $value[6] : 0),
                        (isset($value[7]) ? $value[7] : 0),
                        (isset($value[8]) ? $value[8] : 0)
                    );
                    $out .= $borderWidth;
                    $out .= 'border-style:solid;';
                }

                // Padding
                $out .= (isset($value[9]) ? 'padding-top: ' . $value[9] . ';' : '');
                $out .= (isset($value[10]) ? 'padding-right: ' . $value[10] . ';' : '');
                $out .= (isset($value[11]) ? 'padding-bottom: ' . $value[11] . ';' : '');
                $out .= (isset($value[12]) ? 'padding-left: ' . $value[12] . ';' : '');

            $out .= '}}';

            /** -----------------------------------------
             * Colours / Background
            -------------------------------------------*/

            if(isset($value[13]) || isset($value[14]) || isset($value[16]) || $backgroundImage->exists()) {
                $out .= $value[0] . '{';
                // Colors
                $out .= (isset($value[13]) ? 'border-color: ' . $value[13] . ';' : '');
                $out .= (isset($value[14]) ? 'color: ' . $value[14] . ';' : '');
                $out .= (isset($value[16]) ? 'background-color: ' . $value[16] . ';' : '');
                $out .= ($backgroundImage->exists() ? 'background-image: url(' . $backgroundImage->URL . ');' : '');
                $out .= '}';
            }

            /** -----------------------------------------
             * Typography
            -------------------------------------------*/

            if(isset($value[15])) {
                $out .= $value[0] . ' h2,' .
                    $value[0] . ' h3,' .
                    $value[0] . ' h4{color:' . $value[15] . ';}';
            }

            return $out;
        }
        return false;
    }

    /**
     * Return all items separated by a separator, defaulting to a comma and
     * space.
     *
     * @param  string $separator
     * @return string
     */
    public function Implode($separator = ', ') {
        return implode($separator, $this->getValue());
    }

    public function Items() {
        return $this->forTemplate();
    }

    public function forTemplate() {
        $items = array();
        if ($this->value) {
            foreach ($this->value as $key => $item) {
                $v = new Varchar('Value');
                $v->setValue($item);

                $obj = ArrayData::create(array(
                    'Value' => $v,
                    'Key'	=> $key,
                    'Title' => $item
                ));
                $items[] = $obj;
            }
        }

        return ArrayList::create($items);
    }
}