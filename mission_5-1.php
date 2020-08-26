<html>
	
<head>
<title>mission5-1</title>
<meta charset= "utf-8">
</head>

<body>

 <?php

     
      //データベースに接続   
    $dsn='mysql:dbname=tb220233db;host=localhost';
	$user='tb-220233';
	$password='HZ2E7wKpTw';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING)); 


      //テーブルの作成
    $sql = "CREATE TABLE IF NOT EXISTS tech_text"
    ."("
    ."id INT AUTO_INCREMENT PRIMARY KEY,"
    ."name char(32),"
    ."comment TEXT,"
    ."pass char(32)"
    .");";
    $stmt = $pdo->query($sql);



    //編集選択番号
if(!empty($_POST["editNo"]) and !empty($_POST["editpass"])){
    $id = $_POST["editNo"];
    $editpass = $_POST["editpass"];
    $sql = 'SELECT * FROM tech_text';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
       foreach ($results as $row){
        if($row['id'] == $id){
            $editname = $row['name'];
            $editcomment = $row['comment'];
            $pass = $row['pass'];
            $editnumber = $row['id'];
       }
        }
       
}

?>  


<form method = "POST" action = mission_5-1.php>
<input type = "text"  name = "name"  value =  "<?php if(!empty($pass)){echo $editname;}?>"  placeholder = "<?php if(empty($pass)){echo "名前";}?>">
<input type = "text"  name = "comment"  value = "<?php if(!empty($pass)){echo $editcomment;}?>"  placeholder = "<?php if(empty($pass)){echo "コメント";}?>">		
<input type = "text" name = "password" value ="<?php if(!empty($pass)){echo $pass;}?>"  placeholder = "<?php if(empty($pass)){echo "パスワード";}?>">
<input id="pass" type = "hidden"  name = "edit-number" value = "<?php if(!empty($pass)){echo $editnumber;}?>" >
<input type = "submit"  name = "btn"value = "送信"><br><br>
	
<input type = "text" name = "deleteNo"  placeholder = "削除対象番号">
<input id="pass" type = "text" name = "delpass"  placeholder = "パスワード">
<input type = "submit"  name = "delete" value = "削除"><br>
	
<input type = "text" name = "editNo" placeholder = "編集対象番号">
<input id="pass" type = "text" name = "editpass"  placeholder = "パスワード">
<input type =  "submit" name = "edit" value = "編集"><br><br> 




<?php

     //編集実行機能
if(!empty($_POST["edit-number"]) and empty($_POST["edit"])){
    $id = $_POST["edit-number"];
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"]; 
        
    $sql = 'update tech_text set name=:name,comment=:comment,pass=:pass where id=:id';
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
    $stmt->bindParam(':pass', $password, PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    
}

     //新規投稿機能
if(!empty($_POST["name"]) && !empty($_POST["comment"]) && !empty($_POST["password"]) && empty($_POST["edit-number"])){
    $name = $_POST["name"];
    $comment = $_POST["comment"];
    $password = $_POST["password"];

    $sql = $pdo -> prepare("INSERT INTO tech_text (name, comment, pass) VALUES(:name, :comment, :pass)");
    $sql -> bindParam(':name', $name, PDO::PARAM_STR);          //変数をバインドする
    $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
    $sql -> bindParam(':pass', $password, PDO::PARAM_STR);
    $sql -> execute();             
}



      // 削除機能
if(!empty($_POST['deleteNo']) && !empty($_POST['delpass'])){
    $delete=$_POST['deleteNo']; 
    $delpassword=$_POST['delpass'] ;
    $sql = 'delete from tech_text where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $delete, PDO::PARAM_INT);
	$stmt->execute();
}



          //表示機能
    $sql = 'SELECT * FROM tech_text';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        //$rowの中にはテーブルのカラム名が入る
        echo $row['id'].',';
        echo $row['name'].',';
        echo $row['comment'].'<br>';
        echo "<hr>";
    }



?>