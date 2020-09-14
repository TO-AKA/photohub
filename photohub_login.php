<?php

$error_message="";

//registerボタンを通じて情報を取得する、
//またログイン機能から来た場合はまだ何も入力していないので、情報を省く
if(isset($_POST['login'])){
   $email=$_POST[email];
   $password=$_POST[password];

   try{
   $db =new PDO('mysql:host=****;dbname=****','****','****');
   $sql='select count(*) from photo where email=? and password=?'; 
   $stmt=$db->prepare($sql);
   $stmt->execute(array($email,$password));
   $result=$stmt->fetch();
   $stmt= null;
   $db=null;
   

   //データをDbから取得できた場合に（つまりログインできた）、headerで指定した所に飛ばす
 if($result[0] !=0){
    //ログインできた時にメイン画面へ飛ぶ（exitは）その後特に指定する必要がないのでこの処理を書く
    header('Location: http://localhost/photohub_main.php');
    exit;

     }else{
     $error_message="メールアドレスまたはパスワードが違います";
     }

      //例外が来た場合の処理方法
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
<link rel="stylesheet" href="style_css/style_login.css">
<title>ログインページ</title>
</head>

<body>
<h1>photohubのログインページへようこそ</h1><br><br><br>

<form action="" method="POST">
	<?php if($error_message !==null && $error_message!=='') {echo $error_message ;}  ?>

	〇メールアドレス<br>
    <input type="text" name="email" placeholder="email"><br>
    〇パスワード<br>
    <input type="password" name="password" placeholder="password"><br>
    <input type="submit" name="login" value="ログイン">
  
    
</form>

</body>
</html>