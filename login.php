<?php

// セッションの開始
session_start();

// データベースの接続情報
define( 'DB_HOST', 'localhost');
define( 'DB_USER', 'root');
define( 'DB_PASS', 'kimurie0810');
define( 'DB_NAME', 'reccomend_system');

// 変数の初期化
$error_message = [];
$username = $_POST['username'];
$password=$_POST['password'];


if( !empty($_POST['btn_login']) ) {

    // ユーザ名の入力チェック
    if( !preg_replace("/( |　)/", "", $username ) ) {
        $error_message['username'] = 'ユーザ名を入力してください。';
    }
    // パスワードの入力チェック
    if( empty ($password) ) {
        $error_message['password'] = 'パスワードを入力してください。';
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
			
			// 入力したユーザ名がDB上にあるかをチェック
			$sql = "SELECT * FROM users WHERE username = '$username'";
            
			// データを登録
            $res = $mysqli->query($sql);

            if( $res ) {
                $member = $res->fetch_assoc();
                }
		
			// データベースの接続を閉じる
			$mysqli->close();

            // 指定したハッシュがパスワードにマッチしているかチェック
            if ( password_verify($password,$member['password']) ){
                //DBのユーザー情報をセッションに保存
                $_SESSION['user_id'] = $member['user_id'];
                $_SESSION['name'] = $member['name'];
                header('Location: home.php');
                exit;
            }else{
                $error_message['false'] = 'ユーザ名もしくはパスワードが間違っています。';
                $_SESSION = $error_message;
                header('Location: login_form.php');
                exit;
            }
        }
    }else{
        $_SESSION = $error_message;
        header('Location: login_form.php');
        exit;
    }
}
?>

