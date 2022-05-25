<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit44ce56ebb7ad1fba6c393e997d94f243
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PrestaShop\\Module\\ProductGallery\\' => 33,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PrestaShop\\Module\\ProductGallery\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'ProductGalleryClass' => __DIR__ . '/../..' . '/classes/ProductGalleryClass.php',
        'Productgallery' => __DIR__ . '/../..' . '/productgallery.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit44ce56ebb7ad1fba6c393e997d94f243::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit44ce56ebb7ad1fba6c393e997d94f243::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit44ce56ebb7ad1fba6c393e997d94f243::$classMap;

        }, null, ClassLoader::class);
    }
}
