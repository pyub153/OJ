<?php
require_once('./include/db_info.inc.php');
	require_once('./include/cache_start.php');
	require_once('./include/setlang.php');
header("Content-type: text/html; charset=utf-8"); 

//$in = "1733,1734,1735,1736,1737,1738,1743,1714,1746,1744,1745,1752,1751,1781,1782,1788,1787,1649,1789,1790,1784,1794,1792,1791,1757,1795,1798,1797,1796,1799,1801,1802,1804,1809,1806,1810,1811,1813,1814,1833,1816,1817,1818,1819,1820,1834,1835,1836,1837,1838,1839,1840,1841,1842,1843,1844,1845,1846,1847,1848,1849,1850,1851,1852,1853,1854,1855,1856,1857,1858"; //总
$in = "1998,1999,2000,2001,1745,1752,1751,1781,1782,1788,1787,1649,1789,1790,1784,1791,1757,1795,1797,1796,1809,1806,1810,1811,1813,1814,1833,1816,1817,1818,1819,1836,1837,1844,1845,1846,1847,1848,1849,1850,1851,1852,1853,1854,1855,1856,1857,1858,1859,1860,1862"; 

$pid = explode(",",$in);
$pnum = 0;
while($pid[$pnum]>0) $pnum++;

//$users = "马玉龙 20161150,赖昱行 20190107,李佳忆 c20160737,唐煜川 20190116,何志凌 20192009";
$users = "马玉龙 20161150,赖昱行 20190107,唐煜川 20190116,何志凌 20192009";
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