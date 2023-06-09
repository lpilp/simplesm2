<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit0d80242f367466fd6ee81490e0abe421
{
    public static $prefixLengthsPsr4 = array (
        'L' => 
        array (
            'Lpilp\\Splsm2\\' => 13,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Lpilp\\Splsm2\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit0d80242f367466fd6ee81490e0abe421::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit0d80242f367466fd6ee81490e0abe421::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit0d80242f367466fd6ee81490e0abe421::$classMap;

        }, null, ClassLoader::class);
    }
}
