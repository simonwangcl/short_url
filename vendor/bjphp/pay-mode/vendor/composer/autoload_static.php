<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit002eff545f9e6d91e05c5399e4a1d578
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Bjphp\\PayMode\\' => 14,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Bjphp\\PayMode\\' => 
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
            $loader->prefixLengthsPsr4 = ComposerStaticInit002eff545f9e6d91e05c5399e4a1d578::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit002eff545f9e6d91e05c5399e4a1d578::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit002eff545f9e6d91e05c5399e4a1d578::$classMap;

        }, null, ClassLoader::class);
    }
}