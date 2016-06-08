<?php namespace HakimCh\Form;

class Form {

    /**
     * User datas
     * @var array
     */
    public $datas;

    /**
     * Field class name
     * @var array
     */
    public $classes;

    /**
     * Field attrs
     * @var array
     */
    public $attrs;

    /**
     * Field $action
     * @var string
     */
    protected $action;

    /**
     * Class instance
     * @var object
     */
    private static $instance;

    /** Initialize class variables */
    public function __construct() {
        $this->resetAttrs();
    }

    /**
     * Class's Instance
     * @return object
     */
    public static function init() {
        if(is_null(self::$instance)) {
            self::$instance = new Form();
        }
        return self::$instance;
    }

    /**
     * @param $datas
     * @param $action
     */
    public function setup($datas, $action)
    {
        $this->datas = $datas;
        $this->action = $action;
    }

    /**
     * Create Form tag
     * @param string $method
     * @param  string $action form url
     * @return string
     */
    public function open($method = 'POST', $action = null)
    {
        if(is_null($action)) {
            $action = $this->action;
        }
        return '<form action="'.$action.'" method="'.$method.'"'.$this->generateAttrs().'>';
    }

    /**
     * Create label
     * @param  INT/STR $value    Value
     * @param  string  $for      name of the field
     * @param  boolean $required The field is required or not
     * @return string
     */
    public function label($value, $for = null, $required = null) {
        $field = '<label for="'.$for.'">'.ucfirst($value);
        if($required) $field .= ' <span class="required">*</span>';
        return $field . '</label>';
    }

    /**
     * Add a text width tag (strong, label, span, i)
     * @param string  $text text to add
     * @param string  $tag  tag name
     * @return string
     */
    public function addText($text, $tag = null) {
        if(in_array($tag, ['strong', 'label', 'span', 'i'])) {
            $text = '<'.$tag.'>'.$text.'</'.$tag.'>';
        }
        return $text;
    }

    /**
     * Create Select options
     * @param  string $name    Field name
     * @param  array  $options Options
     * @return string
     */
    public function select($name, $options = []) {
        $field = '<select name="'.$name.'"'.$this->generateAttrs().'>';
        if(!empty($options)) {
            foreach($options as $value => $text) {
                $field .= '<option value="'.$value.'"';
                if($this->get($name) == $value) {
                    $field .= ' selected="selected"';
                }
                $field .= '>'.ucfirst($text).'</option>';
            }
        }
        return $field . '</select>';
    }

    /**
     * Create Textarea
     * @param  string $name   Field name
     * @return string
     */
    public function textarea($name) {
        return '<textarea name="'.$name.'"'.$this->generateAttrs().'>'.$this->get($name).'</textarea>';
    }

    /**
     * Create submit button
     * @param  string  $value  field text
     * @param  boolean $icon   the icon class from (fontawsome, typo, ionicons...)
     * @return string
     */
    public function button($value = 'Submit', $icon = null) {
        $input = '<button type="submit"';
        $input .= $this->generateAttrs();
        $input .= '>'.$value;
        if($icon) {
            $input .= ' <i class="'.$icon.'"></i>';
        }
        return $input.'</button>';
    }

    /**
     * Create submit buttom
     * @param  string $value  Field value
     * @return string
     */
    public function submit($value = 'Submit') {
        return '<input type="submit" value="'.$value.'"'.$this->generateAttrs().'>';
    }

    /** Reset form */
    public function reset() {
        $this->datas = null;
    }

    /**
     * Closing the form
     * @return string
     */
    public function close() {
        return '</form>';
    }

    /**
     * Get element by key from the user datas
     * @param  string $key      the field name
     * @param  string $source   source of datas (datas, files, attrs)
     * @return Return value or a null
     */
    public function get($key = null, $source = 'datas') {
        if(in_array($source, ['datas', 'files', 'attrs'])) {
            $array = $this->$source;
            if(array_key_exists($key, $array)) {
                return $array[$key];
            }
        }
        return null;
    }

    /**
     * Add a class name to the field
     * @param string $className class name
     * @return $this
     */
    public function addClass($className = '') {
        $this->classes[] = $className;
        return $this;
    }

    /**
     * Add attribue to the field
     * @param $key   attribue name
     * @param $value attribue value
     * @return $this
     */
    public function addAttr($key, $value = null) {
        if(is_array($key))
            $this->attrs += $key;
        else
            $this->attrs[$key] = $value;
        return $this;
    }

    /**
     * Add special attribues to form
     * @param $value
     * @return object
     */
    public function usedFor($value = '') {
        switch ($value) {
            case 'validation': $this->attrs['novalidate'] = 'novalidate'; break;
            case 'upload': $this->attrs['enctype'] = 'multipart/form-data'; break;
        }
        return $this;
    }

    /**
     * Create Input field
     * @param  string $name   Field name
     * @param  string $type   field type (text, password...)
     * @return string
     */
    protected function input($name, $type) {
        $value = $this->get($name);
        if(!is_null($value)) {
            $this->attrs['value'] = $this->get($name);
        }
        return '<input type="'.$type.'" name="'.$name.'"'.$this->generateAttrs().'>';
    }

    /**
     * Create a radio/checkbox field
     * @param  string $name field name
     * @param  string $type field type
     * @return string
     */
    protected function box($name, $type = '') {
        // Remove [] before getting field value
        $realName = strstr($name, '[', true) ?: $name;
        $fieldValue = $this->get($realName);
        $value = $this->get('value', 'attrs');
        if($fieldValue && $value){
            $checked = is_array($fieldValue) ? array_key_exists($value, array_flip($fieldValue)) : $fieldValue == $value;
            if($checked){
                $this->attrs['checked'] = 'checked';
            }
        }
        return $this->input($name, $type);
    }

    /**
     * Generate field's attributes
     * @param string $html
     * @return string
     */
    private function generateAttrs($html = '') {
        if(!empty($this->classes)) {
            $html .= 'class="' . implode(' ', $this->classes) . '" ';
        }
        if(!empty($this->attrs)) {
            foreach($this->attrs as $key => $value) {
                $html .= $key . '="' . $value . '" ';
            }
        }
        $this->resetAttrs();
        return $html;
    }

    /**
     * clean classes and attrs variable
     */
    private function resetAttrs()
    {
        $this->classes = $this->attrs = [];
    }

    /**
     * Magic methods call
     * @param  string $method the name of method
     * @param  array  $params the args of method
     * @return object
     */
    public function __call($method, $params)
    {
        if(in_array($method, ['text','password','date','time','file','hidden','reset'])) {
            array_push($params, $method);
            $method = "input";
        }
        elseif(in_array($method, ['checkbox','radio'])) {
            array_push($params, $method);
            $method = "box";
        }
        $handler = [$this, $method];
        if(is_callable($handler)){
            call_user_func_array($handler, $params);
        }
        return $this;
    }
}