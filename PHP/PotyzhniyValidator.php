<?php

class PotyzhniyValidator {

	public function __construct() {

		// Реализовать конструктор;
	}
	
	// Конвертация строки в двоичный формат и создание массива для строки.
	// Возможно стоит реализовать способ с преобразованием массива в последовательность 0 и 1.
	function stringToBinaryString(string $str) {
    	$binary = [];

    	foreach (str_split($str) as $char) {
        	$binary[] = sprintf('%08b', ord($char));
    	}
    	return $binary;
	}

	// Статический метод для сравнениия массивов.
	// Возможно стоит добавить возможность сравнивать последовательности из 1 для двух строк а именно их индексы.
	public static function checkArrays(array $arr1, array $arr2){
		$a1 = stringToBinaryString($arr1);
		$a2 = stringToBinaryString($arr2);
		if (count($a1) === count($a2) && $a1 === $a2) {
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
}
?>
