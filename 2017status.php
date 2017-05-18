<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 
$in = "1125,1188,1190,1189,1384,1387,1388,1392,1393,1213,1214,1223,1218,1217,1220,1208,1206,1399,1207,1400,1401,1202,1200,1199,1203,1204,1390,1225,1237,1408,1239,1410,1407,1411,1412,1235,1228,1413,1414,1415,1418,1419,1423,1420,1421,1424,1242,1243,1244,1245,1247,1427,1246,1428,1135,1248,1249,1250,1430,1253,1431,1251,1432,1433";
//$in = file_get_contents('___problems.txt');
$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

$users = "袁邦文 20171125;刘峪含 20170135;姚晶菁 20170144;张嘉玥 20170145;蒋博文 20170207;殷天浩 20171218;赵行越 20141155;付星月 20171204;马玉龙 20161150;刘易鑫 20170307;夏铭 20171350;潘政成 20170333;周俊杰 20170221;张俊耀 20170527;何然 20170605;李冰雨 20170738;周子杰 23333333;张峻铭 20170624;覃岭 20170613;李铚 20170608;刘凯杰 20171113;彭欣宇 20170743;裴书悦 20170742;彭南又 20170114;赖昱行 c20161009;王尚勤 c20161039;肖枭 20160115;彭科贝 20160232;翁逍然 20160319;黄童 20160308;代玉泉 20160431;周锦超 20160520;黎越 20160600;廉栢杰 20160608;唐煜川 C20160716;何志凌 c20161007;雷斌 20161210;程鑫 20160203;汪恒丞 20170716";
//$users = file_get_contents('___users.txt');
//var_dump( explode(";",$str));
$encode = mb_detect_encoding($users, 'UTF-8', true);
if(!$encode){
	$temp = iconv("gbk","utf-8", $users);
	if($temp) $users = $temp;
}

$user = explode(";",$users);

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