<?php

$targetFolder = '/laravel/public';
$indexFiles = ['index.html', 'index.php'];
$routes = [
    '^/api(/.*)?$' => '/index.php'
];

$url = explode('?', $_SERVER['REQUEST_URI'], 2);
$requestedAbsoluteFile = dirname(__FILE__) . $targetFolder . $url[0];

// // check if the the request matches one of the defined routes
// foreach ($routes as $regex => $fn) {
//   if (preg_match('%' . $regex . '%', $_SERVER['REQUEST_URI'])) {
//     $requestedAbsoluteFile = dirname(__FILE__) . $fn;
//     break;
//   }
// }

// if request is a directory call check if index files exist
if (is_dir($requestedAbsoluteFile)) {
    foreach ($indexFiles as $filename) {
        $fn = $requestedAbsoluteFile . '/' . $filename;
        if (is_file($fn)) {
            $requestedAbsoluteFile = $fn;
            break;
        }
    }
}

// if requested file is'nt a php file
if (
    is_file($requestedAbsoluteFile) &&
    !preg_match('/\.php$/', $requestedAbsoluteFile)
) {
    header('Access-Control-Allow-Origin: *');

    $ext = pathinfo($requestedAbsoluteFile, PATHINFO_EXTENSION);
    if ($ext == 'css') {
        header('Content-Type: ' . 'text/css');
    } else {
        header('Content-Type: ' . mime_content_type($requestedAbsoluteFile));
    }
    $fh = fopen($requestedAbsoluteFile, 'r');
    fpassthru($fh);
    fclose($fh);
    return true;
}

// if requested file is php, include it
include_once 'laravel/public/index.php';
