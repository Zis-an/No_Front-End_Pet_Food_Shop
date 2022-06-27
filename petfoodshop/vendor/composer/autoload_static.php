<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd95c527602e5caed2b3c38c116dd5fc5
{
    public static $prefixLengthsPsr4 = array (
        'B' => 
        array (
            'Braintree\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Braintree\\' => 
        array (
            0 => __DIR__ . '/..' . '/braintree/braintree_php/lib/Braintree',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd95c527602e5caed2b3c38c116dd5fc5::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd95c527602e5caed2b3c38c116dd5fc5::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd95c527602e5caed2b3c38c116dd5fc5::$classMap;

        }, null, ClassLoader::class);
    }
}
