<?php
list($msec,$sec)=explode(chr(32),microtime());
$headtime=$sec+$msec;
// ошибки php
ini_set('error_reporting', 'On');
ini_set('display_errors', 'on');
ini_set('display_startup_errors', 'on');
include_once($_SERVER["DOCUMENT_ROOT"]."/inc/function.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/inc/CSRF-secure.php");
// заголовок
$title = empty($title) ? 'domen.ru | Кабинет' : $title; 
echo '<!DOCTYPE html PUBLIC "-//WAPFORUM//DTD XHTML Mobile 1.0//EN" "http://www.wapforum.org/DTD/xhtml-mobile10.dtd">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#5d80a6">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<link rel="apple-touch-icon-precomposed" href="/inc/style/img/app-icon.png">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon" />
<link href="/bootstrap/css/bootstrap.css" rel="stylesheet">
<link href="/inc/style/style.css" rel="stylesheet">
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/function.js"></script>
<meta name="keywords" content="Хостинг, Посуточный оплата, domen.ru Мобильный Хостинг,Мобильный Хостинг,domen.ru, php 7, ffmpeg, GD,(pdo) MySQL(i), sqlite, Curl,IonCube, выбор версии php"/>
<meta name="description" content="Хостинг от domen.ru – качественный мобильный хостинг сайтов c круглосуточной поддержкой. Надежный linux хостинг в Азие [W-S Pro]"/> 
<meta name="author" content="domen.ru"/>
<meta name="copyright" content="domen.ru"/>
<meta http-equiv="content-language" content="ru"/>
<title>'.$title.'</title></head><body>';
// системное


$id = isset($_GET['id']) ? val($_GET['id'], 1) : false;
$act = isset($_GET['act']) ? $_GET['act'] : false;
$adm_id = isset($user['admin']) ? val($user['admin']) : false;
$search = $_GET['search'] ? $_GET['search'] : false;
$time = time();
$_SESSION['tok'] = rand(1111,9999);
// работа сайта
if ($set['close'] == 2 && $adm_id == false) exit('<header>
         <table>
            <tr>
               <td class="l_bar">
<a href="/"><img src="/inc/style/img/home.png" width="23"  alt="home"></a>
               </td>
               <td class="c_bar">
                  <h1 id="logo">domen.ru</h1>
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
<span>&copy; domen.ru - 2017-'.date('Y').'</span>
         <span>
         </span>
      </footer>
    </div>
   </body>
</html>');
// 404
if (isset($_GET['404'])) exit('<header>
         <table>
            <tr>
               <td class="l_bar">
<a href="/"><img src="/inc/style/img/home.png" width="23"  alt="home"></a>
               </td>
               <td class="c_bar">
                  <h1 id="logo">domen.ru</h1>
               </td>
            </tr>
         </table>
      </header><div class="mOm"><div class="block first"><div class="menu"><center><h1><font color="red">Error #404</font></h1></center></div></div><footer>
<span>&copy; domen.ru - 2017-'.date('Y').'</span>
         <span>
         </span>
      </footer>
    </div>
   </body>
</html>'.header( 'Refresh: 2; url=/' ).'');
if (isset($_GET['403'])) exit('<header>
         <table>
            <tr>
               <td class="l_bar">
<a href="/"><img src="/inc/style/img/home.png" width="23"  alt="home"></a>
               </td>
               <td class="c_bar">
                  <h1 id="logo">domen.ru</h1>
               </td>
            </tr>
         </table>
      </header><div class="mOm"><div class="block first"><div class="menu"><center><h1><font color="red">Error #403</font></h1></center></div></div><footer>
<span>&copy; domen.ru - 2017-'.date('Y').'</span>
         <span>
         </span>
      </footer>
    </div>
   </body>
</html>'.header( 'Refresh: 2; url=/' ).'');
// бан
if (isset($active) && $user['ban'] > time() && $adm_id != 5)
exit('<header>
         <table>
            <tr>
               <td class="l_bar">
<a href="/"><img src="/inc/style/img/home.png" width="23"  alt="home"></a>
               </td>
               <td class="c_bar">
                  <h1 id="logo">domen.ru</h1>
               </td>
            </tr>
         </table>
      </header><div class="mOm"><div class="block first"><div class="title"><center><h1><font color="red">Бан!</font></h1></center></div><div class="menu">Ваш аккаунт заблокирован до '.date('d.m.Y H:i', $user['ban']).'!</div></div><footer>
<span>&copy; domen.ru - 2017-'.date('Y').'</span>
         <span>
         </span>
      </footer>
    </div>
   </body>
</html>');

if (isset($active) == false)
{
echo '<header>
         <table>
            <tr>
               <td class="l_bar">
<a href="/"><img src="/inc/style/img/home.png" width="23"  alt="home"></a>
               </td>
               <td class="c_bar">
                  <h1 id="logo">domen.ru</h1>
               </td>
               <td class="r_bar">
<a href="/auth" title="Вход"><img width="23" src="/img/auth1.png" alt="Вход"></a>
</td>
<td class="r_bar">
<a href="/reg" title="Регистрация"><img width="23" src="/img/reg1.png" alt="Регистрация"></a>
               </td>
            </tr>
         </table>
      </header>';
}
else
{
$new_tickets = $connect->query("SELECT COUNT(*) FROM `tickets` WHERE `id_user` = '$user->id' AND `read_user` = '0'")->fetchColumn();
$new_note = $connect->query("SELECT COUNT(*) FROM `note` WHERE `id_user` = '$user->id' AND `readmsg` = '0'")->fetchColumn();
if ($new_note==0) {$newn='';}
if ($new_note==1) {$newn='1';}
if ($new_note==2) {$newn='2';}
if ($new_note==3) {$newn='3';}
if ($new_note==4) {$newn='4';}
if ($new_note==5) {$newn='5';}
if ($new_note>=6) {$newn='e';}

if ($new_tickets==0) {$newt='';}
if ($new_tickets==1) {$newt='1';}
if ($new_tickets==2) {$newt='2';}
if ($new_tickets==3) {$newt='3';}
if ($new_tickets==4) {$newt='4';}
if ($new_tickets==5) {$newt='5';}
if ($new_tickets >= 6) {$newt='e';}
echo '<header>
         <table>
            <tr>
               <td class="l_bar">
<a href="/"><img src="/inc/style/img/home.png" width="23"  alt="home"></a>
               </td>
               <td class="c_bar">
                  <h1 id="logo"><b>domen.ru</b></h1>
               </td>
               <td class="r_bar">
<a href="/user/menu" title="Кабинет"><img width="25" src="/img/us2.png" alt="Кабинет"></a>
</td>
<td class="r_bar">
<a href="/user/inor" title="Уведомления"><img width="23" src="/img/n'.$newn.'.png" alt="Уведомления"></a>
               </td>
               <td class="r_bar">
<a href="/user/tickets" title="Тикеты"><img width="23" src="/img/helpnew'.$newt.'.png" alt="Тикеты"></a>
               </td>';
    
if ($adm_id == 5) { 
$newadmt = $connect->query("SELECT COUNT(*) FROM `tickets` WHERE `read_adm` = '0'")->fetchColumn();
if ($newadmt >= 1) {$v1='n';}else{$v1='';}
    echo '<td class="r_bar">
<a href="/adm/tickets" title="Support Тикеты"><img width="23" src="/img/sup'.$v1.'.png" alt="Support Тикеты"></a>
               </td>';
    echo '<td class="r_bar">
<a href="/adm" title="Панель Администратор!"><img width="23" src="/img/adms.png" alt="Панель Администратор!"></a>
               </td>';
}

        echo ' </tr>
         </table>
      </header>';
}

echo '<div class="mOm"><div class="block first">';

?>