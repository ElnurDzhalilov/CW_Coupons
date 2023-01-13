<?php
include("./db.php");
$res = mysqli_query($db, "SELECT * FROM admins");
$cur = mysqli_fetch_assoc($res);
$arr = [];
while ($cur) {
  $arr[$cur['flag']] = 0;
  $cur = mysqli_fetch_assoc($res);
}
if(sizeof($arr)) {
  foreach($arr as $flag => $coup) {
    //при попытке изменить напрямую $coup ничего не происходит, так что вот
    $arr[$flag] = mysqli_fetch_assoc(mysqli_query($db, "SELECT *  FROM coupons WHERE flag=$flag"))['name'] ?? 0;
  }
  $arr = json_encode($arr);
  echo($arr);
}
 ?>
