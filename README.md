# salernolabs/slzcrypt

[![Latest Stable Version](https://poser.pugx.org/salernolabs/slzcrypt/v/stable)](https://packagist.org/packages/salernolabs/slzcrypt)
[![License](https://poser.pugx.org/salernolabs/slzcrypt/license)](https://packagist.org/packages/salernolabs/slzcrypt)
[![Build Status](https://travis-ci.org/salernolabs/slzcrypt.svg?branch=master)](https://travis-ci.org/salernolabs/slzcrypt)

Wrapper around OpenSSL encryption in PHP. Another breakout from my custom framework.

## Install

Use composer

    composer require salernolabs/slzcrypt

## Usage

Instantiate a class with a key and encrypt or decrypt data.

    $crypt = new \SalernoLabs\Slzcrypt\Crypt($key);

    $encrypted = $crypt->encrypt($input);

    $decrypted = $crypt->decrypt($encrypted);