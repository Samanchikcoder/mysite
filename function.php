<?php
session_name('SID') . session_start();
// Подключение к БД
include_once($_SERVER["DOCUMENT_ROOT"]."/inc/dbconfig.php");

try {
$connect = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME.';charset=utf8', DB_USER, DB_PASS);
} catch (PDOException $e) {
die('<header>
         <table>
            <tr>
               <td class="l_bar">
<a href="/"><img src="/inc/style/img/home.png" width="23"  alt="home"></a>
               </td>
               <td class="c_bar">
                  <h1 style="color: white;">domen.ru</h1>
               </td>
               <td class="r_bar">
<a href="/auth" title="Вход"><img width="23" src="/img/auth1.png" alt="Вход"></a>
</td>
<td class="r_bar">
<a href="/reg" title="Регистрация"><img width="23" src="/img/reg1.png" alt="Регистрация"></a>
               </td>
            </tr>
         </table>
      </header><div class="mOm"><div class="block first"><div class="title">Технические работы!</div><div class="menu">На сайте ведутся технические работы!</div>
      </div><footer>
<span>&copy; domen.ru - 2018-'.date('Y').'</span>
         <span>
         </span>
      </footer>
    </div>
   </body>
</html>');
}
// Настройки сайта

include_once($_SERVER["DOCUMENT_ROOT"]."/inc/filters.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/inc/tools.php");
// Кодировка
mb_internal_encoding('UTF-8');
define('FILE_CONFIG', __DIR__."/conf/conf.ini");
$amx = parse_ini_file(FILE_CONFIG, true);
// Ручной фильтр
function filter2($str) {
    $str = trim(stripslashes(htmlspecialchars($str, ENT_QUOTES)));
    return $str;
}
// GET
function api_query($url) {
    $qas=array("ssl"=>array("verify_peer"=>false,"verify_peer_name"=>false,),);
    $sf = file_get_contents($url, false, stream_context_create($qas));
    return $sf;
}
// Ручной фильтр
function filteroff($str) {
    $str = trim(stripslashes(htmlspecialchars_decode($str, ENT_QUOTES)));
    return $str;
}
// rmfile
function rmfile($file) {
if (unlink($_SERVER["DOCUMENT_ROOT"].''.$file)) 
   { $ff='1'; } else 
   { $ff='0'; }
    return $ff;
}
// Proverka IP
function ip_check($network, $ip) { 
     $ip_arr = explode('/', $network); 
     $network_long = ip2long($ip_arr[0]); 
     $x = ip2long($ip_arr[1]); 
     $mask =  long2ip($x) == $ip_arr[1] ? $x : 0xffffffff << (24 - $ip_arr[1]); 
     $ip_long = ip2long($ip); 
     return ($ip_long & $mask) == ($network_long & $mask); 
} 
///
function getb($url) {
    if (filter_var($url, FILTER_VALIDATE_URL)) {
        $init = curl_init($url);
        curl_setopt($init, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($init, CURLOPT_HEADER, true);
        curl_setopt($init, CURLOPT_NOBODY, true);
        curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($init);
        curl_close($init);
    }
    return $response;
}
// Узнаем id по логину
function uid($login) {

    global $connect;

    $strow = $connect->prepare("select * from `users` where `login` = ?");
    $strow->execute(array($login));
    $row = $strow->fetch(PDO::FETCH_LAZY);

    return $row['id'] ?? 0;

}
// tg mysql
function tgmsg($tg_id, $tg_msg, $files) {
    global $connect;
$tgmsg = $connect->prepare("insert into `tgmsg` set `tg_id` = ?, `tg_msg` = ?, `tg_files` = ?, `act` = ?");
$tgmsg->execute(array($tg_id, $tg_msg, $files, 1));
}
// tg
function tg($chatid, $msg) {
    $botTokenb = "652521725:AAF_oZIzXH3ZJCnkza6HsspJC-MajPM7EFY";
    $websitea = "https://api.telegram.org/bot".$botTokenb;
    file_get_contents($websitea."/sendmessage?chat_id=".$chatid."&text=".urlencode($msg));
}
function tgpo($chatid, $url_photo, $msg) {
    $botTokenb = "652521725:AAF_oZIzXH3ZJCnkza6HsspJC-MajPM7EFY";
    $websitea = "https://api.telegram.org/bot".$botTokenb;
    file_get_contents($websitea."/sendPhoto?chat_id=".$chatid."&photo=".urlencode($url_photo)."&caption=".urlencode($msg));
}
// Узнаем логин по id
function ulogin($uid) {

    global $connect;

    $strow = $connect->prepare("select * from `users` where `id` = ?");
    $strow->execute(array($uid));
    $row = $strow->fetch(PDO::FETCH_LAZY);

    return $row['login'] ?? false;

}
// Pul o'tkazishda % olish
function p($as, $f) {
    $x1= ($as / 100) * $f;
    $s = $as - $x1;
    return $s;
}
// Инфо о юзере
function user($user, $type = 0) {
    global $connect;
    if ($type == 1)
        $sql = "select * from `users` where `login` = ?";
    else
        $sql = "select * from `users` where `id` = ?";
    $result = $connect->prepare($sql);
    $result->execute(array($user));
    $row = $result->fetch(PDO::FETCH_LAZY);
    return $row ?? [];
}

// Определение реального браузера
$ua = $_SERVER['HTTP_USER_AGENT'];
$ip = $_SERVER['REMOTE_ADDR'];
//$ip = $_SERVER['HTTP_X_REAL_IP'];
// Определение бота по UA
if (stristr($ua, 'bot')) $bot = true;

// Корневая папка
define('ROOT', 'https://'.$_SERVER['HTTP_HOST']);


// Функция фильтровки чисел
function val($str, $abs = null) {
if ($abs == null) {
return intval($str);
} else {
return abs(intval($str));
}
}
// Функция ББ кодов
function bb($str) {
// Жирный шрифт
$str = preg_replace('#\[b\](.*?)\[/b\]#si', '<b>\1</b>', $str);
// Наклоненный шрифт
$str = preg_replace('#\[i\](.*?)\[/i\]#si', '<i>\1</i>', $str);
// Подчеркнутый шрифт
$str = preg_replace('#\[u\](.*?)\[/u\]#si', '<u>\1</u>', $str);
// Перенос текста
$str = preg_replace('#\[br\]#si', '<br/>', $str);
// Зачеркнутый шрифт
$str = preg_replace('#\[del\](.*?)\[/del\]#si', '<del>\1</del>', $str);
// Маленький шрифт
$str = preg_replace('#\[small\](.*?)\[/small\]#si', '<small>\1</small>', $str);
// Цветной шрифт
$str = preg_replace('#\[color=(.*?)\](.*?)\[/color\]#si', '<span style="color:\1">\2</span>', $str);
// Цитата
$str = preg_replace('#\[cit\](.*?)\[/cit\]#si', '<div class="st_2">\1</div>', $str);
return $str;
}
// Ссылки
function url_replace($m) {
if (!isset($m[3])) {
return '<a href="'.$m[1]. '" target="_blank">'.$m[2].'</a>';
} else {
return '<a href="'.$m[3].'" target="_blank">'.$m[3].'</a>';
}
}
function bblinks($link) {
$link = preg_replace_callback('~\\[url=(http://.+?)\\](.+?)\\[/url\\]|(http://(www.)?[0-9a-z\.\-]+\.[0-9a-z]{2,6}[0-9a-zA-Z/\?\.\-\~&;_=%:#\+]*)~', 'url_replace', $link);
return $link;
}
// Функция вывода смайлов
function smiles($str) {
global $user;
for($i = 1; $i <= count(glob($_SERVER["DOCUMENT_ROOT"]."/img/smiles/*.gif")); $i++) {
$str = str_replace(':'.$i.':', '<img src="/img/smiles/'.$i.'.gif" alt=""/>', $str);
$str = str_replace(':)', '<img src="/img/smiles/37.gif" alt=""/>', $str);
$str = str_replace(':(', '<img src="/img/smiles/36.gif" alt=""/>', $str);
} 
return $str;
}
// Дата и время
date_default_timezone_set('Asia/Tashkent');
// Обработка времени
function daytime($var) {
if ($var == NULL) $var = time();
$full_time = date('d.m.Y в H:i', $var);
$date = date('d.m.Y', $var);
$time = date('H:i', $var);
if ($date == date('d.m.Y')) $full_time = date('Сегодня в H:i', $var);
if ($date == date('d.m.Y', time()-60*60*24)) $full_time = date('Вчера в H:i', $var);
return $full_time;
}
// Функция отправки почты на email
function mailto($mail, $theme, $text, $str) {

    $adt = 'From: ' . $str . PHP_EOL;
    $adt .= 'X-sender: < ' . $str . ' >' . PHP_EOL;
    $adt .= 'Content-Type: text/html; charset=utf-8' . PHP_EOL;

    return mail($mail, $theme, $text, $adt);

}

// Функция генерации пароля
function gen_pass($col = 6) {
$row = 'abcdefghijklmnopqrstuvwxvzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
$str = '';
for($i= 0 ; $i < $col; $i++) {
$str.= $row[rand(0, 61)];
}
return $str;
}
// Функции извлечения настроек с базы
$systema = $connect->query("SELECT * FROM `settings`")->fetchAll();
$set = array();
foreach ($systema as $query) {
$set[$query[0]] = $query[1];
}
// Статус онлайн
function online($uid) {
    global $connect;
    $auth = is_array($uid) ? $uid : authlog($uid);
    $result = $connect->prepare("SELECT * FROM `users` WHERE `id` = ?");
    $result->execute(array($uid));
    $row = $result->fetch(PDO::FETCH_LAZY);
    if($row['admin'] == '0'){ $dol  = ''; }
    elseif($row['admin'] == '1'){ $dol = '<font color="gren"> [Тех.Подд (UZ)]</font>'; }
	elseif($row['admin'] == '2'){ $dol = '<font color="gren"> [Тех.Поддежка (RU)]</font>'; }
	elseif($row['admin'] == '3'){ $dol = '<font color="red"> [Соз]</font>'; }
	elseif($row['admin'] == '4'){ $dol = '<font color="red"> [Соз]</font>'; }
	elseif($row['admin'] == '5'){ $dol = '<font color="red"> [Соз]</font>'; }
    if ($auth && $auth['status'] == 1 && $auth['lasttime'] > time() - 300) {

        //$online = deviceIcon($auth['ua']);
        $online = '<img src="/img/on.png" width="13px">  '.$dol.' ';
        return $online;

    } else{
        $online = '<img src="/img/off.png" width="13px">  '.$dol.' ';
        return $online;
}
}
function authlog($uid) {

    global $connect;

    $result = $connect->prepare("select * from `authlog` where `uid` = ? order by `lasttime` desc");
    $result->execute(array($uid));
    $info = $result->fetch(PDO::FETCH_LAZY);

    return $info;

}
// Авторизация
if (isset($_COOKIE['user_id']) && isset($_COOKIE['pass']) && isset($_COOKIE['auth'])) {
    // hash
    $authash = md5(md5($_COOKIE['auth']));
    // проверяем авторизацию
    $authcheck = $connect->prepare("select count(*) from `authlog` where `status` = ? and `uid` = ? and `key` = ?");
    $authcheck->execute(array(1, $_COOKIE['user_id'], $authash));
    // ищем юзера в базе
    $user = user($_COOKIE['user_id']);
    if ($user && $user['pass'] == $_COOKIE['pass'] && $authcheck->fetchColumn()) {
        // Юзер авторизован
        $active = 1;
        // Онлайн
        $authup = $connect->prepare("update `authlog` set `lasttime` = ? where `key` = ?");
        $authup->execute(array(time(), $authash));
        // Где юзер?
        //whereUser($user);
        // authlog
        $user_auth = authlog($user['id']);
    } else {
        // Удаляем на всякий случай :)
        unset($user);
        // сбрасываем куки
        setcookie('user_id', null, time() - 3600, '/');
        setcookie('pass', null, time() - 3600, '/');
        setcookie('auth', null, time() - 3600, '/');
    }
}
// Функции постраничной навигации
function page($k_page = 1) {
$page = 1;
if (isset($_GET['page'])) {
if ($_GET['page'] == 'end') {
$page = intval($k_page);
}
elseif(is_numeric($_GET['page'])) {
$page = intval($_GET['page']);
}
if ($page < 1) {
$page = 1;
}
if ($page > $k_page) {
$page = $k_page;
}
}
return $page;
}
function k_page($k_post = 0, $k_p_str = 10) {
if ($k_post != 0) {
$v_pages = ceil($k_post / $k_p_str);
return $v_pages;
} else {
return 1;
}
}
function navigation1($k_page = 1, $page = 1, $link = '?') {
if ($page < 1) {
$page = 1;
}
echo '<div class="menu">';
if ($page != 1) {
echo '<span class="page_ot"><a href="'.$link.'page=1">1 </a></span>';
} else {
echo '<span class="page">1 </span>';
}
for ($i =- 3; $i <= 3; $i++) {
if ($page + $i > 1 && $page + $i < $k_page) {
if ($i ==- 3 && $page + $i > 2) {
echo '<span class="page">...</span>';
}
if ($i != 0) {
echo '<span class="page_ot"><a href="'.$link.'page='.($page + $i).'"> '.($page + $i).' </a></span>';
} else {
echo '<span class="page"> '.($page + $i).' </span>';
}
if ($i == 3 && $page + $i < $k_page - 1) {
echo '<span class="page">...</span>';
}
}
}
if ($page != $k_page) {
echo '<span class="page_zh"><a href="'.$link.'page=end"> '.$k_page.' </a></span>';
}
elseif ($k_page > 1) {
echo '<span class="page"> '.$k_page.' </span>';
}
echo '</div>';
}



// Цены и способы оплаты
$id_shop = $set['wk_id']; // wk
$hash = $set['wk_hash']; //wk
$wpkid = $set['wpk_id']; // wpk
$wpkh = $set['wpk_hash']; //wpk
$whash = $set['hash']; // wm
$wmr3 = $set['wmr']; // wm
$su = $set['su']; // переход
$gold = $set['gold']; // gold
$color = $set['color']; // цвет

// Кол-во новостей
$count_news = $connect->query("select  count(`id`) from `news`")->fetchColumn();
// Кол-во сообщений чата
$ch = $connect->query("select count(`id`) from `guest`")->fetchColumn();

// Кол-во пользователей
$count_users = $connect->query("select count(`id`) from `users`")->fetchColumn();
// Кол-во зарегистрированных пользователей сегодня
$count_users_new = $connect->query("select count(`id`) from `users` where `datereg`>'".mktime(0, 0, 1, date('m'), date('d'), date('Y'))."'")->fetchColumn();
// Деньги у юзеров
$cbm = $connect->query("select sum(`money`) from `users` where `admin` != '5'")->fetchColumn();
// Кол-во пользователей онлайн
$count_online_user = $connect->query("select count(`id`) from `users` where `lasttime`>'".(time() - 900)."'")->fetchColumn();
// Кол-во Guests онлайн
$count_online_guest = $connect->query("select count(`id`) from `guests` where `time`>'".(time() - 900)."'")->fetchColumn();
// Кол-во играющих в лотерею
$loto_count = $connect->query("select count(`id`) from `loto`")->fetchColumn();
// Лотерея
if ($loto_count >= val($set['loto'])) {
$loto = $connect->query("select * from `loto` order by rand()")->fetch(PDO::FETCH_LAZY);
$stmt = $connect->prepare("update  `users` set `money` = `money` + ? where `id` = ?");
$stmt->execute(array($loto_count, $loto['idu']));
$text = 'В лотерее победил билет '.$loto['id'].'! Джек-под сорвал [b]'.ulogin($loto['idu']).'[/b]:30:';
$name = 'Система';
$stmt = $connect->prepare("insert into `guest` set `date` = ?, `user` = ?, `text` = ?");
$stmt->execute(array(time(), $name, $text));
$stmtea = $connect->prepare("INSERT INTO `logs_money` SET `id_user` = ?, `type` = 'plus', `count` = ?, `action` = ?, `time` = ?");
$zaz='Пополнен баланс через LOTO SYSTEM';
$time=time();
$stmtea->execute(array($loto['idu'],$loto_count,$zaz,$time));
$connect->exec("delete from `loto`");
}
// Zaproslarni filterlash
function filter($t)
{
$t = trim(htmlspecialchars($t));
$t = str_replace("%","",$t);
$t = str_replace("\r","",$t);
$t = str_replace("\n","<br>",$t);
$t = str_replace("|","&#166;",$t);
$t = preg_replace("/s(w+s)1/i","$1",$t);
return $t;
}
function generate_password()
  {
    $arr = array('a','b','c','d','e','f',
                 'g','h','i','j','k','l',
                 'm','n','o','p','r','s',
                 't','u','v','x','y','z',
                 'A','B','C','D','E','F',
                 'G','H','I','J','K','L',
                 'M','N','O','P','R','S',
                 'T','U','V','X','Y','Z',
                 '1','2','3','4','5','6',
                 '7','8','9','0');
    // Генерируем пароль
    $pass = "";
    for($i = 0; $i < 12; $i++)
    {
      // Вычисляем случайный индекс массива
      $index = rand(0, count($arr) - 1);
      $pass .= $arr[$index];
    }
    return $pass;
  }
  function ptime($time = NULL) {
    ini_set('date.timezone', 'Europe/Moscow');
    if ($time == NULL) $time = time();
    $full_time = date('d.m.Y', $time);
    $date = date('d.m.Y', $time);
    $timep = date('H:i', $time);
    if ($date == date('d.m.Y')) $full_time = date('H:i', $time);
    if ($date == date('d.m.Y', time()-60*60*24)) $full_time = date('Вчера, H:i', $time);
    return $full_time;
}
function str($link = '?', $k_page = 1, $page = 1) {
    if ($page < 1) $page = 1;
    echo '<div class="menu">';
    if ($page > 1) echo '<a href="'. $link .'page='. ($page - 1) .'"> &laquo; Назад</a> ';
    if ($page > 1 && $page < $k_page) echo '<span style="color:#000;">|</span>';
    if ($page < $k_page) echo ' <a href="'. $link .'&page='. ($page + 1) .'">Вперед &raquo;</a>';
    echo '<br>';
    if ($page != 1) echo '<a href="'. $link .'&page=1"><span class="unsel"> [1] </span></a>';
    else echo '<span class="sel"> [1] </span>';
    for ($ot = -3; $ot <= 3; $ot++) {
        if ($page + $ot > 1 && $page + $ot < $k_page) {
            if ($ot == -3 && $page + $ot > 3) echo " ..";
            if ($ot != 0) echo ' <a href="'. $link .'&page='. ($page + $ot) .'"><span class="unsel"> ['. ($page + $ot) .'] </span></a>';
            else echo ' <span class="sel"> ['. ($page + $ot) .'] </span>';
            if ($ot == 3 && $page + $ot < $k_page - 1) echo ' ..';
        }
    }
    if ($page != $k_page) echo ' <a href="'. $link .'&page=end"><span class="unsel"> ['. $k_page .'] </span></a>';
    elseif ($k_page > 1) echo ' <span class="sel"> ['. $k_page .'] </span>';
    echo '</div>';
}
function order_day($work,$return_number = false)
{
$f = ($work-time())/(3600*24);
if($f<0)$day='<span style="color:red">0</span>';
elseif($f<1)$day='<span style="color:red">'.round($f,2).'</span>';
else $day='<span style="color:green">'.round($f,2).'</span>';

if ($return_number === true) {
    return round($f,2);
}
return $day;
}
function vremja($time = NULL) {
if(!$time) $time = time();
$data = date('j.n.y', $time);
if($data == date('j.n.y')) $res = 'Сегодня в '. date('G:i', $time);
elseif($data == date('j.n.y', time() - 86400)) $res = 'Вчера в '. date('G:i', $time);

else {
$m = array('0','Янв', 'Фев', 'Мар', 'Апр', 'Май', 'Июн', 'Июл', 'Авг', 'Сен', 'Окт', 'Ноя', 'Дек');
$res = date('j '. $m[date('n', $time)] .' Y в G:i', $time);
}
return $res;
}
function get($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

// Parolni tiklash sessiyalarni 20 menutdan keyin o'chirish!
$connect->query("DELETE FROM `forgot` WHERE `time`+'1200' < '".time()."'");
// Новые сообщения чата
    $stmt_new_chat = $connect->prepare("select count(*) from `guest` where `date` > :time");
    $stmt_new_chat->bindValue(':time', mktime(0, 0, 1), PDO::PARAM_INT);
    $stmt_new_chat->execute();
    $c_new_chat = $stmt_new_chat->fetchColumn();
    $new_chat = $c_new_chat > 0 ? '<span>+'.$c_new_chat.'</span>' : '';
// news
    $stmt_new_news = $connect->prepare("select count(*) from `news` where `time` > :time");
    $stmt_new_news->bindValue(':time', mktime(0, 0, 1), PDO::PARAM_INT);
    $stmt_new_news->execute();
    $c_new_news = $stmt_new_news->fetchColumn();
    $new_news = $c_new_news > 0 ? '<span><font color="red">+'.$c_new_news.'</font></span>' : '';

// Уровни пользователей
$admList = ['Пользователь','Тех.Поддежка [UZ]','Тех.Поддежка [RU]','Модератор форума','Tester','Создатель'];
// Guests larni tozalab turadi!
$connect->query("DELETE FROM `guests` WHERE `time`+'259200' < '".time()."'");
$connect->query("DELETE FROM `mgr_sessions` WHERE `time`+'5000' < '".time()."'");
//$connect->query("DELETE FROM `logs_user` WHERE `time`+'500800' < '".time()."'");
// Капча при авторизации
function CaptchaAuth($uid, $status = false) {

    global $connect;

    $row = is_array($uid) ? $uid : user($uid);

    if ($row) {

        $stmt = $connect->prepare("update `users` set `captcha` = ?, `attempts` = ? where `id` = ?");

        if ($status) {

            // Отключаем капчу

            return $stmt->execute(array(0, 0, $row['id']));

        } else {

            // Валючаем капчу

            return $stmt->execute(array(time(), $row['attempts'] + 1, $row['id']));

        }

    } else
        return false;

}

?>