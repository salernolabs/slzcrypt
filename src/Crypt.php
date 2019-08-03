<?php
namespace SalernoLabs\Slzcrypt;

/**
 * Simple wrapper around Openssl encryption and decryption
 *
 * @package SalernoLabs
 * @subpackage Slzcrypt
 * @author Eric
 */
class Crypt
{
    /** @var int */
    private const IV_BYTE_SIZE = 16;
    /** @var string */
    private const CIPHER_METHOD = 'AES-128-CBC';
    /** @var int  */
    private const KEY_LENGTH = 32;
    /**
     * @var string
     */
    private $key;

    /**
     * Crypt constructor.
     * @param string $key The key to use during encryption
     * @param callable $functionExists The class to determine if functions exist or not
     * @throws \Exception When openssl is not found
     */
    public function __construct(string $key, callable $functionExists = null)
    {
        $functionExists = $functionExists ?? function (string $function): bool {
            return \function_exists($function);
        };

        if (!$functionExists('openssl_digest') || !$functionExists('openssl_encrypt'))
        {
            throw new \Exception("OpenSSL library not found. Please add it to your php installation.");
        }

        $this->key = substr(openssl_digest($key, 'sha256'), 0, self::KEY_LENGTH);
    }

    /**
     * Encrypt something
     *
     * @param mixed $data
     * @return string
     */
    public function encrypt($data): string
    {
        if (!is_object($data))
        {
            $data = (object)[
                '_slzCryptData' => $data,
            ];
        }

        $data = serialize($data);

        $iv = openssl_random_pseudo_bytes(self::IV_BYTE_SIZE);

        $data = openssl_encrypt($data, self::CIPHER_METHOD, $this->key, 1, $iv);

        $data = base64_encode($iv . $data);

        return $data;
    }

    /**
     * Decrypt an object
     *
     * @param string $data
     * @return mixed
     */
    public function decrypt(string $data)
    {
        //Decrypt the data
        $data = base64_decode($data);
        $iv = substr($data, 0, self::IV_BYTE_SIZE);
        $data = substr($data, self::IV_BYTE_SIZE);

        $data = openssl_decrypt($data, self::CIPHER_METHOD, $this->key, 1, $iv);

        $object = unserialize($data);

        if (isset($object->_slzCryptData))
        {
            return $object->_slzCryptData;
        }

        return $object;
    }
}
