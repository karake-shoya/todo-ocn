<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // POSTリクエストを処理する

    // データベース接続
    $db = new mysqli('localhost:8889', 'root', 'root', 'mydb');

    // リクエストからlist_idを取得
    $list_id = $_POST['list_id'];

    // SQLクエリを作成して実行
    $stmt = $db->prepare('DELETE FROM lists WHERE id = ?');
    $stmt->bind_param('i', $list_id); // 'i' は整数を示す
    $result = $stmt->execute();

    if ($result) {
        // 削除成功
        header("Location: index.php"); // ページをリダイレクトするか、適切な処理を行う
        exit();
    } else {
        // 削除失敗
        echo "削除に失敗しました";
    }

    // データベース接続を閉じる
    $db->close();
}
