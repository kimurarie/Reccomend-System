<?php

// セッションの開始
session_start();

// DB接続情報
require("db.php");

// 変数の初期化
$success_message = null;
$error_message = [];
$clean = array();
$username = $_POST['username'];

if( !empty($_POST['btn_submit']) ) {
	
	// 名前の入力チェック
	if( !preg_replace("/( |　)/", "", $_POST['name'] ) )  {
		$error_message['name'] = '名前を入力してください。';
    }
	// ユーザ名の入力、かぶりチェック
	if( empty($_POST['username']) ) {
		$error_message['username'] = 'ユーザ名を入力してください。';
    }else{

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

            if( (!empty ($member) ) AND ($member['username'] == $username) ){
            $error_message['username'] = 'このユーザ名はすでに使われています。';
            }elseif(!preg_match("/^[a-zA-Z0-9]+$/", $username)){
                $error_message['match'] = 'ユーザ名は半角英数字で入力してください。';
            }
        }
    }
    // パスワードの入力チェック
    $password=filter_input(INPUT_POST,'password');
    // 正規表現
    if(!preg_match("/\A(?=.*?[a-z])(?=.*?\d)[a-z\d]{8,}+\z/i",$password)){
        $error_message['password'] = 'パスワードは半角英数字混在で、8文字以上にしてください。';
    }
    // パスワード(確認用)の入力チェック
	$password_conf=filter_input(INPUT_POST,'password_conf');
    if($password !== $password_conf){
        $error_message['password_conf'] = '確認用パスワードが異なっています。';
    }elseif(empty($_POST['password_conf'])){
        $error_message['password_conf_empty'] = '確認用パスワードを入力してください。';
	}else{
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    }

	if( empty($error_message) ) {
			
        // データを登録するSQL作成
        $sql = "INSERT INTO users (name,username,password) VALUES ( '$_POST[name]','$_POST[username]','$password')";
                
        // データを登録
        $res = $mysqli->query($sql);
            
        // データベースの接続を閉じる
        $mysqli->close();
    
	}else{
        $_SESSION = $error_message;
        header('Location: signup_form.php');
        return;
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>新規登録完了画面</title>
</head>
<body>

<p>新規登録が完了しました。</p>

<p><a href="login_form.php">ログイン画面へ</a></p>
</body>
</html>