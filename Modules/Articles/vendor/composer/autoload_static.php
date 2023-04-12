<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit05c31d5f89eb42977983d35d42c863c8
{
    /**
     * @var int[][]
     *
     * @psalm-var array{M: array{'Modules\\Articles\\': 18}}
     */
    public static array $prefixLengthsPsr4 = array (
        'M' => 
        array (
            'Modules\\Articles\\' => 18,
        ),
    );

    /**
     * @var string[][]
     *
     * @psalm-var array{'Modules\\Articles\\': array{0: string}}
     */
    public static array $prefixDirsPsr4 = array (
        'Modules\\Articles\\' => 
        array (
            0 => __DIR__ . '/../..' . '/',
        ),
    );

    /**
     * @var string[]
     *
     * @psalm-var array{'Composer\\InstalledVersions': string}
     */
    public static array $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader): \Closure|false
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit05c31d5f89eb42977983d35d42c863c8::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit05c31d5f89eb42977983d35d42c863c8::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit05c31d5f89eb42977983d35d42c863c8::$classMap;

        }, null, ClassLoader::class);
    }
}