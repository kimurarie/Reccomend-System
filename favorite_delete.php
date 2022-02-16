<?php

// セッションの開始
session_start();

// DB接続情報
require("db.php");

// GETメソッドで楽曲IDを取得したとき
if( isset($_GET['id']) ) {
    $id = $_GET['id'];
	
	// データベースに接続
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
	
	// 接続エラーの確認
	if( $mysqli->connect_errno ) {
		$error_message[] = 'データベースの接続に失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
	} else {
	
		// 該当楽曲をお気に入り一覧から削除するSQL作成
		$sql = "DELETE FROM favorite WHERE id = $id";

		// データの登録
        $res = $mysqli->query($sql);
        
		// データベースの接続を閉じる
        $mysqli->close();
        
        header('Location: mypage.php');
        exit;
	}
}

?>

