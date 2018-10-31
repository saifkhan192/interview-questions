<?php
/*
	Given a 2D array find the longest sequence of identical numbers.
	Output the longest sequence and the sequence itself. 
	You can have a sequences going bottom, left, right, top, or a combination of all 4, but not diagonally. 
	For example:
		1 1 3
		2 1 1
		3 3 1

	Output:
	The longest sequence is 5 "1"s. The coordinate are (2,2), (1,2), (1,1), (0,1), (0,0),

*/

function displayMatrix($mat)
{
	$rows = count($mat);
	$cols = count($mat[0]);
	for($i=0;$i<$rows;$i++)
	{
		for($j=0;$j<$cols;$j++)
		{
			print_r( $mat[$i][$j].'  ' );
		}
		print_r( PHP_EOL );
	}
}
function findAdjacent($num,$mat,$i,$j,&$pathArray,&$visitedArray)
{
	$rows = count($mat);
	$cols = count($mat[0]);
	//check bounds if fails then backtrack
	if( $i>=$rows || $j>=$cols || $i<0 || $j<0 )
	{
		return;
	}

	//check of already visited then backtrack
	if( in_array([$i,$j], $visitedArray) )
	{
		return;
	}
	else
	{
		$visitedArray[] = [$i,$j];
	}

	//lookup same adjacent number if fails then backtrack
	if( $mat[$i][$j] != $num )
	{
		return;
	}
	//save location of same matched number and traverce in all four directions recursively untill condition is matched
	$pathArray[] = [$i,$j];
	findAdjacent($num,$mat,$i,$j+1,$pathArray,$visitedArray);
	findAdjacent($num,$mat,$i+1,$j,$pathArray,$visitedArray);
	findAdjacent($num,$mat,$i,$j-1,$pathArray,$visitedArray);
	findAdjacent($num,$mat,$i-1,$j,$pathArray,$visitedArray);
}

$mat = [
	[1,1,3],
	[2,1,1],
	[3,3,1],
];

$sequencePath = [];
$sequenceLength = [];
$rows = count($mat);
$cols = count($mat[0]);
for($i=0;$i<$rows;$i++)
{
	for($j=0;$j<$cols;$j++)
	{
		$num = $mat[$i][$j];
		$pathArray = [];
		$visitedArray = [];
		findAdjacent($num,$mat,$i,$j,$pathArray,$visitedArray);
		$sequencePath[ $num ] = $pathArray;
		$sequenceLength[ $num ] = count($pathArray);
	}
}
asort($sequenceLength);
end($sequenceLength);
$number = key($sequenceLength);
$seqCount = $sequenceLength[$number];
$coordinate='';
foreach( $sequencePath[ $number ] as $point )
{
	$coordinate .= '('.implode(',', $point).'), ';
}

echo 'input-matrix:'.PHP_EOL;
displayMatrix( $mat );

// echo 'sequencePath:'.PHP_EOL;print_r($sequencePath);
// echo 'sequenceLength:'.PHP_EOL;print_r($sequenceLength);

echo "The longest sequence is $seqCount \"$number\"s. The coordinate are $coordinate " . PHP_EOL;

?>