<?php

//registerボタンを通じて情報を取得する、
//またログイン機能から来た場合はまだ何も入力していないので、情報を省く
if(isset($_POST['register'])){
   $email=$_POST[email];
   $password=$_POST[password];

   try{
   $db =new PDO('mysql:host=****;dbname=****','****','****');
   $sql='insert into photo(email,password) values(?,?)'; 
   $stmt=$db->prepare($sql);
   $stmt->execute(array($email,$password));
   $stmt= null;
   $db=null;
   
  //ログインページに飛ぶ（exitは）その後特に指定する必要がないのでこの処理を書く
  header('Location: http://localhost/photohub_login.php');
  exit;

    }catch(PDOException $e){
     echo $e->getMessage();
     exit;
   }

}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style_css/style_reg.css">
<title>ログインページ</title>
</head>

<body>
<h1>photohubの新規登録画面へようこそ</h1><br><br>

<div class="form">
<form method="post" action="photohub_register.php">
   〇メールアドレス<br>
    <input type="text" name="email" placeholder=""><br>
    〇パスワード<br>
    <input type="password" name="password" placeholder=""><br>
    <input type="submit" name="register" value="登録する"><br><br><br>

    <a href="photohub_login.php">ログイン画面へ</a>

</div>    
</form>
</html>