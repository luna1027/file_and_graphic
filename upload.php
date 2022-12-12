<?php

/**
 * 1.建立表單
 * 2.建立處理檔案程式
 * 3.搬移檔案
 * 4.顯示檔案列表
 */

include_once "./api/base.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>檔案上傳</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="./my_style.css">
</head>

<body>
    <h1 class="header">檔案上傳練習</h1>
    <!----建立你的表單及設定編碼----->
    <?php
    if (isset($_GET['status'])) {
        switch ($_GET['status']) {
            case 'upload_success':
                echo "<div class='status'>上傳成功</div>";
                break;
            case 'edit_success':
                echo "<div class='status'>編輯成功</div>";
                break;
            case 'del_success':
                echo "<div class='status'>刪除成功</div>";
                break;
            default:
                break;
        }
    }

    ?>
    <form action="./api/upload.php" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                Description : <input type="textarea" name="description">
                <input type="file" name="file_name">
                <input type="submit" value="Submit">
            </li>
        </ul>
    </form>

    <!----建立一個連結來查看上傳後的圖檔---->
    <?php
    $files = all('upload');
    if (count($files) > 0) {
        echo "<ul class='list'>";
        echo "<li class='list-item'>";
        echo "<div>縮圖</div>";
        echo "<div>檔案描述</div>";
        echo "<div>名稱</div>";
        echo "<div>大小</div>";
        echo "<div>類型</div>";
        echo "<div></div>";
        echo "</li>";
        foreach ($files as $file) {
            echo "<li class='list-item list-item-hover'>";
            echo "<div>";
            if (is_image($file['type'])) {
                // echo "<div style='background-image: url(./upload/{$file['file_name']});'>";
                echo "<img src='./upload/{$file['file_name']}'>";
            } else {
                $icon = dummy_icon($file['type']);
                echo "<img src='./material/{$icon}'>";
            }
            echo "</div>";
            echo "<div>";
            echo $file['description'];
            echo "</div>";
            echo "<div>";
            echo $file['file_name'];
            echo "</div>";
            echo "<div>";
            echo floor($file['size'] / 1024) . "kb";
            echo "</div>";
            echo "<div>";
            echo $file['type'];
            echo "</div>";
            echo "<div>";
            echo "<a class='edit_btn' href='./edit_form.php?id={$file['id']}'>EDIT</a>";
            echo "<a class='del_btn' href='./api/del.php?id={$file['id']}'>DEL</a>";
            echo "</div>";
            echo "</li>";
        }
        echo "</ul>";
    } else {
        echo "目前尚無上傳資料";
    }

    ?>
</body>

</html>