<?php
/**
 * Simple wrapper around Openssl encryption and decryption
 *
 * @package SalernoLabs
 * @subpackage Slzcrypt
 * @author Eric
 */
namespace SalernoLabs\Slzcrypt;

class Crypt
{
    /**
     * @var string
     */
    private $key;

    /**
     * Crypt constructor.
     * @param $key
     */
    public function __construct($key)
    {
        $this->key = $key;
    }

    /**
     * Encrypt an object
     *
     * @param $data
     * @return string
     */
    public function encrypt($data)
    {
        if (!is_object($data))
        {
            $object = new \stdClass();
            $object->_slzCryptData = $data;
        }

        $data = serialize($data);

        $iv = openssl_random_pseudo_bytes(16);

        $data = openssl_encrypt($data, 'AES-128-CBC', $this->key, 1, $iv);

        $data = base64_encode($iv . $data);

        return $data;
    }

    /**
     * Decrypt an object
     *
     * @param $data
     * @return mixed
     */
    public function decrypt($data)
    {
        //Decrypt the data
        $data = base64_decode($data);
        $iv = substr($data, 0, 16);
        $data = substr($data, 16);

        $data = openssl_decrypt($data, 'AES-128-CBC', $this->key, 1, $iv);

        $object = unserialize($data);

        if (!empty($object->_slzCryptData))
        {
            return $object->_slzCryptData;
        }

        return $object;
    }
}