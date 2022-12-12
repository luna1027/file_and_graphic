<?php
include_once "base.php";

if ($_FILES['file_name']['error'] == 0) {
    // echo md5(791027) . "<br>";
    // echo md5("lunalee"). "<br>";

    // Description
    $description = $_POST['description'];
    echo "Description : " . $description;

    echo "<pre>";
    print_r($_FILES['file_name']);
    echo "</pre>";
    // File
    $file_str_array = explode(".", $_FILES['file_name']['name']);
    $sub = array_pop($file_str_array);
    $file_name = date("Ymdhis") . "." . $sub;
    echo $file_name;

    // move_uploaded_file($_FILES['file_name']['tmp_name'], "../upload/" . $_FILES['file_name']['name']);
    move_uploaded_file($_FILES['file_name']['tmp_name'], "../upload/" . $file_name);
    insert('upload', [
        'description' => $_POST['description'],
        'size' => $_FILES['file_name']['size'],
        'type' => $_FILES['file_name']['type'],
        'file_name' => $file_name
    ]);

    header("location:../upload.php?upload=success");
} else {
    echo "<div style='color:red;'>上傳失敗，請檢查檔案格式是否正確，及網路連線是否穩定，若狀況無法解決請聯繫網站管理員，謝謝。</div>";
}
