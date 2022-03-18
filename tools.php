<?php
$authlog = $connect->prepare("insert into `authlog` set `time` = ?, `uid` = ?, `ip` = ?, `ua` = ?, `key` = ?, `attempts` = ?");
$stmt_authte = $connect->prepare("select count(*) from `authlog` where `uid` = ?");
?>