<?php
$db = new mysqli('localhost:8889', 'root', 'root', 'mydb');
?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SimpleTodoApp</title>
</head>

<body>
    <form method="post">
        <h1>Simple Todo App</h1>
        <input type="text" name="list">
        <button type="submit">保存</button>
    </form>


    <h2>保存されたTodo</h2>
    <?php
    $list = filter_input(INPUT_POST, 'list', FILTER_SANITIZE_SPECIAL_CHARS);
    if ($list !== null) {
        $stmt = $db->prepare('insert into lists(list) values(?)');
        $stmt->bind_param('s', $list);
        $ret = $stmt->execute();
    }
    ?>

    <?php $lists = $db->query('select * from lists order by id desc'); ?>
    <?php while ($list = $lists->fetch_assoc()) : ?>
        <form method="post" action="update_list.php">
            <input type="text" name="list_item" value="<?php echo htmlspecialchars($list['list'] ?? ''); ?>">
            <input type="hidden" name="list_id" value="<?php echo $list['id']; ?>">
            <input type="submit" value="編集">
        </form>
    <?php endwhile; ?>
</body>

</html>