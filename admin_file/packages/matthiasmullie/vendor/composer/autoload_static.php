<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit06ce79f19e1703e1155ac03b35b2d74b
{
    public static $files = array (
        '52e181473ddd523a649d74860143e341' => __DIR__ . '/..' . '/meenie/javascript-packer/class.JavaScriptPacker.php',
    );

    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WyriHaximus\\JsCompress\\' => 23,
            'WyriHaximus\\Compress\\' => 21,
        ),
        'M' => 
        array (
            'MatthiasMullie\\PathConverter\\' => 29,
            'MatthiasMullie\\Minify\\' => 22,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WyriHaximus\\JsCompress\\' => 
        array (
            0 => __DIR__ . '/..' . '/wyrihaximus/js-compress/src',
        ),
        'WyriHaximus\\Compress\\' => 
        array (
            0 => __DIR__ . '/..' . '/wyrihaximus/compress-contracts/src',
            1 => __DIR__ . '/..' . '/wyrihaximus/compress/src',
        ),
        'MatthiasMullie\\PathConverter\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/path-converter/src',
        ),
        'MatthiasMullie\\Minify\\' => 
        array (
            0 => __DIR__ . '/..' . '/matthiasmullie/minify/src',
        ),
    );

    public static $prefixesPsr0 = array (
        'J' => 
        array (
            'JShrink' => 
            array (
                0 => __DIR__ . '/..' . '/tedivm/jshrink/src',
            ),
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit06ce79f19e1703e1155ac03b35b2d74b::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit06ce79f19e1703e1155ac03b35b2d74b::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit06ce79f19e1703e1155ac03b35b2d74b::$prefixesPsr0;
            $loader->classMap = ComposerStaticInit06ce79f19e1703e1155ac03b35b2d74b::$classMap;

        }, null, ClassLoader::class);
    }
}
