<?php

// セッションの開始
session_start();


$e = $_SESSION;

// セッションの中身をすべて削除
//$_SESSION = array();

// セッションを破壊
//session_destroy();

?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title>検索画面</title>
</head>

<body>
    <h1>楽曲を検索する</h1>
<p>探したい曲のテーマを選択してください。（複数選択可能）</p>

<?php if (isset($e['choice'])) : ?>
    <p><?php echo $e['choice']; ?>
<?php endif; ?>

<form  action="search.php" method="post">
	<div>
		<label for="excite">
        <input id="excite" type="checkbox" name="excite" value="1">盛り上がる</label><br>
       
        <label for="speed">
        <input id="speed" type="checkbox" name="speed" value="1">疾走感</label><br>
        
        <label for="positive">
        <input id="positive" type="checkbox" name="positive" value="1">前向き</label><br>
       
        <label for="remain">
        <input id="remain" type="checkbox" name="remain" value="1">耳に残る</label><br>
       
        <label for="happy">
        <input id="happy" type="checkbox" name="happy" value="1">幸せ</label><br>
       
        <label for="emotional">
        <input id="emotional" type="checkbox" name="emotional" value="1">エモい</label><br>
       
        <label for="cry">
        <input id="cry" type="checkbox" name="cry" value="1">泣ける</label><br>
       
        <label for="spring">
        <input id="spring" type="checkbox" name="spring" value="1">春に聞きたい</label><br>
       
        <label for="summer">
        <input id="summer" type="checkbox" name="summer" value="1">夏に聞きたい</label><br>

        <label for="winter">
            <input id="winter" type="checkbox" name="winter" value="1">冬に聞きたい</label><br>
      
        <label for="night">
        <input id="night" type="checkbox" name="night" value="1">夜に聞きたい</label><br>
      
        <label for="cheer">
        <input id="cheer" type="checkbox" name="cheer" value="1">応援ソング</label><br>
      
        <label for="youth">
        <input id="youth" type="checkbox" name="youth" value="1">青春ソング</label><br>

        <label for="love">
        <input id="love" type="checkbox" name="love" value="1">ラブソング</label><br>
        
        <label for="heart">
        <input id="heart" type="checkbox" name="heart" value="1">失恋ソング</label><br>
       
        <label for="popular">
        <input id="popular" type="checkbox" name="popular" value="1">ヒットソング</label><br>
	</div>
    
    <input type="reset" value="リセット">
	<input type="submit" name="btn_search" value="検索する">
</form>

    <p><a href="home.php">ホームに戻る</a></p>

</body>
</html>