<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>掲示板 編集画面</title>
</head>
<body>
    <h1>掲示板 編集画面</h1>
    <?php
    // フォームから送信された場合の処理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // csvファイルを読み込み、編集する記事の行を上書きする
        $rows = file_get_contents('bbdata.csv');
        $row = explode("\n",$rows);
        $id = $_POST['id'];
        $id_row = explode(",",$row[$id]);
        $all = count($row);//記事の個数
        $newdata = $id.",".$id_row[1].",".$_POST['name'].",".$_POST['comment'];
        $file = 'bbdata.csv';
        $line_number = $id; // 書き込みたい行の行番号
        if (($handle = fopen($file, "r+")) !== FALSE) {
            $i = 0;
            while (true) {
                $i++;
                if ($i == $line_number) {
                    $data = $newdata;
                    $row[$id] = $newdata;
                    break;
                }
                
            }
            ftruncate($handle, 0); // ファイルサイズを0にリセット
            fwrite($handle, $row[0]);
            for ($s=1; $s<$all ;$s++) {
                fwrite($handle, "\n".$row[$s]);
            }
            fclose($handle);
        }
        echo "編集が完了しました。トップページに戻ります。<br>";
        echo '<meta http-equiv="refresh" content="2;URL=index.php">';
        exit;
    }

    // パラメータのIDを受け取る
    if (!isset($_GET['id'])) {
        echo "トップページに戻ります。<br>";
        echo '<ta http-equiv="refresh" content="2;URL=index.php">';
        exit;
    }
    $id = intval($_GET['id']);
    // csvファイルから編集対象の記事を読み込む
    $rows = array_map('str_getcsv', file('bbdata.csv'));

    // 編集用のフォームを表示
    ?>
    <form method="post">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        投稿者名: <input type="text" name="name" value="<?php echo htmlspecialchars($rows[$id][2]) ?>"><br>
        投稿コメント: <br>
        <textarea name="comment" cols="30" rows="5"><?php echo htmlspecialchars($rows[$id][3]) ?></textarea><br>
        <input type="submit" value="編集する">
        <input type="button" value="キャンセル" onclick="location.href='index.php'">
    </form>
</body>
</html>

