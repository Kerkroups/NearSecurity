<?php
// Конвертация строки в двоичный формат
function stringToBinaryString(string $str) {
    $binary = [];

    foreach (str_split($str) as $char) {
        $binary[] = sprintf('%08b', ord($char));
    }
    return $binary;
}

//
function checkArrays(array $arr1, array $arr2){
	if (count($arr1) === count($arr2) && $arr1 === $arr2) {
		echo "Strings same";
		return True;
	}
	else {
		echo "Strings not same";
		return False;
	}

}

// $str1 = stringToBinaryString($_GET['a']);
// $str2 = stringToBinaryString($_GET['b']);

$string = "string";
$array1 = explode(",", $string);

$string2 = "string";
$array2 = explode(",", $string2);

$result = checkArrays($array1, $array2);

//echo '<pre>';
//print_r($str1);
//print_r($str2);

echo $result;

//echo '</pre>';

?>
