<?php

// セッションの開始
session_start();

//セッションの中身をすべて削除
$_SESSION = array(); 

//セッションを破壊
session_destroy(); 

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>ログアウト</title>
</head>
<body>

<h1>ログアウト</h1>
<p>ログアウトしました。</p>
<a href="home.php">ホーム</a>
<a href="login_form.php">ログイン</a>
</body>
</html>
