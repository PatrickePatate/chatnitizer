<?php

class Chatnitizer
{
    private $toSanitize = "";
    private $sanitized = "";

    /**
     * @param $mode email|string|url|input|number|removehtml|phone|float|trim (support for pipe -> multiples test at once)
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
    // Alias that is more logic cause email and phone can return false
    public function getValue(){
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
        return htmlspecialchars($this->toSanitize);
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

    protected function phone(){
        if (preg_match("/\+(9[976]\d|8[987530]\d|6[987]\d|5[90]\d|42\d|3[875]\d|2[98654321]\d|9[8543210]|8[6421]|6[6543210]|5[87654321]|4[987654310]|3[9643210]|2[70]|7|1)\d{1,14}$/", $this->toSanitize)) {
            $this->sanitized = $this->toSanitize;
            return $this->toSanitize;
        }else{
            return false;
        }

    }

    protected function trim(){
        $str = trim($this->toSanitize);
        return $str;
    }

    protected function float(){
        $str = filter_var($this->toSanitize, FILTER_SANITIZE_NUMBER_FLOAT);
        return $str;
    }

    protected function number(){
        $num = filter_var($this->toSanitize, FILTER_SANITIZE_NUMBER_INT);
        return $num;
    }
}