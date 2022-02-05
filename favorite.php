<?php

// セッションの開始
session_start();

if(isset($_SESSION['name'])){
$name=$_SESSION['name'];
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>お気に入りに追加　処理ページ</title>
</head>
<body>

<?php 

// ログイン状態のとき
if(isset($name)){
    echo 'お気に入りに登録しました。<br>';
    echo '<a href="search_form.php">楽曲検索を続ける</a>';
    echo ' ';
    echo '<a href="home.php">ホームに戻る</a>';

// 未ログイン状態のとき    
}else{
    echo 'お気に入りに登録するにはログインしてください。<br>';
    echo '<a href="login_form.php">ログイン</a>';
    echo ' ';
    echo '<a href="search_form.php">楽曲検索を続ける</a>';
    echo ' ';
    echo '<a href="home.php">ホームに戻る</a>';
}

?>

</body>
</html>