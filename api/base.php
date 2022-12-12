<?php
// 本地端設定
$dsn = "mysql:host=localhost;charset=utf8;dbname=file";
$pdo = new PDO($dsn, 'root', '');

date_default_timezone_set("Asia/Taipei");

// 印出陣列
function dd($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

/* 
// pram table - 資料表名稱
// pram arg[0] - WHERE 條件，或 sql 字串
// pram arg[1] - order by LIMIT 之類的 sql 字串
*/

// 給定資料表名後，會回傳整個資料表的資料
function all($table, ...$args)
{
    global $pdo;
    $sql = "SELECT * FROM `$table` ";

    // 判斷是否有 $args[0] 
    if (isset($args[0])) {
        // 判斷 $args[0] 裡面是 WHERE條件 或 字串
        if (is_array($args[0])) {
            // 是陣列 ['acc' => 'mark','pw' => '1234'];
            foreach ($args[0] as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            // dd($tmp);
            $sql = $sql . " WHERE " . join(" AND ", $tmp);
        } else {
            // 是字串
            $sql = $sql . $args[0];
        }
    }

    // 判斷是否有 $args[1] 
    if (isset($args[1])) {
        $sql = $sql . $args[1];
    }

    // echo $sql;
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

// 傳回指定id的資料
function find($table, $id)
{
    global $pdo;
    $sql = "SELECT * FROM `$table` ";

    if (is_array($id)) {
        // 是陣列 ['acc' => 'mark','pw' => '1234'];
        foreach ($id as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }
        // dd($tmp);
        $sql = $sql . " WHERE " . join(" OR ", $tmp);
    } else {
        $sql = $sql . " WHERE `id`='$id'";
    }

    // echo $sql;
    return $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
}

// 給定資料表的條件，去更新相應的資料
function update($table, $set, ...$args)
{
    global $pdo;
    $sql = " UPDATE `$table` SET ";

    // 更新內容
    if (is_array($set)) {
        foreach ($set as $key => $value) {
            $tmp[] = "`$key`='$value'";
        }
        $sql = $sql  . join(" , ", $tmp);
    } else {
        echo "請以陣列形式提供資料";
    }
    // echo $sql;

    // 可有可無的條件
    if (isset($args[0])) {
        // dd($args);
        // 判斷 $args[0] 裡面是 WHERE條件 或 字串
        if (is_array($args[0])) {
            $tmp = [];
            foreach ($args[0] as $key => $value) {
                $tmp[] = "`$key`='$value'";
                // dd($tmp);
                // dd($args[0]);
            }
            $sql = $sql . " WHERE " . join(" AND ", $tmp);
        } 
        // elseif (is_numeric($args[0])) {
        //     $sql = $sql . " LIMIT " . $args[0];
        // } 
        else {
            // 是字串
            $sql=$sql . " WHERE `id`='{$args[0]}'";
        }
    }
    // echo "請打清楚點";

    // echo $sql;
    return $pdo->exec($sql);
}

// 給定資料內容後，會去新增資料到資料表
function insert($table, $insert)
{
    global $pdo;
    $sql = "INSERT INTO `$table` ";

    if (is_array($insert)) {
        $keys = [];
        $values = [];
        foreach ($insert as $key => $value) {
            $keys[] = "`$key`";
            $values[] = "'$value'";
        }
        $sql = $sql . "(" . join(",", $keys) . ") VALUES (" . (join(",", $values)) . ")";
    } else {
        $sql = $sql . $insert[0];
    }
    // echo $sql;
    return $pdo->exec($sql);
}

// 給定條件後，會去刪除指定的資料
function del($table, ...$args)
{
    global $pdo;
    $sql = "DELETE FROM `$table` ";

    if (isset($args)) {
        if (is_array($args[0])) {
            $tmp = [];
            foreach ($args[0] as $key => $value) {
                $tmp[] = "`$key`='$value'";
            }
            $sql = $sql . " WHERE " . join(" AND ", $tmp);
        } 
        // elseif (is_numeric($args[0])) {
        //     print_r($args[0]);
        //     $sql = $sql . " LIMIT " . $args[0];
        //     // echo $sql;
        // } 
        else {
            // 是字串
            $sql = $sql . " WHERE `id`='{$args[0]}'";
        }
    }
    // echo $sql;
    return $pdo->exec($sql);
}
?>

<!-- <h3>q()-萬用自訂函式條件</h3> -->
<!-- <h5>ORM 物件關聯對映</h5> -->
<?php
$sql = "";
// dd(q("SELECT COUNT(*) AS '0' FROM `students`")[0][0]);
function q($sql)
{
    global $pdo;
    return $pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
}

?>