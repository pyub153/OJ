<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 

$in = "1445,1446,1179,1180,1265,1267,1268,1375,1374,1118,1119,1156,1123,1148,1159,1007,1285,1124,1186,1187,1188,1190,1189,1202,1203,1200,1204,1199";
//$in = file_get_contents('___problems.txt');
$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

$users = "黄翟 c20190508,蒋松霖 c20190511,杨煜申 c20190727,李士杰 c20190908,李维航 c20191015,陈秋宇 c20191106,李翼廷 c20191115,宋京桂 c20191127,王超 c20191219,肖宇轩 c20191425,谢志宏 c20191426,杨子翔 c20191430,陈子仪 c20191604,杜周桓 c20191607,吴非 c20191620,杨辰希 c20191623,陈俊宇2 c20192003,傅逸凡 c20192006,李昱霖 c20192010,廖睿 c20192012,马坚珂 c20192016,项思翰 c20192028,唐帅 c20191327,邓铭越 c20191506,袁晓阳 c20192033,杨欣渝 c20191952,谢东宸 c20190626";
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