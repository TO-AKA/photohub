<?php
require_once("date/db_info.php");
$s=new PDO("mysql:host=$server;dbname=$DBNM",$user,$password);

print <<<eot1
   <!DOCTYPE html>
   <html lang="ja">
   <head>
   <title>photo hubメインページ</title>
   <meta charset= "utf-8">
   </head>
   
    <body style="background-color: silver">
    <hr>
   <div style="font-size:18pt">(検索結果は下記の通りです)</div>
eot1;


   //seの値が入力されているならば・・・
   $se_d=isset($_GET["se"])?htmlspecialchars($_GET["se"]):null;
   if($se_d<>""){
   $str=<<<eot2
   //それぞれの値をテーブルから取得する
    
   
   SELECT ****.num,****.nama,****.mess,****.sure
    FROM ****
    JOIN ****
    ON
    *****.num=****.num
    WHERE *****.mess LIKE "%$se_d%"
   eot2;

    
   //取得結果の表示
    $re=$s->query($str);
    while($kekka=$re->fetch()){
        print "$kekka[0] : $kekka[1]: $kekka[2] ($kekka[3])";
        print "<br><br>";
    }
   }


   print<<<eot3
   <hr>
  <form method="GET" action="search.php">
  〇検索する文字列
  <input type="text" name="se">
  <div>
  <input type="submit" value="検索">
  </div>
 </form>
  <br>
  <a href="photohub_main.php">スレ一覧はこちらです</a>
  </body>
 </html>

eot3; 
?>