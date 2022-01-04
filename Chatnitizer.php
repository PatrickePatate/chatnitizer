<?php

class Chatnitizer
{
    private $toSanitize = "";
    private $sanitized = "";

    /**
     * @param $mode email|string|url|input|number|removehtml (support for pipe -> multiples test at once)
     * @param $string
     */
    public function __construct($mode, $string)
    {
        $this->toSanitize = $string;
        if(strstr($mode,'|')){
            $modes = explode("|",$mode);
            foreach ($modes as $m){
                if(method_exists($this,$m)){
                    $this->sanitized = $this->{$m}();
                    $this->toSanitize = $this->sanitized;
                }
            }
        }else{
            if(method_exists($this,$mode)){
                $this->sanitized = $this->{$mode}();
            }
        }

    }
    public function toString(){
        return $this->sanitized;
    }
    protected function email(){
        //sanitize email
        $email = filter_var($this->toSanitize, FILTER_SANITIZE_EMAIL);

        // validating email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            return($email);
        } else {
            return false;
        }
    }

    protected function removehtml(){
        $str_new= filter_var($this->toSanitize, FILTER_SANITIZE_STRING);
        return $str_new;
    }

    protected function string(){
        return htmlspecialchars( $this->toSanitize, ENT_NOQUOTES | ENT_HTML5 | ENT_SUBSTITUTE, 'UTF-8', /*double_encode*/false );
    }

    protected function url(){
        //url sanitizer
        $url = filter_var($this->toSanitize, FILTER_SANITIZE_URL);

        //url validator
        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            return $url;
        } else {
            return false;
        }
    }

    // remove or encode special characters
    protected function input(){
        $str = filter_var($this->toSanitize, FILTER_SANITIZE_ENCODED, FILTER_FLAG_STRIP_HIGH);
        return $str;
    }

    protected function number(){
        $num = filter_var($this->toSanitize, FILTER_SANITIZE_NUMBER_INT);
        return $num;
    }
}