<?php
include_once "./api/base.php";

$file = find("upload", $_GET['id']);
// dd($file);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>編輯檔案</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./my_style.css">
</head>

<body>
    <h1 class="header">編輯檔案</h1>
    <!----建立你的表單及設定編碼----->
    <form action="./api/edit.php" method="post" enctype="multipart/form-data">
        <ul>
            <li>Description : <input type="text" name="description" value="<?= $file['description'] ?>"></li>
            <li>Type : <?= $file['type'] ?></li>
            <li>Size : <?= floor($file['size'] / 1024) . "kb" ?></li>
            <li><img src="./upload/<?= $file['file_name'] ?>" width="10%"></li>
            <li>File : <input type="file" name="file_name"></li>
            <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
            <li><input type="submit" value="Revise"></li>
            </li>
        </ul>
    </form>

</body>

</html>