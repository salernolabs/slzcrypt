<?php
namespace SalernoLabs\Tests\Slzcrypt;

use SalernoLabs\Slzcrypt\Crypt;

/**
 * Tests for Crypt class
 *
 * @package SalernoLabs
 * @subpackage Slzcrypt
 * @author Eric
 */
class CryptTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test encryption
     * @param string $input The input to test
     * @param string $key The key to test
     * @dataProvider dataProviderForEncryption
     * @throws \Exception But don't worry this test shouldn't
     */
    public function testEncryption($input, $key)
    {
        $crypt = new Crypt($key);

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
        $testObject = new \stdClass();
        $testObject->testValue = 14;

        return [
            'Regular text test' => ['This IS asdf Some TEXT!', 'testSampPL3Key'],
            'Empty string test' => ['', 'testARRYAY kEy'],
            'Array test' => [['asdf1', 'asdf2'], 'sausages'],
            'Object test' => [(object)['test' => 1], 'testObject'],
            'Integer test' => [4, 'testInteger'],
        ];
    }

    /**
     * This should throw an exception
     * @throws \Exception
     */
    public function testNoOpenSSL()
    {
        $this->expectException(\Exception::class);
        $crypt = new Crypt('asdf', function($function) { return false; });
    }
}
