<?php

namespace bambora;


class Logger
{
    private $handle, $dateFormat;

    public function __construct($file, $mode = "a") {
        if(!file_exists($file)){
            $this->handle = fopen($file, 'w') or die("Can't create file");
        }else{
            $this->handle = fopen($file, $mode);
        }
        $this->dateFormat = "Y-m-d H:i:s";
    }

    public function setdateFormat($format) {
        $this->dateFormat = $format;
    }

    public function getDateFormat() {
        return $this->dateFormat;
    }

    /**
     * Writes info to the log
     * @param mixed, string or an array to write to log
     * @access public
     */
    public function log($log_entries) {
        if(is_string($log_entries)) {
            fwrite($this->handle, "[" . date($this->dateFormat) . "] " . $log_entries . "\n\n");
        } else {
            foreach($log_entries as $log_value) {
                fwrite($this->handle, "[" . date($this->dateFormat) . "] " . $log_value . "\n\n");
            }
        }
    }
}