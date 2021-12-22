<?php
include('conn.php');
$str = "/\ |\/|\~|\!|\@|\#|\\$|\%|\^|\&|\*|\(|\)|\_|\+|\{|\}|\:|\<|\>|\?|\[|\]|\,|\.|\/|\;|\'|\`|\-|\=|\\\|\|/";
$score = preg_replace($str, "", $_POST['score']);
$name = preg_replace($str, "", $_POST['name']);
$systeminfo = preg_replace($str, "", $_POST['systeminfo']);
$area = preg_replace($str, "", $_POST['area']);
$message = preg_replace($str, "", $_POST['message']);
if ((strlen($name) <= 30)&&($score < 300)&&($message <= 150)&&(is_numeric($score))&&(is_string($systeminfo))) {
    $result = mysqli_query($link, "SELECT * FROM ".$ranking." WHERE name='$name' limit 1");
    $data = mysqli_fetch_all($result);
    if ($data) {
        if ($score > $data[0][1]) {
            $sql = "UPDATE ".$ranking." SET score=?,time=NOW(),systeminfo=?,area=?,message=? WHERE name=?";
        }
    } else {
        $sql = "INSERT INTO ".$ranking." (score,time,systeminfo,area,message,name) VALUES (?,NOW(),?,?,?,?)";
    }
    if ($sql) {
        $stmt = $link->prepare($sql);
        $stmt->bind_param('issss', $score, $systeminfo, $area, $message, $name);
        $stmt->execute();
    }
    $link->close();
}