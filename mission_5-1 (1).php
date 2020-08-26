<?php
  
     
      //データベースに接続   
    $dsn='mysql:dbname=テータベース名;host=ホスト名';
	$user='ユーザー名';
	$password='パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); 


      //テーブルの作成
    $sql = "CREATE TABLE IF NOT EXISTS tbtest"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."date datetime,"    //投稿日時のカラム
    ."pass char(10)"
    .");";
    $stmt = $pdo->query($sql);




    //編集選択機能（編集番号とパスワードを打ち込んだら、その内容が表示されるようにする）
if(!empty($_POST["editNo"]) && !empty($_POST["editpass"])){
    $id = $_POST["editNo"];
    $editpass = $_POST["editpass"];
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
      if($row['id'] == $id){
          
    //編集選択用の関数を用意し、入力フォームvalueでechoさせる
      $e_name = $row['name'];
      $e_comment = $row['comment'];
      $pass = $row['pass'];
      $e_number = $row['id'];
       }
    }
}
?>  


<html>
	
<head>
<title>mission5-1</title>
<meta charset= "utf-8">
</head>

<body>

<form method = "POST" action = mission_5-1.php>
    
・新規投稿はこちらから入力してください<br>   
<input type = "text"  name = "name"  value =  "<?php if(!empty($pass)){echo $e_name;}?>"  placeholder = "<?php if(empty($pass)){echo "名前";}?>">
<input type = "text"  name = "comment"  value = "<?php if(!empty($pass)){echo $e_comment;}?>"  placeholder = "<?php if(empty($pass)){echo "コメント";}?>">		
<input type = "text" name = "password" value ="<?php if(!empty($pass)){echo $pass;}?>"  placeholder = "<?php if(empty($pass)){echo "パスワード";}?>">
<input id="pass" type = "hidden"  name = "edit-number" value = "<?php if(!empty($pass)){echo $e_number;}?>" >
<input type = "submit"  name = "btn"value = "送信"><br><br>


・削除したい方は番号を入力してください<br>
<input type = "text" name = "deleteNo"  placeholder = "削除対象番号">
<input id="pass" type = "text" name = "delpass"  placeholder = "パスワード">
<input type = "submit"  name = "delete" value = "削除"><br><br>
	
	
・編集したい方は番号を入力してください<br>
<input type = "text" name = "editNo" placeholder = "編集対象番号">
<input id="pass" type = "text" name = "editpass"  placeholder = "パスワード">
<input type =  "submit" name = "edit" value = "編集"><br><br> 
</form>



<?php

     //編集実行機能(編集番号とパスワードが未入力なら、書き込まない様に設定する)
if(!empty($_POST["edit-number"]) && empty($_POST["edit"])){
    $id = $_POST["edit-number"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"]; 
    $date = date("Y/m/d H:i:s");
    
    $sql = 'update tbtest set name=:name,comment=:comment,pass=:pass,date=:date where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $password, PDO::PARAM_STR);
    $stmt->bindParam(':date', $date, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
}


     //新規投稿機能(新規投稿なら)
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && empty($_POST["edit-number"])){
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"];
    $date = date("Y/m/d H:i:s");
    
    $sql = $pdo -> prepare("INSERT INTO tbtest (name, comment,pass,date) VALUES(:name, :comment ,:pass ,:date)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);          //変数をバインドする
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':date', $date, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $password, PDO::PARAM_STR);
    $sql -> execute();             
}



       // 削除機能(対象番号とパス受け取り後、delete文で削除を行なう)
if(!empty($_POST['deleteNo']) && !empty($_POST['delpass'])){
    $delete=$_POST['deleteNo']; 
    $delpassword=$_POST['delpass'];
    
    $sql = 'delete from tbtest where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $delete, PDO::PARAM_INT);
	$stmt->execute();
}



          //表示機能
    $sql = 'SELECT * FROM tbtest';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
   
        foreach($results as $row){ //各投稿ごとの表示処理
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].',';
        echo $row['date']."<br>";
        echo "<hr>";
        }    
            



?>

</body>
</html>