# slzcrypt
Small wrapper around openssl encryption in PHP. Another breakout from my custom framework.

## Install

Use composer

    composer require salernolabs/slzcrypt

## Usage

Instantiate a class with a key and encrypt or decrypt data.

    $crypt = new \SalernoLabs\Slzcrypt\Crypt($key);

    $encrypted = $crypt->encrypt($input);

    $decrypted = $crypt->decrypt($encrypted);