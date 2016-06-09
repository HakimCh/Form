<?php
namespace HakimCh\Form;

class Form
{
    /**
     * Submitted datas
     * @var array
     */
    public $datas = [];

    /**
     * Tag attributes
     * @var array
     */
    public $attributes = [];

    /**
     * Form action url
     * @var string
     */
    private $action = '';

    /**
     * Form CSRF token
     * @var string
     */
    private $token = '';

    /**
     * Class instance
     * @var object
     */
    private static $instance;

    /**
     * Class's Instance
     * @return object
     */
    public static function init()
    {
        if(is_null(self::$instance)) {
            self::$instance = new Form();
        }
        return self::$instance;
    }

    /**
     * Setup the class provided from a framework or script
     * @param array $datas Submitted data (GET, POST)
     * @param string $token CSRF token
     * @param string $action Url action
     */
    public function setup($datas=[], $token='', $action='')
    {
        $this->datas  = $datas;
        $this->token  = $token;
        $this->action = $action;
    }

    /**
     * Create Form tag
     * @param string $method
     * @param  string $action form url
     * @return string
     */
    public function open($method = 'POST', $action = '')
    {
        if(empty($action)) {
            $action = $this->action;
        }
        $html = '<form action="'.$action.'" method="'.$method.'"'.$this->attributesToHtml().'>';
        if(!empty($this->token)) {
            $html .= $this->addAttr('value', $this->token)->input('token', 'hidden');
        }
        return $html;
    }

    /**
     * Create label
     * @param  string|integer $value
     * @param  boolean $required
     * @return string
     */
    public function label($value, $required = null)
    {
        $labelValue = ucfirst($value);
        if($required) {
            $labelValue .= ' <span class="required">*</span>';
        }
        return $this->addTag('label', $labelValue);
    }

    /**
     * Create Select tag
     * @param string $fieldName
     * @param array $options
     * @return string
     */
    public function select($fieldName, $options = [])
    {
        $fieldOptions = '';
        if(!empty($options)) {
            $fieldValue = $this->get($fieldName);
            foreach($options as $value => $text) {
                $selected = $fieldValue != $value ?: ' selected="selected"';
                $fieldOptions .= '<option value="'.$value.'"'.$selected.'>'.ucfirst($text).'</option>';
            }
        }
        return $this->addTag('select', $fieldOptions);
    }

    /**
     * Create Textarea tag
     * @param  string $fieldName
     * @return string
     */
    public function textarea($fieldName)
    {
        $fieldValue = $this->get($fieldName);
        return $this->addTag('textarea', $fieldValue);
    }

    /**
     * Create submit button
     * @param  string  $value field text
     * @param  boolean $iconClass the icon class from (fontawsome, ionicons...)
     * @return string
     */
    public function button($value = 'Submit', $iconClass = null)
    {
        if($iconClass){
            $value .= ' <i class="'.$iconClass.'"></i>';
        }
        return $this->addTag('button', $value);
    }

    /**
     * Create submit button
     * @param  string $value  Field value
     * @return string
     */
    public function submit($value = 'Submit')
    {
        return $this->addAttr('value', $value)->input('submit', 'submit');
    }

    /**
     * Add an attribute to the field
     * @param String|Array $key attribute name
     * @param Integer|String $value attribute value
     * @return $this
     */
    public function addAttr($key, $value = null)
    {
        if(is_array($key))
            $this->attributes += $key;
        else
            $this->attributes[$key] = $value;
        return $this;
    }

    /**
     * Get element by key from the user datas
     * @param  string $key the field name
     * @param  string $source source of datas (datas, files, attributes)
     * @return Return value or a null
     */
    public function get($key = '', $source = 'datas')
    {
        if(property_exists($this, $source)) {
            $property = $this->$source;
            if(!empty($property) && array_key_exists($key, $property))
                return $property[$key];
        }
        return null;
    }

    /**
     * Create Input field
     * @param  string $fieldName Field name
     * @param  string $type field type (text, password...)
     * @return string
     */
    protected function input($fieldName, $type) {
        $value = $this->get($fieldName);
        if(!is_null($value)) {
            $this->attributes['value'] = $this->get($fieldName);
        }
        return '<input type="'.$type.'" name="'.$fieldName.'"'.$this->attributesToHtml().'>';
    }

    /**
     * Create a radio/checkbox field
     * @param string $fieldName field name
     * @param string $fieldLabel field label
     * @param string $type field type
     * @return string
     */
    protected function box($fieldName, $fieldLabel = '', $type = '')
    {
        $fieldValue = $this->get($fieldName);
        $value = $this->get('value', 'attrs');
        if($fieldValue && $value){
            $checked = is_array($fieldValue) ? array_key_exists($value, array_flip($fieldValue)) : $fieldValue == $value;
            if($checked){
                $this->attributes['checked'] = 'checked';
            }
        }
        return $this->input($fieldName, $type) . " " . $fieldLabel;
    }

    /**
     * Add an HTML Form tag
     * @param $tagType Tag type (label, textarea, select...)
     * @param $tagContent  Tag content or value
     * @return string
     */
    protected function addTag($tagType, $tagContent)
    {
        $attributes = $this->attributesToHtml();
        return '<'.$tagType.' '.$attributes.'>'.$tagContent.'</'.$tagType.'>';
    }

    /**
     * Generate field's attributes
     * @param string $html
     * @return string
     */
    private function attributesToHtml($html = '')
    {
        if(!empty($this->attributes)) {
            foreach($this->attributes as $key => $value) {
                $value = is_array($value) ? implode(' ', $value) : $value;
                $html .= is_numeric($key) ? $value.' ' : $key.'="'.$value.'" ';
            }
        }
        $this->attributes = [];
        return $html;
    }

    /**
     * Magic methods call
     * @param $tagName
     * @param $methodParams
     * @return string
     */
    public function __call($tagName, $methodParams)
    {
        $method = null;
        if(in_array($tagName, ['text','password','date','time','file','hidden','reset'])) {
            array_push($methodParams, $tagName);
            $method = "input";
        }
        elseif(in_array($tagName, ['checkbox','radio'])) {
            array_push($methodParams, $tagName);
            $method = "box";
        }
        elseif($tagName == 'close') {
            return '</form>';
        }
        elseif($tagName == 'reset') {
            $this->datas = [];
        }
        $handler = [$this, $method];
        return !is_null($method) && is_callable($handler) ? call_user_func_array($handler, $methodParams) : '';
    }
}