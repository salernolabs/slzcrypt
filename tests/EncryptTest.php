<?php
/**
 * Tests for Crypt class
 *
 * @package SalernoLabs
 * @subpackage Slzcrypt
 * @author Eric
 */
namespace SalernoLabs\Tests\Slzcrypt;

class EncryptTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test encryption
     *
     * @param $input
     * @param $key
     *
     * @covers \SalernoLabs\Slzcrypt\Crypt::encrypt
     * @covers \SalernoLabs\Slzcrypt\Crypt::decrypt
     * @dataProvider dataProviderForEncryption
     */
    public function testEncryption($input, $key)
    {
        $crypt = new \SalernoLabs\Slzcrypt\Crypt($key);

        $encrypted = $crypt->encrypt($input);

        $this->assertEquals($input, $crypt->decrypt($encrypted));
    }

    /**
     * Data provider
     *
     * @return array
     */
    public function dataProviderForEncryption()
    {
        $testArray = ['asdfasfd'=>1, 'thing'=>2];

        $testObject = new \stdClass();
        $testObject->testValue = 14;

        return [
            ['This IS asdf Some TEXT!', 'testSampPL3Key'],
            [$testArray, 'testARRYAY kEy'],
            [$testObject, 'another3 test']
        ];
    }
}