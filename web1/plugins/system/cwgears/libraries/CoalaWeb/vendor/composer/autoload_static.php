<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit784b975369fd0b7ab45e916492886a39
{
    public static $prefixLengthsPsr4 = array (
        's' => 
        array (
            'splitbrain\\PHPArchive\\' => 22,
        ),
        'C' => 
        array (
            'CoalaWeb\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'splitbrain\\PHPArchive\\' => 
        array (
            0 => __DIR__ . '/..' . '/splitbrain/php-archive/src',
        ),
        'CoalaWeb\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'CoalaWeb\\Cache' => __DIR__ . '/../..' . '/src/Cache.php',
        'CoalaWeb\\Config' => __DIR__ . '/../..' . '/src/Config.php',
        'CoalaWeb\\Messages' => __DIR__ . '/../..' . '/src/Messages.php',
        'CoalaWeb\\Parameters' => __DIR__ . '/../..' . '/src/Parameters.php',
        'CoalaWeb\\RegEx' => __DIR__ . '/../..' . '/src/RegEx.php',
        'CoalaWeb\\StringHelper' => __DIR__ . '/../..' . '/src/StringHelper.php',
        'CoalaWeb\\UpdateKey' => __DIR__ . '/../..' . '/src/UpdateKey.php',
        'CoalaWeb\\Xml' => __DIR__ . '/../..' . '/src/Xml.php',
        'splitbrain\\PHPArchive\\Archive' => __DIR__ . '/..' . '/splitbrain/php-archive/src/Archive.php',
        'splitbrain\\PHPArchive\\ArchiveCorruptedException' => __DIR__ . '/..' . '/splitbrain/php-archive/src/ArchiveCorruptedException.php',
        'splitbrain\\PHPArchive\\ArchiveIOException' => __DIR__ . '/..' . '/splitbrain/php-archive/src/ArchiveIOException.php',
        'splitbrain\\PHPArchive\\ArchiveIllegalCompressionException' => __DIR__ . '/..' . '/splitbrain/php-archive/src/ArchiveIllegalCompressionException.php',
        'splitbrain\\PHPArchive\\FileInfo' => __DIR__ . '/..' . '/splitbrain/php-archive/src/FileInfo.php',
        'splitbrain\\PHPArchive\\FileInfoException' => __DIR__ . '/..' . '/splitbrain/php-archive/src/FileInfoException.php',
        'splitbrain\\PHPArchive\\Tar' => __DIR__ . '/..' . '/splitbrain/php-archive/src/Tar.php',
        'splitbrain\\PHPArchive\\Zip' => __DIR__ . '/..' . '/splitbrain/php-archive/src/Zip.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit784b975369fd0b7ab45e916492886a39::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit784b975369fd0b7ab45e916492886a39::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit784b975369fd0b7ab45e916492886a39::$classMap;

        }, null, ClassLoader::class);
    }
}
