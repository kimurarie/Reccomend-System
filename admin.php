<?php

// セッションの開始
session_start();

// 管理者ページのログインパスワード
define( 'PASSWORD', 'g121r060');

// データベースの接続状態
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', 'kimurie0810');
define( 'DB_NAME', 'reccomend_system');

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$now_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$message = array();
$message_array = array();
$success_message = null;
$error_message = array();
$clean = array();


if( !empty($_GET['btn_logout']) ) {
	unset($_SESSION['admin_login']);
}

if( !empty($_POST['btn_submit']) ) {

	if( !empty($_POST['admin_password']) && $_POST['admin_password'] === PASSWORD ) {
		$_SESSION['admin_login'] = true;
	} else {
		$error_message['login'] ='パスワードが違います。';
	}
}

// データベースに接続
$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 接続エラーの確認
if( $mysqli->connect_errno ) {
	$error_message[] = 'データの読み込みに失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
} else {

	// 投稿内容を取得するSQL作成
	$sql = "SELECT id,name,message,date FROM board ORDER BY date DESC";

	// データの登録
	$res = $mysqli->query($sql);

    if( $res ) {
		$message_array = $res->fetch_all(MYSQLI_ASSOC);
    }

	// データベースの接続を閉じる
    $mysqli->close();
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>管理者画面</title>

</head>
<body>
<h1>管理者ページ</h1>

<?php if (isset($error_message['login'])) : ?>
    <p><?php echo $error_message['login']; ?>
<?php endif; ?>

<section>
<!-- ログインセッション有り -->
<?php if( !empty($_SESSION['admin_login']) && $_SESSION['admin_login'] === true ): ?>
<?php if( !empty($message_array) ){ ?>
<?php foreach( $message_array as $value ){ ?>
<article>
	<div class="info">
		<h2><?php echo $value['name']; ?></h2>
		<time><?php echo date('Y年m月d日 H:i', strtotime($value['date'])); ?></time>
		<p><a href="edit.php?message_id=<?php echo $value['id']; ?>">編集</a>
		&nbsp;&nbsp;<a href="delete.php?message_id=<?php echo $value['id']; ?>">削除</a></p>
	</div>
	<p><?php echo nl2br($value['message']); ?></p>
</article>
<?php } ?>
<?php } ?>

<form method="get" action="">
    <input type="submit" name="btn_logout" value="ログアウト">
</form>

<!-- ログインセッション無し -->
<?php else: ?>
<form method="post">
	<div>
		<label for="admin_password"></label>
		<input id="admin_password" type="password" name="admin_password" placeholder="パスワード">
	</div>
	<input type="submit" name="btn_submit" value="ログイン">
</form>
<br>
<a href="home.php">ホームに戻る</a>
<?php endif; ?>
</section>

</body>
</html>