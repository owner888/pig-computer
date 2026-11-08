<?php

declare(strict_types=1);

use Pig\CodingAgent\Extensions\ExtensionApi;
use PigComputer\Extension;

/*
 * pig-computer — see and operate the macOS desktop: screenshots, clicks, drags, scrolling,
 * typing, keys and apps, plus the `/computer` command and a live screen page for the web UI.
 *
 * The file is named after the extension because pig names an extension by its file: settings
 * that say `"disabledExtensions": ["pig-computer"]` from the days it was bundled with pig still
 * reach it.
 *
 * A package installed from git is not run through Composer, so nothing autoloads its classes;
 * this registers the loader for the package's own namespace, once.
 */
spl_autoload_register(static function (string $class): void {
    if (str_starts_with($class, 'PigComputer\\')) {
        $file = dirname(__DIR__) . '/src/' . str_replace('\\', '/', substr($class, 12)) . '.php';

        if (is_file($file)) {
            require_once $file;
        }
    }
});

return static function (ExtensionApi $pig): void {
    Extension::register($pig);
};
