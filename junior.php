<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 


$in = "1011,1080,1007,1012,1018,1025,1364,1370,1464,1021,1263,1254,1396,1397,1462,1478,1473,1206,1207,1209,1208,1465,1208,1398,1210,1221,1211";

$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

$users = "王超 c20191219,杨欣渝 20191952,陈子仪 c20191604,杜周桓 c20191607,吴非 c20191620,杨辰希 c20191623,
黄翟 c20190508,蒋松霖 c20190511,谢东宸 c20190626,杨煜申 c20190727,李佳员 c20180809,范优乐 c20180806,
傅逸凡 c20192006,李昱霖 c20192010,廖睿 c20192012,项思翰 c20192028,陈俊宇2 c20192003,
江俊锋 c20180710,王礴航 c20180720,侯甸 c20181605,奚嘉祺 c20181418,邓铭越 c20191506,肖宇轩 c20191425,李曼宁 c20181139,
谢志宏 c20191426,杨子翔 c20191430,
华野森 c20181205,李佩桦 c20181209,陈秋宇 c20191106,李翼廷 c20191115,宋京桂 c20191127,肖宇轩 c20191425,
马坚珂 c20192016,
王一帆 c20181118,黄皓宇 c20181108,


 ";

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

	$sql = "select DISTINCT `problem_id` from solution where `result` = 4 and `user_id` like '%$id%'";
	if($in) $sql = $sql . "and problem_id in($in)";
	$result = mysqli_query($mysqli,$sql);
	$pids = '';
	while ($row=mysqli_fetch_array($result)){
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