<?php
class Helper
{

    public static function dump($data)
    {
        echo '<pre><code>';
        print_r($data);
        echo '</code></pre>';
    }

    public static function log($type, $data)
    {
        if ($type == 'event') {
            error_log('Event: ' . date('Ymd h:i:s') . " - " . $data);
        } else if ($type == 'error') {
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            error_log('Error: ' . date('Ymd h:i:s') . " - " . $caller['line'] . ' ' . $caller['file'] . "\n" . $data);
        } else if ($type == 'debug') {
            $bt = debug_backtrace();
            $caller = array_shift($bt);
            error_log("\n" . date('Ymd h:i:s') . "\n" . $caller['line'] . ' ' . $caller['file'] . "\n" . print_r($data, true) . "\n");
        }
    }
}
