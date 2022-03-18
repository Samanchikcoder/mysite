<?php
list($msec,$sec)=explode(chr(32),microtime());

if ($_SERVER['PHP_SELF'] != '/index.php') {
echo '</div>';
echo '<div class="menu"><a href="/"><img src="/inc/style/img/up.png"> На главную</a></div> '; 
}

echo '</div><footer>';

?>
<span>&copy; <b>domen.ru</b> - 2018-<?=date('Y');?></span>
      </footer>
    </div>
<center><a href="/abuse"><font color="red">Abuse - Жалобы</font></a></center>
<?

?>
<div class="center">Ген. <?=round(($sec+$msec)-$headtime,3)?> сек.</div>
   </body>
</html>