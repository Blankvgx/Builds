<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitff03fe99b1bb5687cd1ba26b0aa5ddad
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PhpAmqpLib\\' => 11,
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PhpAmqpLib\\' => 
        array (
            0 => __DIR__ . '/..' . '/videlalvaro/php-amqplib/PhpAmqpLib',
        ),
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitff03fe99b1bb5687cd1ba26b0aa5ddad::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitff03fe99b1bb5687cd1ba26b0aa5ddad::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitff03fe99b1bb5687cd1ba26b0aa5ddad::$classMap;

        }, null, ClassLoader::class);
    }
}