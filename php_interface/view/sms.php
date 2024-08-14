<? require_once($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use 
\Bitrix\Main\Loader;//,            \Bitrix\Main\Application,       \Bitrix\Main\Diag\Debug,
//\Bitrix\Main\IO\Directory,      \Bitrix\Main\IO\File,           \Bitrix\Main\Config\Configuration;

Loader::includeModule('main');

use \Service\SMSC; $smsc = new SMSC;

if(isset($_GET['info'])): ?>
<style type="text/css">.fb{font-weight: bold;}.f15{font-size: 15px;}.f20{font-size: 20px;}.center{text-align: center;}.brb{border-bottom: 2px solid black;}.brl{border-bottom: 2px dashed black;}.br{border:1px solid #eee; border-radius:10px;} .bg{background: rgb(34,193,195); background: linear-gradient(0deg, rgba(34,193,195,0.17130602240896353) 0%, rgba(253,187,45,0) 100%);}</style>
<table class="br" style="margin: 0 150px;">
<tr>
    <th class="br bg fb">param</th>
    <th class="br bg fb">value</th>
</tr>
<? foreach($smsc->infoSend() as $k => $v) : ?>
<tr><td class="brb center f15 bg fb"><?=$k;?></td><td class="brl f12"><?=str_replace(['. ','! ','? '], '. <br>'.PHP_EOL, $v);?></td></tr>
<? endforeach; ?>
</table>
<? exit; endif; 

pa([$smsc->result('send', [['phones'=>'79897004820,+79282294086;+7 903 401 1822', 'mes' => ['txt' => 'создал процедуру prefix(symbols, lenght) выдаёт результат {{prefix}}', 'let' => ['prefix' => prefix(10)]]]])],1);
pa($smsc->send(['phones'=>'79897004820,+79282294086;+7 903 401 1822', 'mes' => ['txt' => 'сообщение из класса SMSC {{name}} {{varDontLet}}{{varDontLet1}} {{varDontLet2}} ', 'let' => ['name' => 'тег замены']]]));
