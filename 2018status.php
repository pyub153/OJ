<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 
$in = "1370,1371,1372,1373,1338,1339,1340,1341,1342,1343,1255,1348,1349,1667,1668,1271,1671,1673,1670,1674,1675,1350,1351,1352,1357,1358,1359,1677,1678,1679,1680,1681,1682,1313,1687,1686,1688,1689,1691,1692,1699,1700,1701,1702,1703,1704,1705,1706,1707,1708,1709,1710,1711,1712,1713";
//$in = file_get_contents('___problems.txt');
$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

$users = "石淳安 20180115,袁荟凯 20180121,朱云鹏 20180124,彭燃 20180613,刘霖 20180610,黄枥锐 20180807,蒋雨航 20180809,姚瑞 c20150122,何冠男 20181408,龙奕舟 20181611,周应溥 20181629,陈思哲 20181801,涂潇睿 20180217,包云开 20180301,柳祥 20180211,何周泽 20180410,杨泊兵 2244320,高嗣杰 20181203,刘易鑫 20170307,马玉龙 20161150,赖昱行 c20161009,李佳忆 c20160737,唐煜川 C20160716,何志凌 c222222,王尚勤 c20161039,杨寒羽 20161024,苏新宇 c20170821,莫安柯 c20170415,郭延西 c20170804,张浴齐 c20170831,张奇夫 Apache553";
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