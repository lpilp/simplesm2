<?php
require_once '../vendor/autoload.php';
use Lpilp\Splsm2\smecc\SPLSM2\SimpleSm2;
use Lpilp\Splsm2\smecc\SPLSM2\Sm2Asn1;

$s1  = 'MEYCIQCfZffBK0K1htvYs0W14aLVjwLDQ3Xt/ZbbnkheF3Ci8gIhAIGDQA+t8+OkVScDUBfQnbKzrhvfkmArog0QaEzvWL1q';

list($r,$s) = Sm2Asn1::asn1_2_rs($s1);
var_dump($r,$s);
$s2 = Sm2Asn1::rs_2_asn1($r,$s);
var_dump($s1 == $s2);


$publicKey = '04eb4b8bbe15e3ad94b85196adc2c6f694436b3c1336170fd1daac8b10d2b8824ada9687c138fb81590e0f66ab9678161732ac0d7866b169e76b74483285f2bc04';
$privateKey = '0bc1c1d2771b64ba1922d72f8a451cd09a82176f74d975d484ec62c862176b75';
$userId = '1234567812345678';
$document = "app_id=test221124213123300000012";
// $document .= "xxxxdxx";
$document = "我爱你ILOVEYOU!";
$ssm2 = new SimpleSm2($privateKey,$publicKey);
// 不随机变,就是固定的文本，固定的密钥，生成的固定的签名,
// 不设置的话缺省是true, 每次的签名都不一样，看对方的需求，有些银行要求每次都变
// $ssm2->set_rand_sign_flag(false); 
$ssm2->set_fix_foreignkey_flag(true);
// var_dump($publicKey);die();
list($c1,$c3,$c2) = $ssm2->encrypt_raw($publicKey, $document);

// var_dump($c1,$c3,$c2);die();
$val = $ssm2->decrypt_raw($privateKey, $c1,$c3,$c2);
var_dump($val);

$document = 'whatareyoudoing now';
$ed = $ssm2->encrypt($publicKey,$document);
// var_dump($ed);
$val = $ssm2->decrypt($privateKey,$ed);

var_dump($val);
// die();

$ssm2->set_rand_sign_flag(false);
$ssm2->set_rand_enc_flag(false);
list($r, $s) = $ssm2->sign_raw($document, $privateKey, $publicKey,$userId);
var_dump($r, $s);
list($r, $s) = $ssm2->sign_raw($document, $privateKey, null,$userId);
var_dump($r, $s);
$result = $ssm2->verifty_sign_raw($document,$publicKey,$r,$s,$userId);
var_dump($result);
