<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit51415035c781d2c9b9f85aea1dd8ead9
{
    public static $prefixLengthsPsr4 = array (
        'W' => 
        array (
            'WPGraphQL\\Extensions\\ACF\\' => 25,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'WPGraphQL\\Extensions\\ACF\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'WPGraphQL\\Extensions\\ACF\\Actions' => __DIR__ . '/../..' . '/src/Actions.php',
        'WPGraphQL\\Extensions\\ACF\\Filters' => __DIR__ . '/../..' . '/src/Filters.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\FieldGroup\\FieldGroupType' => __DIR__ . '/../..' . '/src/Type/FieldGroup/FieldGroupType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\Field\\FieldType' => __DIR__ . '/../..' . '/src/Type/Field/FieldType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\File\\FileType' => __DIR__ . '/../..' . '/src/Type/File/FileType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\Image\\ImageSizeType' => __DIR__ . '/../..' . '/src/Type/Image/ImageSizeType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\Image\\ImageType' => __DIR__ . '/../..' . '/src/Type/Image/ImageType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\Link\\LinkType' => __DIR__ . '/../..' . '/src/Type/Link/LinkType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\Map\\MapType' => __DIR__ . '/../..' . '/src/Type/Map/MapType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\Union\\FieldUnionType' => __DIR__ . '/../..' . '/src/Type/Union/FieldUnionType.php',
        'WPGraphQL\\Extensions\\ACF\\Type\\User\\UserType' => __DIR__ . '/../..' . '/src/Type/User/UserType.php',
        'WPGraphQL\\Extensions\\ACF\\Types' => __DIR__ . '/../..' . '/src/Types.php',
        'WPGraphQL\\Extensions\\ACF\\Utils' => __DIR__ . '/../..' . '/src/Utils.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit51415035c781d2c9b9f85aea1dd8ead9::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit51415035c781d2c9b9f85aea1dd8ead9::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit51415035c781d2c9b9f85aea1dd8ead9::$classMap;

        }, null, ClassLoader::class);
    }
}
