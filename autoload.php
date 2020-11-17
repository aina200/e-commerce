<?php

$composerAutoload = __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
if (file_exists($composerAutoload)) {
    require $composerAutoload;
} else {
    spl_autoload_register(function (string $class): void {
        $subNamespaces = explode('\\', $class);

        $baseDir = (function () use ($subNamespaces): string {
            switch ($subNamespaces[0]) {
                case 'Framewa':
                    return 'lib';
                case 'App':
                    return 'src';
                default:
                    throw new \Exception('Invalid namespace "' . $subNamespaces[0] . '". Expecting "Framewa" or "App"');
            }
        })();

        array_shift($subNamespaces);
        $filepath = $baseDir
            . DIRECTORY_SEPARATOR
            . implode(DIRECTORY_SEPARATOR, $subNamespaces)
            . '.php';

        if (!file_exists($filepath)) {
            throw new \Exception("Could not find file $filepath for class $class. Check your file's path, class name or namespace.");
        }

        require $filepath;
    });
}
