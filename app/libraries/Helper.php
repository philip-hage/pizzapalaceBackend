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


    public static function encrypt($data, $key)
    {
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = openssl_encrypt($data, 'aes-256-cbc', $key, 0, $iv);

        // Concatenate $iv and $encrypted, then replace '/' with a different character
        $combined = $iv . $encrypted;
        $encoded = base64_encode($combined);
        $encoded = str_replace('/', '_', $encoded); // Replace '/' with '_'

        return $encoded;
    }


    public static function decrypt($data, $key)
    {
        $data = base64_decode($data);
        $iv = substr($data, 0, openssl_cipher_iv_length('aes-256-cbc'));
        $encrypted = substr($data, openssl_cipher_iv_length('aes-256-cbc'));
        return openssl_decrypt($encrypted, 'aes-256-cbc', $key, 0, $iv);
    }

    public static function crypt($action, $string)
    {
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_key = 'This is my secret key';
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);

        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }

        return $output;
    }
}
