<?php

class Singleton
{
    private static $instances = [];

    protected function __construct(){}
    protected function __clone(){}

    public static function getInstance()
    {
        $subClass = static::class;
        if(!isset(self::$instances[$subClass])) {
            echo"Not instantiated\n";
            self::$instances[$subClass] = new static();
        }

        echo "instantiated\n";
        return self::$instances[$subClass];
    }
}

class Logger extends Singleton
{
    private static $logs = [];

    public static function writeLog($log)
    {
        array_push(self::$logs, $log);
    }

    public static function showLogs()
    {
        foreach (self::$logs as $log) {
            echo "$log\n";
        }
    }
}

function client_code() {
    var_dump(Logger::getInstance());
    Logger::writeLog("Log1");
    Logger::writeLog("Log2");
    Logger::writeLog("Log3");

    Logger::showLogs();

    var_dump(Logger::getInstance());

}


client_code();