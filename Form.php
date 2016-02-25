<?php namespace HakimCh\Form;

class Form {

    /**
     * User datas
     * @var array
     */
    public $datas;

    /** 
     * Files user datas
     * @var array
     */
    public $files;

    /**
     * Field class name
     * @var array
     */
    private $classes;

    /**
     * Field attrs
     * @var array
     */
    private $attrs;

    /**
     * Class instance
     * @var object
     */
    private static $_instance;

    /**
     * Class's Instance
     * @return object
     */
    public static function init() {
        if(is_null(self::$_instance)) {
            self::$_instance = new Form();
        }
        return self::$_instance;
    }

    /** Initialize class variables */
    public function __construct() {
        $this->datas = $_SERVER['REQUEST_METHOD'] == 'GET' ? $_GET : $_POST;
        $this->files = $this->files();
        $this->classes = $this->attrs = [];
    }

    /**
     * Create Form tag
     * @param  string  $action form url
     */
    public function open($method = 'POST', $action = null) {
        $action = !is_null($action) ?: $this->curUrl();
        echo '<form action="'.$action.'" method="'.$method.'"'.$this->generateAttrs().'>';
    }

    /**
     * Create label
     * @param  INT/STR $value    Value
     * @param  string  $for      name of the field
     * @param  boolean $required The field is required or not
     * @return object
     */
    public function label($value, $for = null, $required = null) {
        $field = '<label for="'.$for.'">'.ucfirst($value);
        if($required) $field .= ' <span class="required">*</span>';
        echo $field . '</label>';
        return $this;
    }

    /**
     * Add a text width tag (strong, label, span, i)
     * @param string  $text text to add
     * @param string  $tag  tag name
     */
    public function addText($text, $tag = null) {
        if(in_array($tag, ['strong', 'label', 'span', 'i'])) {
            $text = '<'.$tag.'>'.$text.'</'.$tag.'>';
        }
        echo $text;
    }

    /**
     * Create Select options
     * @param  string $name    Field name
     * @param  array  $options Options
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
        echo $field . '</select>';
    }

    /**
     * Create Textarea
     * @param  string $name   Field name
     */
    public function textarea($name) {
        echo '<textarea name="'.$name.'"'.$this->generateAttrs().'>'.$this->get($name).'</textarea>';
    }

    /**
     * Create submit button
     * @param  string  $value  field text
     * @param  boolean $icon   the icon class from (fontawsome, typo, ionicons...)
     */
    public function button($value = 'Submit', $icon = null) {
        $input = '<button type="submit"';
        $input .= $this->generateAttrs();
        $input .= '>'.$value;
        if($icon) {
            $input .= ' <i class="'.$icon.'"></i>';
        }
        echo $input.'</button>';
    }

    /**
     * Create submit buttom
     * @param  string $value  Field value
     */
    public function submit($value = 'Submit') {
        echo '<input type="submit" value="'.$value.'"'.$this->generateAttrs().'>';
    }

    /** Reset form */
    public function reset() {
        $this->datas = null;
    }

    /** Closing the form */
    public function close() {
        echo '</form>';
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
     */
    public function addClass($className = '') {
        array_push($this->classes, $className);
        return $this;
    }

    /**
     * Add attribue to the field
     * @param $key   attribue name
     * @param $value attribue value
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
     */
    private function input($name, $type) {
        $this->attrs['value'] = $this->get($name);
        echo '<input type="'.$type.'" name="'.$name.'"'.$this->generateAttrs().'>';
    }

    /**
     * Create a radio/checkbox field
     * @param  string $name field name
     * @param  string $type field type
     */
    private function box($name, $type = '') {
        // Remove [] before getting field value
        $realName = strstr($name, '[', true) ?: $name;
        $fieldValue = $this->get($realName);
        if($fieldValue){
            $value = $this->get('value', 'attrs');
            if($value){
                if(is_array($fieldValue)) {
                    $checked = array_key_exists($value, array_flip($fieldValue));
                } else {
                    $checked = $fieldValue == $value;
                }
                if($checked){
                    $this->attrs['checked'] = 'checked';
                }
            }
        }
        echo '<input type="'.$type.'" name="'.$name.'"'.$this->generateAttrs().'>';
    }

    /**
     * Generate a cleaned submited files inputs
     * @return array
     */
    private function files() {
        if(isset($_FILES) && !empty($_FILES)) {
            $files = [];
            foreach($_FILES as $name => $file) {
                if($file["error"] == 0) {
                    $files[$name] = [
                        'name'  => time(),
                        'size'  => $file["size"],
                        'old'   => pathinfo($file['name'], PATHINFO_FILENAME),
                        'ext'   => pathinfo($file['name'], PATHINFO_EXTENSION)
                    ];
                }
                else
                    $files[$name] = false;
            }
            return $files;
        }
        return null;
    }

    /**
     * Generate field's attributes
     * @param  string $type Field type
     * @return text
     */
    private function generateAttrs() {
        $html = '';
        if(!empty($this->classes)) {
            $this->attrs['class'] = implode(' ', $this->classes);
        }
        if(!empty($this->attrs)) {
            foreach($this->attrs as $key => $value) {
                $html .= " $key=\"$value\"";
            }
        }
        $this->classes = $this->attrs = [];
        return $html;
    }

    /**
     * Get the current url
     * @return string current url
     */
    private function curUrl() {
        $url = 'http';
        if (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {$url .= "s";}
        $url .= "://";
        if ($_SERVER["SERVER_PORT"] != "80") {
            $url .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
            $url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        return $url;
    }

    /**
     * Magic methods call
     * @param  string $method the name of method
     * @param  array  $params the args of method
     * @return object
     */
    public function __call($method, $params) {
        if(in_array($method, ['text','password','date','time','file','hidden','reset'])) {
            array_push($params, $method);
            $method = "input";
        }
        if(in_array($method, ['checkbox','radio'])) {
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