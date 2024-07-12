<?php
namespace SmEccTest;

use Lpilp\Splsm2\smecc\SPLSM2\Sm4;
use SimpleTest\TestCase;

class Sm4TestHelper extends Sm4
{
    public function increaseCounter($v)
    {
        return parent::increaseCounter($v);
    }
}

class TestSm4 extends TestCase
{
    public function testSm4()
    {
        // official test vector
        $userKey =     '0123456789abcdeffedcba9876543210';
        $plainText =   '0123456789abcdeffedcba9876543210';
        $cipherText1 = '681edf34d206965e86b3e94f536e4246';

        $sm4 = new Sm4(hex2bin($userKey));

        $encrypted = $sm4->enDataEcb(hex2bin($plainText));
        self::assertSame($cipherText1, bin2hex($encrypted));

        $decrypted = $sm4->deDataEcb($encrypted);
        self::assertSame($plainText, bin2hex($decrypted));

        // PHP code is too slow to run that many iterations (this is also the official test vector)
        // profile (10000): testSm4 93.2% => Sm4->enDataEcb 91.1% => Sm4->encode 78.9% => Sm4->f 64.6% -> Sm4->t 24.8%
        if (false) {
            $cipherText2 = '595298c7c6fd271f0402f804c33d3f66';
            $buf = hex2bin($plainText);
            for ($i = 0; $i < 1000000; $i++) {
                $buf = $sm4->enDataEcb($buf);
            }
            self::assertSame($cipherText2, bin2hex($buf));
        }
    }

    public function testIncreaseCounter()
    {
        $sm4 = new Sm4TestHelper("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00");

        $out = $sm4->increaseCounter("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00");
        self::assertSame("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x01", $out);

        $out = $sm4->increaseCounter("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xff");
        self::assertSame("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x01\x00", $out);

        $out = $sm4->increaseCounter("\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff\xff");
        self::assertSame("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00", $out);

        $out = $sm4->increaseCounter("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\xff\xff\xff\xff\xff");
        self::assertSame("\x00\x00\x00\x00\x00\x00\x00\x00\x00\x00\x01\x00\x00\x00\x00\x00", $out);
    }
}
