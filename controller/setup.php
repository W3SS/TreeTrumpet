<?php
http://localhost/stuporglue/TreeTrumpet/treetrumpet/xmlsitemap.xml
// Include dirs

// Our models
spl_autoload_register(function ($class) {
    $file = __DIR__ . "/../model/$class.php";
    if(file_exists($file)){
        require_once($file);
    }
});



// php-gedcom
spl_autoload_register(function ($class) {
    $pathToPhpGedcom = __DIR__ . '/../lib/3rdparty/php-gedcom/library/'; 

    if (!substr(ltrim($class, '\\'), 0, 7) == 'PhpGedcom\\') {
        return;
    }

    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
    if (file_exists($pathToPhpGedcom . $class)) {
        require_once($pathToPhpGedcom . $class);
    }
});

// ged2json/ged2geojson
spl_autoload_register(function ($class) {
    $file = __DIR__ . "/../lib/3rdparty/$class.php";
    if(file_exists($file)){
        require_once($file);
    }
});



controller('config');

if(!file_exists(__DIR__ . '/../family.ged')){
    controller('firstrun');
    exit();
}
