<?php
require_once '../vendor/autoload.php';
use Lpilp\Splsm2\smecc\SPLSM2\SimpleSm2;
use Lpilp\Splsm2\smecc\SPLSM2\Sm2Asn1;

use const Lpilp\Splsm2\smecc\SPLSM2\C1C2C3;

$publicKey = '04eb4b8bbe15e3ad94b85196adc2c6f694436b3c1336170fd1daac8b10d2b8824ada9687c138fb81590e0f66ab9678161732ac0d7866b169e76b74483285f2bc04';
$privateKey = '0bc1c1d2771b64ba1922d72f8a451cd09a82176f74d975d484ec62c862176b75';
$ssm2 = new SimpleSm2($privateKey,$publicKey);
$ssm2->set_fix_foreignkey_flag(true);
$userId = '1234567812345678';
$data = 'hello,';
$data = str_repeat($data, 2);
$val = $ssm2->encrypt($publicKey, $data, C1C2C3);
var_dump($val);
$val = $ssm2->decrypt($privateKey,$val,C1C2C3,true);


var_dump($val);