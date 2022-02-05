<?php

// セッションの開始
session_start();

$e = $_SESSION;

// セッションの中身をすべて削除
$_SESSION = array();

// セッションを破壊
session_destroy();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>登録画面</title>

</head>

<body>
<h1>楽曲を登録する</h1>    
<p class=explanaton>アーティスト名、曲名、MVのURLを入力してください</p>
    <form action="regist.php" method="post">
        <div>
            <label for="artist">アーティスト名</label>
			<input type="text" id="artist" name="artist">
			<?php if (isset($e['artist'])) : ?>
                <p><?php echo $e['artist']; ?>
            <?php endif; ?>
        </div>
        <div>
            <label for="title">曲名</label>
			<input type="text" id="title" name="title">
			<?php if (isset($e['title'])) : ?>
                <p><?php echo $e['title']; ?>
            <?php endif; ?>
        </div>
        <div>
            <label for="url">MVのURL</label>
			<input type="text" id="url" name="url">
			<?php if (isset($e['url'])) : ?>
                <p><?php echo $e['url']; ?>
            <?php endif; ?>
        </div>
    
    <hr>

 <div class="explanaton">各項目に当てはまるものをそれぞれ１つずつ選択してください</div><br>
 <div class="choices">当てはまる　どちらかといえば当てはまる/どちらでもない　当てはまらない</div><br>

<div　class="theme">盛り上がる</div>
	<input type="radio" name="excite" value="2">
	<input type="radio" name="excite" value="1">
	<input type="radio" name="excite" value="0">
<br>

<div　class="theme">疾走感</div>
	<input type="radio" name="speed" value="2">
	<input type="radio" name="speed" value="1">
	<input type="radio" name="speed" value="0">
<br>

<div　class="theme">前向き</div>
	<input type="radio" name="positive" value="2">
	<input type="radio" name="positive" value="1">
	<input type="radio" name="positive" value="0">
<br>

<div　class="theme">耳に残る</div>
	<input type="radio" name="remain" value="2">
	<input type="radio" name="remain" value="1">
	<input type="radio" name="remain" value="0">
<br>

<div　class="theme">幸せ</div>
	<input type="radio" name="happy" value="2">
	<input type="radio" name="happy" value="1">
	<input type="radio" name="happy" value="0">
<br>

<div　class="theme">エモい</div>
	<input type="radio" name="emotional" value="2">
	<input type="radio" name="emotional" value="1">
	<input type="radio" name="emotional" value="0">
<br>

<div　class="theme">泣ける</div>
	<input type="radio" name="cry" value="2">
	<input type="radio" name="cry" value="1">
	<input type="radio" name="cry" value="0">
<br>

<div　class="theme">春に聞きたい</div>
    <input type="radio" name="spring" value="2">
	<input type="radio" name="spring" value="1">
	<input type="radio" name="spring" value="0">
<br>

<div　class="theme">夏に聞きたい</div>
	<input type="radio" name="summer" value="2">
	<input type="radio" name="summer" value="1">
	<input type="radio" name="summer" value="0">
<br>

<div　class="theme">冬に聞きたい</div>
	<input type="radio" name="winter" value="2">
	<input type="radio" name="winter" value="1">
	<input type="radio" name="winter" value="0">
<br>

<div　class="theme">夜に聞きたい</div>
	<input type="radio" name="night" value="2">
	<input type="radio" name="night" value="1">
	<input type="radio" name="night" value="0">
<br>

<div　class="theme">応援ソング</div>
	<input type="radio" name="cheer" value="2">
	<input type="radio" name="cheer" value="1">
	<input type="radio" name="cheer" value="0">
<br>

<div　class="theme">青春ソング</div>
	<input type="radio" name="youth" value="2">
	<input type="radio" name="youth" value="1">
	<input type="radio" name="youth" value="0">
<br>

<div　class="theme">ラブソング</div>
	<input type="radio" name="love" value="2">
	<input type="radio" name="love" value="1">
	<input type="radio" name="love" value="0">
<br>

<div　class="theme">失恋ソング</div>
	<input type="radio" name="heart" value="2">
	<input type="radio" name="heart" value="1">
	<input type="radio" name="heart" value="0">
<br>

<div　class="theme">ヒットソング</div>
	<input type="radio" name="popular" value="2">
	<input type="radio" name="popular" value="1">
	<input type="radio" name="popular" value="0">

 <p>
    <input type="reset" value="リセット">
	<input type="submit" name="btn_regist" value="登録する">
</p>
    

</form>

<p><a href="home.php">ホームに戻る</a></p>

</body>
</html>