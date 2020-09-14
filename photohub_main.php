<?php

//DBへ接続
 require_once("date/db_info.php");

 //テーブルへの接続
 $s=new pdo("mysql:host=$server;dbname=$DBNM",$user,$password);

 print <<<eot1
  <!DOCTYPE html>
  <html lang="ja">
  <head>
  <meta charset= "utf-8">
  <title>photohubメインページ</title>
  </head>
  <body style="background-color:silver">
  <span style="color:blue;font-size:35pt">
  photohubにようこそ！
  </span>
  <p>見たい写真スレをクリックして下さい</p>
  <hr>
  <div style="font-size:20pt">(スレ一覧)</div>

 eot1;
 
 //Ipアドレスの取得 
  $ip=getenv("REMOTE_ADDR");

  //suの値が入力されているなら、テーブルにそれぞれ値を格納
  $su_d=isset($_GET["su"])? htmlspecialchars($_GET["su"]):null;
  if($su_d<>""){
  $s->query("INSERT INTO ****(sure,date,IP) VALUES('$su_d',now(),'$ip')");
  }

  //テーブルから情報を引用
  $re=$s->query("SELECT * FROM ****");
  while($kekka=$re->fetch()){
   print <<<eot2
   <a href="sureshow.php?gu=$kekka[0]">$kekka[0] $kekka[1]</a>
   <br>
   $kekka[2]作成<br><br>
   eot2;
}

print <<<eot3
  <hr>
  <div style="font-size:20pt">(スレ作成)</div>
  新しくスレを作る場合は下記から行ってください
  <br>
  <form method="GET" action="photohub_main.php"> 
  新規スレのタイトル
  <input type="text" name="su" size="50">
  <div><input type="submit" value="作成"></div></form>
  <hr>
  <span style="font-size:20pt">(メッセージ検索)</span>
  スレ・またはキーワードを検索する時は<a href="search.php">こちら</a>
  <hr>

  </body>
  </html>
eot3;

?>