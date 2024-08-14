<? namespace Service;
 
//require_once $_SERVER['DOCUMENT_ROOT'].'/composer/vendor/autoload.php';

class SMSC{
    public $smsc, $url = 'https://smsc.ru/sys/send.php';
    public function __construct(
        protected string $login = 'apanyukvm', 
        protected string $pass  = 'Qs9@8ScU'){
            $this->smsc         = $this->send;
    }
///*/ahilespelid Метод выводит информацию о доступных параметрах метода send///*/    
    public function infoSend():array{return (is_file($f = resource_path('smsc__rest_send__all_key_params.php')) && is_array($a = include $f)) ? $a : null;}
///*/ahilespelid Метод выбирает массив разрешённых ключей запроса к api методу send///*/    
    public function getSendParams():array{return (is_file($f = resource_path('smsc__rest_send__all_key_params.php')) && is_array($a = include $f)) ? array_combine(array_flip($a), array_map(fn($v)=>'',$a)) : null;}
///*/ahilespelid Метод формирует обьект EventResult Bitrix фабрика///*/
    public function eventResult(string $method, array $arguments){
        $ret = new \Bitrix\Main\ORM\EventResult;
        $ret->modifyFields($this->{$method}(...$arguments));
    return $ret;}
///*/ahilespelid Метод формирует формирует обьект Result Bitrix фабрика///*/
    public function result(string $method, array $arguments){
        $ret = new \Bitrix\Main\Result;
        $ret->setData($this->{$method}(...$arguments));
    return $ret;}
///*/ahilespelid Метод формирует запрос к smsc.ru методу send для обмена json запроса на отправку сообщения и получения json ответа///*/
    public function send(array $arParams = []){
        ///*/ahilespelid проверили обязательные параметры///*/
        if((empty($arParams['list'])) && (empty($arParams['phones']) || empty($arParams['mes']))){return false;}
        ///*/ahilespelid задали ссылку запроса///*/
        $this->url = 'https://smsc.ru/rest/send/';
        ///*/ahilespelid оставили только разрешённые параметры///*/
        $arParams = array_intersect_key($arParams, $getSendParams = $this->getSendParams())+$getSendParams;
        ///*/ahilespelid заполняем логин и пароль если не пришли параметры то из класса берём///*/
        $arParams['login'] = (empty($arParams['login'])) ? $this->login : $arParams['login'];
        $arParams['psw']   = (empty($arParams['psw']))   ? $this->pass  : $arParams['psw'];
        ///*/ahilespelid пробежались по массиву убрали пустоту можно допилить валидацию здесь///*/
        $i=0; foreach($arParams as $k => $v){$v = (is_string($v)) ? trim($v) : $v;
            ///*/ahilespelid валидация телефонов///*/
            if('id'     == $k){$arParams[$k] = (empty($v)) ? prefix(8).'-'.prefix(4).'-'.prefix(4).'-'.prefix(4).'-'.prefix(12) : $v;}
            if('phones' == $k){$phones = []; foreach(\mexlpode([',',';',],$v) as $kk => $t){if(!empty($t = is_phone($t))){$phones[] = $t;}} $arParams[$k] = implode(';', $phones);}
            if('mes'    == $k){if(is_array($v) && !empty($v['txt']) && is_string($v['txt']) && !empty($v['let']) && is_array($v['let'])){
                foreach($v['let'] as $blade => $let){$v['txt'] = str_replace('{{'.$blade.'}}', $let, $v['txt']);}
                ///*/ahilespelid вырезаем не найденые переменные шаблона и помещаем сообщение в массив параметров///*/
                $arParams[$k] = preg_replace("#(\{\{[^\{\{\}\}]+\}\})#", '', $v['txt']); 
            }else{unset($arParams[$k]);}}
            ///*/ahilespelid удалили пустые параметры///*/
            if(empty($arParams[$k])){unset($arParams[$k]);}
        $i++;}
        ///*/ahilespelid не отправлять под параметром только вывод на экрвн отладочной информации///*/
        if($_REQUEST['dev']){pa([$arParams, json_encode($arParams,1)]); exit;}
    ///*/ahilespelid возвращаем результат пост запроса///*/
    return $ret = json_decode(post($this->url, $arParams, ['Content-Type: application/json', 'Accept: application/json'],1),1);}
}