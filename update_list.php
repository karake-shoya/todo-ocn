<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $list_id = $_POST['list_id'];
    $list_item = $_POST['list_item'];

    // データベースへの接続情報（実際の接続情報を使用してください）
    $db_host = 'localhost';
    $db_port = 8889;
    $db_user = 'root';
    $db_pass = 'root';
    $db_name = 'mydb';

    $db = new mysqli($db_host, $db_user, $db_pass, $db_name, $db_port);

    // 接続エラーをチェック
    if ($db->connect_error) {
        die("データベースに接続できません: " . $db->connect_error);
    }

    // SQLのUPDATE文を作成
    $sql = "UPDATE `lists` SET list = ? WHERE id = ?";

    // プリペアドステートメントを作成
    $stmt = $db->prepare($sql);

    if (!$stmt) {
        die("プリペアドステートメントの作成に失敗しました: " . $db->error);
    }

    // プリペアドステートメントに値をバインド
    if (!$stmt->bind_param("si", $list_item, $list_id)) {
        die("バインドに失敗しました: " . $stmt->error);
    }

    // クエリを実行
    if ($stmt->execute()) {
        // 更新が成功した場合の処理
        header('Location: index.php');
    } else {
        // エラーが発生した場合の処理
        echo "更新に失敗しました: " . $db->error;
    }

    // プリペアドステートメントをクローズ
    $stmt->close();

    // データベース接続をクローズ
    $db->close();
}
