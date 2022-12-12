<?php
include_once "./base.php";

$file = find("upload", $_POST['id']);
dd($file);

echo "<pre>";
print_r($_FILES['file_name']);
print_r($_POST['description']);
echo "</pre>";

// 有重新上傳檔案
if ($_FILES['file_name']['error'] == 0) {
    // File
    // 將就的檔案移到暫存資料夾，定時清除
    rename("../upload/{$file['file_name']}", "../temporary_file/{$file['file_name']}");

    $file_str_array = explode(".", $_FILES['file_name']['name']);
    $sub = array_pop($file_str_array);
    $file_name = date("Ymdhis") . "." . $sub;
    echo $file_name;

    move_uploaded_file($_FILES['file_name']['tmp_name'], "../upload/" . $file_name);

    // 更新
    update('upload', [
        'file_name' => $file_name,
        'size' => $_FILES['file_name']['size'],
        'type' => $_FILES['file_name']['type'],
        'description' => $_POST['description']
    ], $_POST['id']);
} else {
    // 沒有重新上傳檔案
    update('upload', ['description' => $_POST['description']], $_POST['id']);
}
header("location:../upload.php?status=edit_success");
