<?php
use Composer\Autoload\ClassLoader;

require __DIR__ . '/../vendor/autoload.php';

$testClassLoader = new ClassLoader();
$testClassLoader->addPsr4('SimpleTest\\', __DIR__ . '/src/SimpleTest');
$testClassLoader->addPsr4('SmEccTest\\', __DIR__ . '/src/SmEccTest');
$testClassLoader->register();

$allSucceeded = (new SimpleTest\TestRunner())->run('SmEccTest', __DIR__ . '/src/SmEccTest');
exit($allSucceeded ? 0 : 1);
