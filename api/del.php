<?php
include_once "./base.php";

$file=find("upload",$_GET['id']);
// dd($file);

// 刪除檔案 unlink( "路徑" ,  );
unlink("../upload/".$file['file_name']);

// 刪除資料庫
del("upload",$_GET['id']);

header("location:../upload.php?status=del_success");

?>