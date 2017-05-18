<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 
//$in = "1341,1255,1271,1670,1671,1674,1350,1351,1357,1358,1677,1680,1687,1364,1073,1339,1675";
//$in = "1670,1671,1674,1350,1351,1357,1358,1677,1680,1687,1364,1073,1339,1675,1517,1518,1524,1546,1555,1565,1566,1576,1581";
//$in = "1019,1102,1517,1524,1525,1545,1555,1557,1020,1295,1559,1565,1568,1583"; //dp列表
$in = "1102,1517,1524,1525,1545,1557,1295,1559,1565,1568,1583,1577,1580,1581,1295,1627,1628,1630,1632,1072,1633,1611,1618,1633,1611,1808,1404,1225,1408,1237,1240,1238,1411,1407,1410,1239"; //dp列表
//$in = file_get_contents('___problems.txt');
$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

$users = "苏新宇 c20170821,莫安柯 c20170415,郭延西 c20170804,张浴齐 c20170831";
//$users = file_get_contents('___users.txt');
//var_dump( explode(";",$str));
$encode = mb_detect_encoding($users, 'UTF-8', true);
if(!$encode){
	$temp = iconv("gbk","utf-8", $users);
	if($temp) $users = $temp;
}

$user = explode(",",$users);

echo '<table border="1">';
echo "<tr><th></th><th></th>";
for($i=0; $i<$pnum; $i++){
	echo '<th><a href=problem.php?id='.$pid[$i].' target=_blank>'.$pid[$i]."</a></th>";
}
echo "</tr>";
$i = 0;
while(strlen($user[$i])>8){
	$name = substr($user[$i], 0, strpos($user[$i], ' '));
	$id = substr($user[$i], strpos($user[$i], ' ')+1);

	//echo $user[$i]."<br>";
	//echo $name."<br>";
	//$id = intval($user[$i]);
	//echo $id."<br>";
	//$sql = "update crx_users set nick = '$name' where user_id like '%$id%'";
	//mysql_query($sql);
	$sql = "select DISTINCT `problem_id` from solution where `result` = 4 and `user_id` like '%$id%'";
	if($in) $sql = $sql . "and problem_id in($in)";
	$result = mysql_query($sql);
	$pids = '';
	while ($row=mysql_fetch_array($result)){
		$pids = $pids . ' {' . $row[0] . '} ';
	}
	echo "<tr><td>$name</td><td><a href= userinfo.php?user=$id>$id</a></td>";
	for($j=0; $j<$pnum; $j++){
		$temp = '{' . $pid[$j] . '}';
		if(strpos($pids, $temp)) echo "<td>1</td>";
		else echo "<td bgcolor = 'red'>0</td>";
	}
	echo "</tr>";
	$i++;
}
echo "</table>";
	//die($pid[5].$pnum);

?>