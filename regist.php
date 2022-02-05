<?php

session_start();

// データベースの接続情報
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', 'kimurie0810');
define( 'DB_NAME', 'reccomend_system');

// 変数の初期化
$success_message = null;
$error_message = [];
$clean = array();


if( !empty($_POST['btn_regist']) ) {
	
	// アーティスト名の入力チェック
	if( !preg_match("^(\s|　)+$", $_POST['artist']) ) {
		$error_message['artist'] = 'アーティスト名を入力してください。';
	} else {
		$clean['artist'] = htmlspecialchars( $_POST['artist'], ENT_QUOTES);
	}
	
	// 曲名の入力チェック
	if( !preg_match("^(\s|　)+$", $_POST['title']) ) {
		$error_message['title'] = '曲名を入力してください。';
	} else {
		$clean['title'] = htmlspecialchars( $_POST['title'], ENT_QUOTES);
    }
    
    // URLの入力チェック
	if( empty($_POST['url']) ) {
		$error_message['url'] = 'MVのURLを入力してください。';
	} else {
		$clean['url'] = htmlspecialchars( $_POST['url'], ENT_QUOTES);
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
			
			// データを登録するSQL作成
			$sql = "INSERT INTO music_table (title,artist,url,excite, speed, positive,remain,happy,emotional,cry,
            spring,summer,winter,night,cheer,youth,love,heart,popular) 
            VALUES ( '$clean[title]','$clean[artist]','$clean[url]','$_POST[excite]','$_POST[speed]','$_POST[positive]','$_POST[remain]','$_POST[happy]',
            '$_POST[emotional]','$_POST[cry]','$_POST[spring]','$_POST[summer]','$_POST[winter]', '$_POST[night]', 
            '$_POST[cheer]','$_POST[youth]','$_POST[love]','$_POST[heart]','$_POST[popular]')";
			
			// データを登録
            $res = $mysqli->query($sql);
		
			if( $res ) {
			$success_message = '楽曲の登録に成功しました。';
			}

			// データベースの接続を閉じる
			$mysqli->close();
		}
	}else{
        $_SESSION = $error_message;
        header('Location: regist_form.php');
        return;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>登録画面 処理ページ</title>
</head>

<body>
<h1>登録画面　処理ページ</h1>

<?php if( !empty($success_message) ): ?>
    <p class="success_message"><?php echo $success_message; ?></p>
<?php endif; ?>

<?php if( !empty($error_message) ): ?>
	<ul class="error_message">
		<?php foreach( $error_message as $value ): ?>
			<li>・<?php echo $value; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

<a href="regist_form.php">楽曲登録を続ける</a>
<a href="home.php">ホームに戻る</a>

</body>
</html>