<!DOCTYPE html>
<html>
<head>
	<title>新規投稿</title>
</head>
<body>
<h1>新規投稿</h1>
	<form action="new.php" method="post">
		<p>名前：<input type="text" name="name" required></p>
		<p>コメント：<textarea name="comment" rows="4" cols="40" required></textarea></p>
		<input type="submit" value="投稿する">
		<input type="button" value="キャンセル" onclick="location.href='index.php'">
	</form>
	<?php
	// 新規投稿の処理
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		// CSVファイルの読み込み
		$csv = array_map('str_getcsv', file('bbdata.csv'));
		// 投稿IDを生成
		$id = count($csv);
		// 投稿日付を生成
		date_default_timezone_set('Asia/Tokyo');
		$now = date("Y/m/d H:i:s");
		// 新規投稿データの作成
		$newdata = "\n".$id.",".$now.",".$_POST["name"].",".$_POST["comment"];
        // CSVファイルへの書き込み
	    $file = fopen('bbdata.csv', 'a');
	    fwrite($file, $newdata);
	    fclose($file);
	
	    // トップページへの遷移
	    header('Location: index.php');
	    exit;
    }
   ?>
</body>
</html>
  
        
        
        
        