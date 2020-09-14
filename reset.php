<?php
require_once("date/db_info.php");
$s=new PDO("mysql:host=$serve;dbname=$DBNM",$user,$password);

$s->query("DELETE FROM ****");
$s->query("DELETE FROM ****");
$s->query("ALTER TABLE **** AUTO_INCREMENT=1");
$s->query("ALTER TABLE **** AUTO_INCREMENT=1");

print "photohubのテーブルを初期化致しました。";
?>