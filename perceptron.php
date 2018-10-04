<?php
define("LEARNING_RATE", 0.01);
define("MAX_ITERATION", 100);

function randomFloat(){ return (float) mt_rand() / mt_getrandmax(); }
function calculateOutput($weights, $x, $y){
	$sum = (float) $x * $weights[0] + $y * $weights[1] + $weights[2];
	return ($sum >= 0) ? 1 : -1;
}

srand(time());
$i = 0;

$ars = file('https://raw.githubusercontent.com/RichardKnop/ansi-c-perceptron/master/test1.txt');
foreach($ars as $ar){
    $temp = explode("\t", $ar);
    $x[$i] = (float) $temp[0];
    $y[$i] = (float) $temp[1];
    $outputs[$i] = (int) $temp[2];
    if($outputs[$i] == 0)
    	$outputs[$i] = -1;
    $i++;
}
$patternCount = $i;
$weights[0] = randomFloat();
$weights[1] = randomFloat();
$weights[2] = randomFloat();
$iteration = 0;

do{
    $iteration++;
    $globalError = 0;
	for ($p = 0; $p < $patternCount; $p++){
        $output = calculateOutput($weights, $x[$p], $y[$p]);
        $localError = $outputs[$p] - $output;
        $weights[0] += LEARNING_RATE * $localError * $x[$p];
        $weights[1] += LEARNING_RATE * $localError * $y[$p];
        $weights[2] += LEARNING_RATE * $localError;
    	$globalError += ($localError*$localError);
	}
	echo "Iteration $iteration : RMSE = ".sqrt($globalError/$patternCount).PHP_EOL;
} while ($globalError != 0 && $iteration<=MAX_ITERATION);
echo PHP_EOL;
echo "Decision boundary (line) equation: ".$weights[0]."*x + ".$weights[1]."*y + ".$weights[2]." = 0".PHP_EOL;
