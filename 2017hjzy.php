<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 
$in = "1012,1017,1119,1201,1376,1333,1266,1381,1288,1107,1382,1085";
//$in = file_get_contents('___problems.txt');
$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

$users = "袁邦文 20171125;刘峪含 20170135;姚晶菁 20170144;张嘉玥 20170145;蒋博文 20170207;熊英杰 20171249;殷天浩 20171218;赵行越 20171254;付星月 20171204;马玉龙 20161150;刘易鑫 20170307;夏铭 20171350;潘政成 20170333;李智中 20171404;周俊杰 20170221;刘子贤 20170413;邱崧洋 20170417;张俊耀 20170527;丁雨茜 2017535;何宗书 20170513;何然 20170605;纪旭 20171634;李冰雨 20170738;周子杰 23333333;张峻铭 20170624;覃岭 20170613;李铚 20170608;艾星言 20171130;陈语瑶 20171132;刘凯杰 20171113;付诗芹 20171829;彭欣宇 20170743;裴书悦 20170742;陈毅 20171801;彭南又 20170114;赖昱行 c20161009;王尚勤 c20161039;卢泽仁 20161011";
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
	echo '<th><a href=problem.php?id='.$pid[$i].'>'.$pid[$i]."</a></th>";
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
	die($pid[5].$pnum);

?>