<?php

// セッションの開始
session_start();

if(isset($_SESSION['name'])){
$name=$_SESSION['name'];
}

if(isset($_SESSION['user_id'])){
    // ログインしているとき
    $link1='<a href="logout.php">ログアウト</a>';
}else{
    // ログインしていないとき
    $message = 'こんにちは　';
    $link2='<a href="login_form.php">ログイン</a>';
    $link3='<a href="signup_form.php">新規登録</a>';
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>ホーム画面</title>
</head>

<body>
    <h1>楽曲レコメンドシステム</h1>
    
    <?php if (isset($name)) : ?>
        こんにちは、<a href="mypage.php"><?=$name?>さん</a> <?php echo $link1; ?>
    <?php endif; ?>

    <?php if (isset($message)) : ?>
        <p><?php echo $message; ?>
        <?php echo $link2; ?>
        <?php echo "/"; ?>
        <?php echo $link3; ?>
    <?php endif; ?>
    
    <p>
        <a href="search_form.php">検索する</a>
        <a href="regist_form.php">登録する</a>
        <a href="board.php">掲示板</a>
    </p>


</body>
</html>