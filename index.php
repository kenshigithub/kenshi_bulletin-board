<!DOCTYPE html>
<html>
<head>
	<title>掲示板トップ</title>
</head>
<body>
	<h1>掲示板トップ</h1>
	<a href="new.php">新規作成</a>
	<?php
	// CSVファイルの読み込み
	$csv = array_map('str_getcsv', file('bbdata.csv'));
    // 投稿がない場合のメッセージ
	if (count($csv) == 1) {
		echo "投稿はありません。";
	} else {
		// 投稿がある場合の表示
		// 日付の新しい順に並び替え
        array_multisort(array_column($csv, 1),SORT_DESC,$csv);
        echo "<table>";
		echo "<tr><th>日付</th><th>投稿者</th><th>コメント</th><th></th><th></th></tr>";
		// 投稿を1行ずつ表示
		for ($i = 1; $i < count($csv); $i++) {
            echo "<tr>";
            for($j = 1; $j <4; $j++){
                /*$data = explode(",", $csv[$i][0]);*/
			    echo "<td>".$csv[$i][$j]."</td>";
            }
            echo '<td><a href="edit.php?id='.$csv[$i][0].'">編集</a></td>';
            echo '<td><a href="delete.php?id='.$csv[$i][0].'">削除</a></td>';
            echo "</tr>";
			
		}
		echo "</table>";
	}
	?>
</body>
</html>

