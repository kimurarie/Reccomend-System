<?php

// セッションの開始
session_start();

// DB接続情報
require("db.php");

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$now_date = null;
$data = null;
$file_handle = null;
$split_data = null;
$message_array = array();
$error_message = array();
$clean = array();

if( !empty($_POST['btn_submit']) ) {
	
	// 名前の入力チェック
	if( empty($_POST['name']) ) {
		$error_message['name'] = '名前を入力してください。';
	} else {
		$clean['name'] = htmlspecialchars( $_POST['name'], ENT_QUOTES);
	}
	// メッセージの入力チェック
	if( empty($_POST['message']) ) {
		$error_message['message'] = 'メッセージを入力してください。';
	} else {
		$clean['message'] = htmlspecialchars( $_POST['message'], ENT_QUOTES);
	}

	if( empty($error_message) ) {
		
		// データベースに接続
		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);

		// 接続エラーの確認
		if( $mysqli->connect_errno ) {
			$error_message[] = '書き込みに失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
		} else {

			// 文字コード設定
			$mysqli->set_charset('utf8');
			
			// 書き込み日時を取得
			$now_date = date("Y-m-d H:i:s");
			// データを登録するSQL作成
			$sql = "INSERT INTO board (name, message, date) VALUES ( '$clean[name]', '$clean[message]', '$now_date')";
			$res = $mysqli->query($sql);
			if( $res ) {
				$_SESSION['success_message'] = 'メッセージを書き込みました。';
			} else {
				$error_message[] = '書き込みに失敗しました。';
			}
		
			// データベースの接続を閉じる
			$mysqli->close();
		}

		header('Location: board.php');
	}
}

// データベースに接続
$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);

// 接続エラーの確認
if( $mysqli->connect_errno ) {
	$error_message[] = 'データの読み込みに失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
} else {

	// 投稿内容を取得するSQL作成
	$sql = "SELECT name,message,date FROM board ORDER BY date DESC";
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
<title>掲示板</title>

</head>

<body>
<h1>掲示板</h1>

<?php if( empty($_POST['btn_submit']) && !empty($_SESSION['success_message']) ): ?>
    <p class="success_message"><?php echo $_SESSION['success_message']; ?></p>
    <?php unset($_SESSION['success_message']); ?>
<?php endif; ?>

<p>
<form method="post">
	<div>
		<label for="name">名前</label>
		<input id="name" type="text" name="name" value="">
	</div>
	<?php if (isset($error_message['name'])) : ?>
            <p><?php echo $error_message['name']; ?>
        <?php endif; ?>
	<div>
		<label for="message">メッセージ</label>
		<textarea id="message" name="message"></textarea>
	</div>
	<?php if (isset($error_message['message'])) : ?>
            <p><?php echo $error_message['message']; ?>
        <?php endif; ?>
	<p>
	<input type="submit" name="btn_submit" value="書き込む">
	</p>
</form>
</p>

<hr>

<section>
<?php if( !empty($message_array) ){ ?>
<?php foreach( $message_array as $value ){ ?>
<article>
    <div class="info">
        <h2><?php echo $value['name']; ?></h2>
        <time><?php echo date('Y年m月d日 H:i', strtotime($value['date'])); ?></time>
    </div>
    <p><?php echo nl2br($value['message']); ?></p>
</article>
<?php } ?>
<?php } ?>
<hr>
</section>

<p>
<a href="admin.php">管理者ページ</a>
<a href="home.php">ホームに戻る</a>
</p>

</body>
</html>