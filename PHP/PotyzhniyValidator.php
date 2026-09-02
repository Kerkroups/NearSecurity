<?php

class PotyzhniyValidator {

	public function __construct() {

		private $data1;
		private $data2;
		$data1_type = gettype($data1);
		$data2_type = gettype($data2);

		// Реализовать конструктор;
	}
	
	// Конвертация строки в двоичный формат и создание массива для строки.
	// Возможно стоит реализовать способ с преобразованием массива в последовательность 0 и 1.
	protected function objectToBinaryString(object $int) {
    	$binary = [];

    	// ...
    	return $binary;
	}
	
	protected function floatToBinaryString(float $int) {
    	$binary = [];

    	// ...
    	return $binary;
	}
	
	protected function integerToBinaryString(integer $int) {
    	$binary = [];

    	// ...
    	return $binary;
	}
	
	protected function stringToBinaryString(string $str) {
    	$binary = [];

    	foreach (str_split($str) as $char) {
        	$binary[] = sprintf('%08b', ord($char));
    	}
    	return $binary;
	}
	
	/* Возможно нужно сделать общую функцию с case:
	public static function checkData($data1, $data2){
		if ($data1_type === $data1_type) {
			$type = gettype($data1_type);
			switch($type) {
				case 'object':
					compareObjects();
					break;
				case 'float':
					compareFloats();
					break;
				case 'integer':
					compareItegers();
					break;
				case 'string':
					compareStrings()
					break;
			}
		}
		else {
			echo "Unknown data type";
		}
	}
		
	*/

	
	// Статический метод для сравнениия массивов.
	// Возможно стоит добавить возможность сравнивать последовательности из 1 для двух строк а именно их индексы.
	public static function compareStrings(array $arr1, array $arr2){
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
	public static function compareObject(array $arr1, array $arr2){
		$a1 = objectToBinaryString($arr1);
		$a2 = objectToBinaryString($arr2);
		if (count($a1) === count($a2) && $a1 === $a2) {
			echo "Same object";
			return True;
		}
		else {
			echo "Not same object";
			return False;
		}
	}
	public static function compareIntegers(array $arr1, array $arr2){
		$a1 = integerToBinaryString($arr1);
		$a2 = integerToBinaryString($arr2);
		if (count($a1) === count($a2) && $a1 === $a2) {
			echo "Integers same";
			return True;
		}
		else {
			echo "Integers not same";
			return False;
		}
	}
	public static function compareFloats(array $arr1, array $arr2){
		$a1 = floatToBinaryString($arr1);
		$a2 = floatToBinaryString($arr2);
		if (count($a1) === count($a2) && $a1 === $a2) {
			echo "Floats same";
			return True;
		}
		else {
			echo "Floats not same";
			return False;
		}
	}

// $str1 = stringToBinaryString($_GET['a']);
// $str2 = stringToBinaryString($_GET['b']);

$string = "string";
$array1 = explode(",", $string);

$string2 = "string";
$array2 = explode(",", $string2);

$result = compareStrings($array1, $array2);

//echo '<pre>';
//print_r($str1);
//print_r($str2);

echo $result;

//echo '</pre>';
}
?>
