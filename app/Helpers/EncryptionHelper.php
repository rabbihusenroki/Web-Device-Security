<?php

namespace App\Helpers;

class EncryptionHelper
{
    public static function encrypt($data, $key)
    {
        $output = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $output .= $data[$i] ^ $key[$i % strlen($key)];
        }
        return bin2hex($output);
    }

    public static function decrypt($data, $key)
    {
        $data = hex2bin($data);
        $output = '';
        for ($i = 0; $i < strlen($data); $i++) {
            $output .= $data[$i] ^ $key[$i % strlen($key)];
        }
        return $output;
    }
}
