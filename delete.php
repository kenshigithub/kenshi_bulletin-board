<?php
// CSVファイルのパス
$file_path = 'bbdata.csv';

$rows = file_get_contents($file_path);
$row = explode("\n",$rows);
// フォームから送信された場合の処理
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 確認画面から「はい」が押された場合、記事を削除する
    if (isset($_POST['delete']) && $_POST['delete'] === "はい") {
        // CSVファイルを読み込み、削除する記事を除いた記事一覧を作成する
        $index = $_POST['id'];
        echo $index;
        $id_row = explode(",",$row[$index]);
        print_r ($id_row); 
        $all = count($row);
        echo $all;
        $handle = fopen($file_path, "r+");
        ftruncate($handle, 0); // ファイルサイズを0にリセット
        fwrite($handle, $row[0]);
        for ($s=1; $s<$all ;$s++) {
            if($s==$index){
                continue;
            }
            elseif($s>$index){
                $p_row = explode(",",$row[$s]);
                $row[$s] = ($p_row[0]-1).","."$p_row[1]".","."$p_row[2]".","."$p_row[3]";
            }
            fwrite($handle, "\n".$row[$s]);
        }
        fclose($handle);

        // トップページにリダイレクトする
        header('Location: index.php');
        exit;
    }
} else {
    // 削除する記事のインデックスを取得
    $index = intval($_GET['id']);
    // CSVファイルを読み込み、削除する記事の情報を取得する
    $id_row = $row[$index];
    $delete_data = explode(",",$id_row);
    // 編集用のフォームを表示
    echo '<p>以下の記事を削除しますか？</p>';
    echo '<ul>';
    echo '<li>投稿日時： '.htmlspecialchars($delete_data[1], ENT_QUOTES, 'UTF-8').'</li>';
    echo '<li>投稿者：   '.htmlspecialchars($delete_data[2], ENT_QUOTES, 'UTF-8').'</li>';
    echo '<li>コメント： '.nl2br(htmlspecialchars($delete_data[3], ENT_QUOTES, 'UTF-8')).'</li>';
    echo '</ul>';
    echo '<form action="delete.php" method="post">';
    echo '<input type="hidden" name="id" value=' . $index . '>';
    echo '<input type="submit" name="delete" value="はい">';
    echo '</form>';
    echo '<form action="delete.php" method="get">';
    echo '<input type="hidden" name="id" value=' . $index . '>';
    echo '<input type="button" value="いいえ" onclick="location.href=\'index.php\'">';
    echo '</form>';

}
?>