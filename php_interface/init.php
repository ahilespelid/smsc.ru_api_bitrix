<? include_once 'functions.php';

///*/ Расшариваю локальные сервисы для ядра битрикса /local/php_interface/service ///*/
spl_autoload_register(function($class){
    $exp = explode('\\', $class); $namespace = strtolower($exp[0]); $class = $exp[1];  
    if('service' == $namespace && in_array(count($exp), [2,3])){
        if('Traits' == $class){$namespace = 'trait'; $class = $exp[2];}
        include_once($p = __DIR__.DIRECTORY_SEPARATOR.$namespace.DIRECTORY_SEPARATOR.$class.'.php'); 
}});

