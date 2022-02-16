<?php

// セッションの開始
session_start();

// DB接続情報
require("db.php");

// 変数の初期化
$error_message = [];
$music_array = array();

if(isset($_SESSION['name'])){
$name=$_SESSION['name'];
}

if(isset($_POST['excite'])) $excite = $_POST['excite']; else $excite=0;
if(isset($_POST['speed'])) $speed = $_POST['speed']; else $speed=0;
if(isset($_POST['positive'])) $positive = $_POST['positive']; else $positive=0;
if(isset($_POST['remain'])) $remain = $_POST['remain']; else $remain=0;
if(isset($_POST['happy'])) $happy = $_POST['happy']; else $happy=0;
if(isset($_POST['emotional'])) $emotional = $_POST['emotional']; else $emotional=0;
if(isset($_POST['cry'])) $cry = $_POST['cry']; else $cry=0;
if(isset($_POST['spring'])) $spring = $_POST['spring']; else $spring=0;
if(isset($_POST['summer'])) $summer = $_POST['summer']; else $summer=0;
if(isset($_POST['winter'])) $winter = $_POST['winter']; else $winter=0;
if(isset($_POST['night'])) $night = $_POST['night']; else $night=0;
if(isset($_POST['cheer'])) $cheer = $_POST['cheer']; else $cheer=0;
if(isset($_POST['youth'])) $youth = $_POST['youth']; else $youth=0;
if(isset($_POST['love'])) $love = $_POST['love']; else $love=0;
if(isset($_POST['heart'])) $heart = $_POST['heart']; else $heart=0;
if(isset($_POST['popular'])) $popular = $_POST['popular']; else $popular=0;

$theme=$excite+$speed+$positive+$remain+$happy+$emotional+$cry+$spring+$summer+$winter+
$night+$cheer+$youth+$love+$heart+$popular;
$flag = 0;

if( !empty($_POST['btn_search']) ) {

	if( $theme !=0 ){

	// データベースに接続
	$mysqli = new mysqli( DB_HOST, DB_USER, DB_PASS, DB_NAME);
			
		// 接続エラーの確認
		if( $mysqli->connect_errno ) {
		$error_message[] = '書き込みに失敗しました。 エラー番号 '.$mysqli->connect_errno.' : '.$mysqli->connect_error;
		} else {

			// 文字コード設定
			$mysqli->set_charset('utf8');
			
			$sql_A = "SELECT id,artist,title,url,";
			
			// チェックボックスの判定
			if( $excite == 1 ){
			$sql_B = "excite";
			$flag = 1;
			}
			if( $speed == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+speed";
				}else{
				$sql_B = "speed";
				$flag = 1;
				}
			}
			if( $positive == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+positive";
				}else{
				$sql_B = "positive";
				$flag = 1;
				}
			}
			if( $remain == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+remain";
				}else{
					$sql_B = "remain";
					$flag = 1;
				}	
			}
			if( $happy == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+happy";
				}else{
				$sql_B = "happy";
				$flag = 1;
				}
			}
			if( $emotional == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+emotional";
				}else{
				$sql_B = "emotional";
				$flag = 1;
				}
			}
			if( $cry == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+cry";
				}else{
				$sql_B = "cry";
				$flag = 1;
				}
			}
			if( $spring == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+spring";
				}else{
				$sql_B = "spring";
				$flag = 1;
				}
			}
			if( $summer == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+summer";
				}else{
				$sql_B = "summer";
				$flag = 1;
				}
			}
			if( $winter == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+winter";
				}else{
				$sql_B = "winter";
				$flag = 1;
				}
			}
			if( $night == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+night";
				}else{
				$sql_B = "night";
				$flag = 1;
				}
			}
			if( $cheer == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+cheer";
				}else{
				$sql_B = "cheer";
				$flag = 1;
				}
			}
			if( $youth == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+youth";
				}else{
				$sql_B = "youth";
				$flag = 1;
				}
			}
			if( $love == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+love";
				}else{
				$sql_B = "love";
				$flag = 1;
				}
			}
			if( $heart == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+heart";
				}else{
				$sql_B = "heart";
				$flag = 1;
				}
			}
			if( $popular == 1 ){
				if($flag == 1){
					$sql_B = $sql_B."+popular";
				}else{
				$sql_B = "popular";
				$flag = 1;
				}
			}
			
			// スコアの最大値を求めるSQL作成
			$sql_max = "SELECT MAX($sql_B) AS max FROM music_table;";
			$res = $mysqli->query($sql_max);
			
			$val = $res->fetch_assoc();
			$max = $val["max"];

			$sql_C =" AS score FROM music_table WHERE ".$sql_B."=".$max;
			
			// スコアが最大値であるレコードを抽出するSQL作成
			$sql = $sql_A.$sql_B.$sql_C;
			$res = $mysqli->query($sql);
			if( $res ) {
			$music_array = $res->fetch_all(MYSQLI_ASSOC);
			}

			// レコード数を取得するSQL作成
			$row = mysqli_num_rows($res);
			
			// 1～rowまでの範囲で乱数生成
			$min = 1;
			$recommend = mt_rand($min,$row);

			// データベースの接続を閉じる
			$mysqli->close();	
		}
	}else{
	$error_message["choice"] = '1つ以上選択してください。';
	$_SESSION = $error_message;
    header('Location: search_form.php');
    return;
	}
}
	
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>検索画面 処理ページ</title>
</head>

<body align="center">
<h1>検索結果</h1>

<section>

<?php if( !empty($music_array) ){ ?>
<?php 
$count = 0;
foreach( $music_array as $value ){ 
	$count++;
	if($count == $recommend){	
	$title = $value['title'];
	$_SESSION['title'] = $title;	
	?>

	<article>
	<?php if (isset($name)) : ?>
		<h3><?php echo $name; ?>さんにおすすめ！</h3>
	<?php endif; ?>
	<?php if (!isset($name)) : ?>
		<h3>あなたにおすすめ！</h3>
	<?php endif; ?>
	
	<div class="info">
         <p><?php echo $value['title']; ?> / <?php echo $value['artist']; ?></p>
		<iframe width="560" height="315" src=<?=$value['url']?> frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
    </div>
	</article>
<?php }

} ?>
<?php } ?>

</section>

<form  action="mypage.php" method="post">
	<p>
	<input type="submit" name="btn_favorite" value="お気に入り">
	</p>
</form>

<p><a href="search_form.php">楽曲検索を続ける</a>
<a href="home.php">ホームに戻る</a></p>

</body>
</html>