<?php

// セッションの開始
session_start();

// DB接続情報
require("db.php");

// 変数の初期化
$error_message = [];
$favorite_music = array();

if(isset($_SESSION['name'])){
$name=$_SESSION['name'];
}

if(isset($_SESSION['user_id'])){
$user_id=$_SESSION['user_id'];
}

if(isset($_SESSION['id'])){
$id=$_SESSION['id'];
}

if(isset($_SESSION['title'])){
$title = $_SESSION['title'];
}

// ログイン状態でお気に入り登録したとき
if( (isset($name)) and (isset($_POST['btn_favorite'])) ){

// データベースに接続
$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
    // 接続エラーの確認
    if( $mysqli->connect_errno ) {
        $error_message[] = '書き込みに失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
    } else {

        // 文字コード設定
        $mysqli->set_charset('utf8');
        
        // お気に入り登録した楽曲のIDを取得するSQL作成
        $sql = "SELECT id FROM music_table WHERE title='$title'";
        $res = $mysqli->query($sql);
        if( $res ) {
        $value_music = $res->fetch_assoc();
        }

        $id = $value_music['id'];
        $_SESSION['id'] = $id;

        // お気に入り登録した楽曲のIDとユーザIDを登録するSQL作成
        $sql2 = "INSERT INTO favorite (user_id,id) VALUES ('$user_id','$id')";
        $res2 = $mysqli->query($sql2);

        // データベースの接続を閉じる
        $mysqli->close();	

        header('Location: favorite.php');
        exit;
    }
// 未ログイン状態でお気に入り登録したとき
}elseif(!isset($name)){
    header('Location: favorite.php');
    exit;
}

// ログイン状態のとき
if(isset($name)){

// データベースに接続
$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
            
    // 接続エラーの確認
    if( $mysqli->connect_errno ) {
    $error_message[] = '書き込みに失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
    } else {

    // 文字コード設定
    $mysqli->set_charset('utf8');

    // お気に入り一覧を表示するSQL作成
    $sql3 = "SELECT users.user_id,name,music_table.id,title,artist,url FROM favorite,
    users,music_table WHERE favorite.user_id=users.user_id AND 
    favorite.id=music_table.id AND users.user_id='$user_id' ORDER BY sort DESC";
    $res3 = $mysqli->query($sql3);
    if( $res3 ) {
        $favorite_music = $res3->fetch_all(MYSQLI_ASSOC);
    }

    // データベースの接続を閉じる
    $mysqli->close();	
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>マイページ</title>
</head>

<body>

<h1>マイページ</h1>

<h3>
<?php echo $name; ?>さんのお気に入り一覧
</h3>

<hr>

<section>
<?php if( !empty($favorite_music) ){ ?>
<?php foreach( $favorite_music as $value ){ ?>
<article align="center">
    <div>
        <h4><?php echo $value['title']; ?>
        <?php echo "/"; ?>
        <?php echo $value['artist']; ?>
        </h4> 
        <iframe width="416" height="234" src=<?=$value['url']?> frameborder="0" 
        allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        
        <p><a href="favorite_delete.php?id=<?php echo $value['id']; ?>">
        お気に入りから削除</a></p>
        
        <hr width="45%">
    </div>
</article>
<?php } ?>
<?php } 
?>

</section>

<p align="center">
    <a href="home.php">ホームに戻る</a>
    <a href="logout.php">ログアウト</a>
</p>

</body>
</html>