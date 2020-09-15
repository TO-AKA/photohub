<?php

//DBの接続
require_once("date/db_info.php");

//DBの絞り込み
$s=new PDO("mysql:host=$server;dbname=$DBNM",$user,$password);

//スレ番号の取得
$gu_d=$_GET["gu"];

//$gu_dに番号以外が含まれていたら、処理しない
if(preg_match("/[^0-9]/",$gu_d)){
  print <<<eot1
  不正な値が入力されています<br>
  <a href="photohub_main.php">スレ一覧に戻る</a>
eot1;

//処理を行う
  }elseif(preg_match("/[0-9]/",$gu_d)){
	
	//名前とメッセージをそれぞれ取得する
	$na_d=isset($_GET["na"])?htmlspecialchars($_GET["na"]):null;  //名前を取得
  $me_d=isset($_GET["me"])?htmlspecialchars($_GET["me"]):null;  

   //IPアドレスを取得する
   $ip=getenv("REMOTO_ADDR");

   //postからスレ番号を取得し、guと一致する番号のスレを選択し、表示する
   $re=$s->query("SELECT sure FROM post WHERE num=$gu_d");
   $kekka=$re->fetch();

   //$sure_comでスレ内容を表す
   $sure_com="[".$gu_d."".$kekka[0]."]";


//スレタイトルの書き出し部分
  print <<<eot2
     <!DOCTYPE html>
     <html lang="ja">
     <head>
     <meta charset= "utf-8">
     <title>photohub $sure_com スレッド</title>
     <link rel="stylesheet" href="style_css/style.css">
     </head>
    <body>
    <div style="color:purple;font-size:35px">
    $sure_com スレッド
    </div>
    <br>
    <div style="font-size:18pt">$sure_com のメッセージ</div>
  eot2;

  //名前が入力されていれば、post2にレコードを挿入
  if($na_d<>""){
    $s->query("INSERT INTO post2 VALUES (0,'$na_d','$me_d',now(),$gu_d,'$ip')");
  }

  print "<hr>";

  //日時順にレスを表示
  $re=$s->query("SELECT * FROM post2 WHERE num=$gu_d ORDER BY date");

  $i=1;
while($kekka=$re->fetch()){

print "$i($kekka[0]):$kekka[1]:$kekka[3]<br>";

print nl2br($kekka[2]);

print "<br><br>";
$i++;
}



print<<<eot3
<hr>
<div style="font-size:18pt">
$sure_com にメッセージを書くときはここにどうぞ
</div>

<form method="GET" action="sureshow.php">
〇名前
<input type="text" name="na"><br>
〇メッセージ<br>
<textarea name="me" rows="10" cols="70"></textarea>
<input type="hidden" name="gu" value="$gu_d"><br>
<input type="submit" value="送信"><br><br>
</form>

<form enctype="multipart/img-data"  action="sureshow.php" method="POST">
  <input type="hidden" name="name" value="value" />
  〇アップロード: <input name="userfile" type="file" /><br>
  <input type="submit" value="画像送信" /><br><br>


〇削除したい方は番号を入力してください<br>
<input type = "text" name = "deleteNo"  placeholder = "削除対象番号">
<input id="pass" type = "text" name = "delpass"  placeholder = "パスワード">
<input type = "submit"  name = "delete" value = "削除"><br><br>
</form>


<hr>
<h3><a href="photohub_main.php">スレ一覧に戻ります</a></h3>

</body>
</html>

eot3;

//$gu_dに数字以外にも、数字も含まれていない時の処理
}else{
 print "スレを選択してください。<br>";
print "<a href='photohub_main.php'>ここをクリックしてレス一覧へお戻りください</a>";
}


?>