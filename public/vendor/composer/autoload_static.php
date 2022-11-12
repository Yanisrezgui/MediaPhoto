<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitfea4388bd01423886a53a673b56398b6
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RKA\\' => 4,
        ),
        'P' => 
        array (
            'Psr\\Http\\Server\\' => 16,
            'Psr\\Http\\Message\\' => 17,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RKA\\' => 
        array (
            0 => __DIR__ . '/..' . '/akrabat/rka-slim-session-middleware/RKA',
        ),
        'Psr\\Http\\Server\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-server-handler/src',
            1 => __DIR__ . '/..' . '/psr/http-server-middleware/src',
        ),
        'Psr\\Http\\Message\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/http-message/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitfea4388bd01423886a53a673b56398b6::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitfea4388bd01423886a53a673b56398b6::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitfea4388bd01423886a53a673b56398b6::$classMap;

        }, null, ClassLoader::class);
    }
}
