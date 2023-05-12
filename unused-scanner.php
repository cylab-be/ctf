<?php
$projectPath = __DIR__ ;

//Declare directories which contains php code
$scanDirectories = [
    $projectPath . '/src/',
];

//Optionally declare standalone files
$scanFiles = [];

$packages = [
    'yoeunes/toastr',
    'doctrine/dbal',
    'laravel/framework',
    'fideloper/proxy',
    'tecnickcom/tcpdf',
    'laravel/tinker',
    'erusev/parsedown'
];

return [
    'composerJsonPath' => $projectPath . '/composer.json',
    'vendorPath' => $projectPath . '/vendor/',
    'scanDirectories' => $scanDirectories,
    'scanFiles'=>$scanFiles,
    'skipPackages' => $packages
];
