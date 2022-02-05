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
    <title>新規登録画面</title>
</head>
<body>
    <h1>新規登録画面</h1>

    <form action="signup.php" method="post">
        <div>
            <label for="name"></label>
            <input type="text" id="name" name="name" size="35" placeholder="名前"></text>
            <?php if (isset($e['name'])) : ?>
                <p><?php echo $e['name']; ?>
            <?php endif; ?>
        </div>
        <div>
            <label for="username"></label>
            <input type="text" id="username" name="username" size="35" placeholder="ユーザ名 (半角英数字)"></text>
            <?php if (isset($e['username'])) : ?>
                <p><?php echo $e['username']; ?>
            <?php endif; ?>
            <?php if (isset($e['match'])) : ?>
                <p><?php echo $e['match']; ?>
            <?php endif; ?>
        </div>
        <div>
            <label for="password"></label>
            <input type="password" id="password" name="password" size="35" placeholder="パスワード (半角英数字混在の8文字以上)"></text>
            <?php if (isset($e['password'])) : ?>
                <p><?php echo $e['password']; ?>
            <?php endif; ?>
        </div>
        <div>
            <label for="password_conf"></label>
            <input type="password" id="password_conf" name="password_conf" size="35" placeholder="確認用パスワード"></text>
            <?php if (isset($e['password_conf'])) : ?>
                <p><?php echo $e['password_conf']; ?>
            <?php endif; ?>
            <?php if (isset($e['password_conf_empty'])) : ?>
                <p><?php echo $e['password_conf_empty']; ?>
            <?php endif; ?>
        </div>
        <input type="submit" name="btn_submit" value="新規登録">
        </from>
    
     <p>すでに登録済みの方は<a href="login_form.php">こちら</a></p>
   
</body>
</html>