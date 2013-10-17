<?php
spl_autoload_register(function($class) {
    $fileName = stream_resolve_include_path(
        str_replace('\\', '/', $class) . '.php'
    );



    if ($fileName) {
        require($fileName);
    } else {
        $f = 'Factory';
        $len = strlen($f);
        if (!substr_compare($class, $f, -$len, $len)) {
        $classParts = explode('\\',substr($class, 0, -$len));
        $className = array_pop($classParts);
        $namespace = implode('\\', $classParts);
            $body = <<<CLASSBODY
namespace {$namespace};
use Smil\ObjectManager;

class {$className}Factory
{
    const CLASS_NAME = '{$namespace}\\{$className}';
    use ObjectManager\Factory;
}
CLASSBODY;
echo $body;
eval($body);
        }
    }
    return $fileName
        && (
            class_exists($class, false)
            || interface_exists($class, false)
            || trait_exists($class, false)
        );
});

use \Smil\ObjectManager as ObjectManager;

$om = new ObjectManager();
echo $om->get('HttpFrontController')->__invoke($_SERVER);





