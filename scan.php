<?php
$files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(__DIR__ . '/app'));
$out = '';
foreach ($files as $file) {
    if ($file->isFile()) {
        $out .= $file->getPathname() . "\n";
    }
}
file_put_contents(__DIR__ . '/app_files.txt', $out);
