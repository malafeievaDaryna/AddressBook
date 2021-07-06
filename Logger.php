<?php

class Logger
{
    private static ?Logger $instance = null;
    private $myfile = null;

    private function __construct() 
    { 
        $this->myfile = fopen("log.txt", "a");
    }
    
    function __destruct() 
    { 
        fclose($this->myfile);
    }

    private function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): Logger
    {
        if(self::$instance === null) {
            self::$instance = new Logger();
        }
        return self::$instance;
    }

    public function log($arg)
    {
        fwrite($this->myfile, $arg."\n");
    }
}
