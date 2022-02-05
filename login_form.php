<?php

// セッションの開始
session_start();

$e = $_SESSION;

// セッションの中身をすべて削除
$_SESSION = array();

// セッションを破壊
session_destroy();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログイン画面</title>
</head>

<body>
<h1>ログイン画面</h1>

<form action="login.php" method="post">
            
    <div class="attention">
        <?php if (isset($e['false'])) : ?>
            <p><?php echo $e['false']; ?>
        <?php endif; ?>
    </div>

    <div>
    <label for="username"></label>
    <input type="text" id="username" name="username" size="25" placeholder="ユーザ名"></text>
    </div>
    
    <div class="attention">
        <?php if (isset($e['username'])) : ?>
            <p><?php echo $e['username']; ?>
        <?php endif; ?>
    </div>      
    
    <div>  
    <label for="password"></label>
    <input type="password" id="password" name="password" size="25" placeholder="パスワード"></text>
    </div>  
    
    <div class="attention">  
        <?php if (isset($e['password'])) : ?>
            <p><?php echo $e['password']; ?>
        <?php endif; ?>
    </div>
    
    <div class="submit">
    <input type="submit" name="btn_login" value="ログイン">
    </div>

    <p>新規登録画面は<a href="signup_form.php">こちら</a></p>
  
</form>
 
</body>
</html>