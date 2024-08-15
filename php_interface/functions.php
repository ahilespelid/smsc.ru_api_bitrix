<?  
///*/ Функция дампа переменной авторская ///*/
if(!function_exists('pa')){
    function pa($a, $mes='', $br=0, $t='pre'):bool{
        $backtrace = debug_backtrace(); $fileinfo = ''; $sbr='';
        $fileinfo = (!empty($backtrace[0]) && is_array($backtrace[0])) ? $backtrace[0]['file'].':'.$backtrace[0]['line'] : '';
        
        while($br){$sbr.='<br>'; $br--;}
        
        echo '<div>'.$fileinfo.'</div>'.$sbr.'<div>'.$mes.'</div>'.'<'.$t.'>'; print_r($a = (!empty($a) ? $a : [])); echo '</'.$t.'>'.PHP_EOL;
return true;}}

///*/ Функция проверка строки на дату ///*/
if(!function_exists('is_date')){
function is_date($d){
    if(empty($d)){return null;}
    try{$date = new \DateTime($d);}catch(\Exception $e){return null;}
return $date;}}

///*/ Функция выбора уникальных ключей из массива ///*/
if(!function_exists('array_unique_key')){
function array_unique_key($array, $key){ 
    $ret = $key_array = []; $i = 0; 
    foreach($array as $val){if(!in_array($val[$key], $key_array)){$key_array[$i] = $val[$key];$ret[$i] = $val;} $i++;} 
return $ret;}}

///*/ Функция поиска места определения функции по имени функции ///*/
if(!function_exists('sf')){function sf($function_name, $print = 1){
    $backtrace = debug_backtrace(); $fileinfo = ''; $sbr='';
    $fileinfo = (!empty($backtrace[0]) && is_array($backtrace[0])) ? $backtrace[0]['file'].':'.$backtrace[0]['line'] : '';
    $ret = 'don`t search';
    
    if(in_array(strtolower($function_name), get_defined_functions()['user'])){
        $reflFunc = new ReflectionFunction("{$function_name}");
        $ret = (empty($reflFunc->getFileName())) ? $ret : $reflFunc->getFileName() . ':' . $reflFunc->getStartLine();
    }
    if($print){echo '<div>'.$fileinfo.'</div>'.'<div>'.$ret.'</div>';}else{return $ret;}
    
return null;}}

///*/ Функция рекурсивно чистит массив от ключей с первым символом ~ ///*/
if(!function_exists('BIclear')){function BIclear($ar){
    foreach($ar as $k => $v){
        if('~' === substr($k, 0, 1)){unset($ar[$k]);} else {$ar[$k] = (is_array($v)) ? BIclear($v) : $v;
    }}
return $ar;}}

///*/ ahilespelid Функция аналог  str_starts_with из php 8 ///*/
if(!function_exists('str_starts_with')){function str_starts_with(string $haystack, string $needle){
    if(empty($haystack) && empty($needle)){return false;}
return substr($haystack, 0, strlen($needle)) === $needle;}}

///*/ ahilespelid функция фильтрует массив по ключам начинающихся c $needle///*/
if(!function_exists('array_keys_starts_with')){function array_keys_starts_with(array $data, string $needle):?array{
    $ret = array_filter($data, function($v, $k) use($needle) {return strpos(strtolower($k), strtolower($needle)) === 0;}, ARRAY_FILTER_USE_BOTH);
return (empty($ret)) ? null : $ret;}}

///*/ahilespelid///*/
if(!function_exists('get_namespace')){function get_namespace($namespace = ''){
    $namespace.= '\\';
    $classes   = array_values(array_filter($dC = get_declared_classes(), fn($i) => strtolower(substr($i, 0, strlen($namespace))) === strtolower($namespace)));
return (empty($classes)) ? $dC : $classes;}}

///*/ahilespelid///*/
function translit(string $t){
    $converter = [
        'а' => 'a',    'б' => 'b',    'в' => 'v',    'г' => 'g',    'д' => 'd',
        'е' => 'e',    'ё' => 'e',    'ж' => 'zh',   'з' => 'z',    'и' => 'i',
        'й' => 'y',    'к' => 'k',    'л' => 'l',    'м' => 'm',    'н' => 'n',
        'о' => 'o',    'п' => 'p',    'р' => 'r',    'с' => 's',    'т' => 't',
        'у' => 'u',    'ф' => 'f',    'х' => 'h',    'ц' => 'c',    'ч' => 'ch',
        'ш' => 'sh',   'щ' => 'sch',  'ь' => '',     'ы' => 'y',    'ъ' => '',
        'э' => 'e',    'ю' => 'yu',   'я' => 'ya',
 
        'А' => 'A',    'Б' => 'B',    'В' => 'V',    'Г' => 'G',    'Д' => 'D',
        'Е' => 'E',    'Ё' => 'E',    'Ж' => 'Zh',   'З' => 'Z',    'И' => 'I',
        'Й' => 'Y',    'К' => 'K',    'Л' => 'L',    'М' => 'M',    'Н' => 'N',
        'О' => 'O',    'П' => 'P',    'Р' => 'R',    'С' => 'S',    'Т' => 'T',
        'У' => 'U',    'Ф' => 'F',    'Х' => 'H',    'Ц' => 'C',    'Ч' => 'Ch',
        'Ш' => 'Sh',   'Щ' => 'Sch',  'Ь' => '',     'Ы' => 'Y',    'Ъ' => '',
        'Э' => 'E',    'Ю' => 'Yu',   'Я' => 'Ya',
    ];
return strtr($t, $converter);}

///*/ ahilespelid Метод эмитации post запроса из php///*/
if(!function_exists('post')){function post(string $url, array $data, array $headers = [], bool $data_json_encode = false){
    $data = ($data_json_encode) ? json_encode($data) : http_build_query($data);
    curl_setopt_array($curl = curl_init(), $q = [CURLOPT_HTTPHEADER => $headers, CURLOPT_RETURNTRANSFER => 1, CURLOPT_VERBOSE => 1, CURLOPT_POSTFIELDS => $data, CURLOPT_URL => $url, CURLOPT_POST => 1]);
    if($_REQUEST['dev']){
        pa([$data,
        //get_class_methods($obj)
        ]);
    }
return curl_exec($curl);}}

///*/ ahilespelid Метод возвращает путь до папки local///*/ 
if(!function_exists('local_path')){function local_path(string $file=''){
    $ret = dirname(__DIR__);
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ ahilespelid Метод возвращает путь до папки php_interface///*/ 
if(!function_exists('interface_path')){function interface_path(string $file=''){
    $ret = __DIR__;
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ ahilespelid Метод возвращает путь до папки resource_path///*/ 
if(!function_exists('resource_path')){function resource_path(string $file=''){
    $ret = interface_path('resource');
    $ret = (empty($file)) ? $ret : ((file_exists($f = $ret.DIRECTORY_SEPARATOR.$file)) ? $f : null);
return $ret;}}

///*/ahilespelid Проверка на мобильный телефон///*/
if(!function_exists('is_phone')){function is_phone(string $s, int $minDigits = 10, int $maxDigits = 14){
    $s = str_replace(['+', '(', ')', '-', ' '], '', $s);
return (preg_match('/^7[0-9]{'.$minDigits.','.$maxDigits.'}\z/', $s)) ? $s : null;}}

///*/ahilespelid Функция разбивает строку по разделителям переданным в массиве///*/
if(!function_exists('mexlpode')){function mexlpode(array $delimiters, string $string){
    $chr = '::::::::::::::::::::::::::::::::::::::::::::::::';
return explode($chr, str_replace($delimiters, $chr, $string));}}

///*/ahilespelid Функция разбивает строку по разделителям переданным в массиве///*/
if(!function_exists('prefix')){function prefix(int $length = 5, bool $upcase = true, array $simbols = []){
    $simbols = (empty($simbols)) ? ($upcase ? array_merge(range(48, 57),range(65, 90)) : array_merge(range(48, 57),range(65, 90),range(97, 122))): $simbols;
    $length  = (empty($simbols)) ? $c : (($length > $c = count($simbols)) ? $c : $length);
    $ret = ''; for($i=0;$i<$length;$i++){$ret.= chr($simbols[array_rand($simbols)]);}
return $ret;}}

///*/ahilespelid Функция возвращает guid///*/
if(!function_exists('com_create_guid')){function com_create_guid(){
    $data = openssl_random_pseudo_bytes(16);
    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));}}

///*/ahilespelid Функция возвращает GUID///*/
if(!function_exists('GUID')){function GUID(){return strtoupper(com_create_guid());}}

///*/ahilespelid///*/