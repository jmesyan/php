<?php
$config = [
	[800, 1235], 
	[600, 1235], 
	[600, 1235], 
	[590, 1235], 
	[560, 1235], 
	[500, 1235], 
	[450, 1235], 
	[400, 1235], 
	[400, 1235], 
	[300, 1235], 
	[50, 1235],
	[15, 1235], 
	[5, 1235],
	[5, 1235]
];

$max = 0;
foreach($config as $v1) {
	$max += $v1[0];
}

$begin = time();

for($i=0; $i < 100000; $i++){
	$chance = mt_rand(1,$max);
	$match = false;
	foreach($config as $v2) {
		if($v2[0] >= $chance) {
			$match = true;
			echo 1, "#", $v2[0], "#", $chance,"\r";
			// break;
		} else {
			$chance -= $v2[0];
		}
	}
	if (!$match) echo 0, "#",$chance,"\r";
}

$end = time();

echo "diff is : ".($begin - $end);