<?php

// セッションの開始
session_start();

// DB接続情報
require("db.php");

// タイムゾーン設定
date_default_timezone_set('Asia/Tokyo');

// 変数の初期化
$message_id = null;
$mysqli = null;
$sql = null;
$res = null;
$error_message = array();
$message_data = array();

// 未ログイン状態のとき
if( empty($_SESSION['admin_login']) || $_SESSION['admin_login'] !== true ) {
	header("Location: ./admin.php");
}

// ログイン状態のとき
if( !empty($_GET['message_id']) && empty($_POST['message_id']) ) {
	
	$message_id = (int)htmlspecialchars($_GET['message_id'], ENT_QUOTES);
	
	// データベースに接続
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データベースの接続に失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
	} else {
	
		// 該当する投稿を取得するSQL作成
		$sql = "SELECT * FROM board WHERE id = $message_id";

		// データの登録
		$res = $mysqli->query($sql);
		
		if( $res ) {
			$message_data = $res->fetch_assoc();
		} else {
		
			header("Location: ./admin.php");
		}
		
		// データベースの接続を閉じる
		$mysqli->close();
	}

}elseif( !empty($_POST['message_id']) ) {
    $message_id = (int)htmlspecialchars( $_POST['message_id'], ENT_QUOTES);
	
	if( empty($_POST['name']) ) {
		$error_message[] = '表示名を入力してください。';
	} else {
		$message_data['name'] = htmlspecialchars($_POST['name'], ENT_QUOTES);
	}
	
	if( empty($_POST['message']) ) {
		$error_message[] = 'メッセージを入力してください。';
	} else {
		$message_data['message'] = htmlspecialchars($_POST['message'], ENT_QUOTES);
	}

	if( empty($error_message) ) {
	
		// データベースに接続
		$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
		
		// 接続エラーの確認
		if( $mysqli->connect_errno ) {
			$error_message[] = 'データベースの接続に失敗しました。 エラー番号 ' . $mysqli->connect_errno . ' : ' . $mysqli->connect_error;
		} else {

			// 該当する投稿の内容を更新するSQL作成
			$sql = "UPDATE board set name = '$message_data[name]', message= '$message_data[message]' WHERE id =  $message_id";
			
			// データの登録
			$res = $mysqli->query($sql);
		}
		
		// データベースの接続を閉じる
		$mysqli->close();
		
		if( $res ) {
			header("Location: ./admin.php");
		}
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>編集画面</title>

</head>

<body>
    <h1>投稿の編集</h1>

<?php if( !empty($error_message) ): ?>
	<ul class="error_message">
		<?php foreach( $error_message as $value ): ?>
			<li>・<?php echo $value; ?></li>
		<?php endforeach; ?>
	</ul>
<?php endif; ?>

 <form method="post">
    <div>
        <label for="name">名前</label>
		 <input id="name" type="text" name="name" value="<?php if( 
        !empty($message_data['name']) ){ echo $message_data['name']; } ?>">
     </div>
    <div>
        <label for="message">メッセージ</label>
        <textarea id="message" name="message"><?php if( !empty($message_data['message']) )
        { echo $message_data['message']; } ?></textarea>
    </div>
    <p><input type="submit" name="btn_submit" value="更新"></p>
    <input type="hidden" name="message_id" value="<?php echo $message_data['id']; ?>">
	<a class="btn_cancel" href="admin.php">キャンセル</a>
  </form>

</body>
</html>