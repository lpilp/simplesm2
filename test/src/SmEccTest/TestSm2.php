<?php
namespace SmEccTest;

use Lpilp\Splsm2\smecc\SPLSM2\SimpleSm2;
use Lpilp\Splsm2\smecc\SPLSM2\Sm2Asn1;
use SimpleTest\TestCase;

class TestSm2 extends TestCase
{
    public function testSm2Asn1()
    {
        $s1 = 'MEYCIQCfZffBK0K1htvYs0W14aLVjwLDQ3Xt/ZbbnkheF3Ci8gIhAIGDQA+t8+OkVScDUBfQnbKzrhvfkmArog0QaEzvWL1q';

        list($r, $s) = Sm2Asn1::asn1_2_rs($s1);
        self::assertSame('9f65f7c12b42b586dbd8b345b5e1a2d58f02c34375edfd96db9e485e1770a2f2', $r);
        self::assertSame('8183400fadf3e3a45527035017d09db2b3ae1bdf92602ba20d10684cef58bd6a', $s);

        $s2 = Sm2Asn1::rs_2_asn1($r, $s);
        self::assertSame($s1, $s2);
    }

    public function testSm2Encrypt()
    {
        $publicKey = '04eb4b8bbe15e3ad94b85196adc2c6f694436b3c1336170fd1daac8b10d2b8824ada9687c138fb81590e0f66ab9678161732ac0d7866b169e76b74483285f2bc04';
        $privateKey = '0bc1c1d2771b64ba1922d72f8a451cd09a82176f74d975d484ec62c862176b75';

        $ssm2 = new SimpleSm2();

        $document = "UTF8 emoji 👀";
        $ssm2->set_fix_foreignkey_flag(true);
        list($c1, $c3, $c2) = $ssm2->encrypt_raw($publicKey, $document);
        $val = $ssm2->decrypt_raw($privateKey, $c1, $c3, $c2);
        self::assertSame($document, $val);

        $document = 'test content';
        $ed = $ssm2->encrypt($publicKey, $document);
        $val = $ssm2->decrypt($privateKey, $ed);
        self::assertSame($document, $val);
    }

    function testSm2Sign()
    {
        $publicKey = '04eb4b8bbe15e3ad94b85196adc2c6f694436b3c1336170fd1daac8b10d2b8824ada9687c138fb81590e0f66ab9678161732ac0d7866b169e76b74483285f2bc04';
        $privateKey = '0bc1c1d2771b64ba1922d72f8a451cd09a82176f74d975d484ec62c862176b75';
        $userId = '1234567812345678';
        $ssm2 = new SimpleSm2();
        $ssm2->set_rand_sign_flag(false);
        $ssm2->set_rand_enc_flag(false);

        $document = 'test content';
        list($r1, $s1) = $ssm2->sign_raw($document, $privateKey, $publicKey, $userId);
        list($r2, $s2) = $ssm2->sign_raw($document, $privateKey, null, $userId);
        self::assertSame($r1, $r2);
        self::assertSame($s1, $s2);
        $result = $ssm2->verifty_sign_raw($document, $publicKey, $r1, $s1, $userId);
        self::assertSame(true, $result);
    }
}
