#!/usr/bin/php

<?php

/**
* Handles the cube sumation in a 3d matrix
*/
class Matrix3D {
	private $_matrix = [];
	private $_rows = 0;
	private $_header = <<<RANTES
******************************
    MATRIX PROBLEM
******************************

Instructions:

- Hit 'new'<enter> to set a new 3D matrix.
- Type 'rows N'<enter> to set the row numbers, where N is the number of rows.
   This will reset the matrix.
- Type 'QUERY x y z x1 y1 z1'<enter> to fetch the summation between those cells.
- Type 'UPDATE x y z value'<enter> to update a 'value' into the providen cell.
   Value should be integer always.
- Type 'exit' to finish the program.

******************************\n
RANTES;

	public function __construct() {
		echo $this->_header;
	}
	/**
	 * Set an empty matrix
	 */
	public function resetMatrix() {
		echo "\n", 'Reseting matrix...', "\n";
		$this->_matrix = [];
	}
	/**
	 * Stablish the dimentions for the cube
	 * @param integer $rows Number of elements for x,y and z
	 * @return boolean Wether if works or not
	 */
	public function setRows($rows) {
		$rows = 0 + $rows;
		$done = false;

		if (empty($rows)):
			echo "\n", "Value for rows must be an integer greater than 0.", "\n";
		else:
			sizeof($this->_matrix) > 0 and ($this->_matrix = []);
			$this->_rows = $rows;

			for ($i=0; $i < $this->_rows; $i++):
				for ($j=0; $j < $this->_rows; $j++):
					for ($k=0; $k < $this->_rows; $k++):
						$this->_matrix[$i][$j][$k] = 0;
					endfor;
				endfor;
			endfor;

			echo "\n", "Added {$this->_rows} to the matrix...", "\n";
			$done = true;
		endif;

		return $done;
	}
	/**
	 * Set the value to the given coordinate
	 * @param array $params x,y and z points and the value to set
	 */
	public function setValue($params) {
		if (empty($this->_matrix)):
			echo "\n", "Set a new matrix before insert values.", "\n";
		else:
			$x = $params[1] - 1;
			$y = $params[2] - 1;
			$z = $params[3] - 1;
			$value = 0 + $params[4];

			$this->_matrix[$x][$y][$z] = $value;

			echo "\n", "The new value for ".($x + 1).", ".($y + 1).", ".($z + 1).", is {$value}", "\n";
		endif;
	}
	/**
	 * Does the sumation; goes trough the matrix from x,y,z to x1,y1,z1
	 * @param  array $params coordinates x,y,z and x1,y1,z1
	 */
	public function getValues($params) {
		$result = 0;
		$realRows = $this->_rows - 1;
		array_shift($params);
		for ($i = 0; $i < sizeof($params); $i++):
			$params[$i] -= 1;
		endfor;

		if (isset($this->_matrix[$params[0]][$params[1]][$params[2]]) and isset($this->_matrix[$params[3]][$params[4]][$params[5]])):
			for ($i = $params[0]; $i <= $params[3]; $i++):
				$yBegin = 0;
				$yEnd = $realRows;

				if ($i === $params[0]):
					$yBegin = $params[1];
					$yEnd = $realRows;
				elseif ($i === $params[3]):
					$yBegin = 0;
					$yEnd = $params[4];
				endif;

				for ($j = $yBegin; $j <= $yEnd; $j++):
					$zBegin = 0;
					$zEnd = $realRows;

					if ($i === $params[0]):
						$zBegin = $params[2];
						$zEnd = $realRows;
					elseif ($i === $params[3]):
						$zBegin = 0;
						$zEnd = $params[5];
					endif;

					for ($k = $zBegin; $k <= $zEnd; $k++):
						$result += $this->_matrix[$i][$j][$k];
					endfor;
				endfor;
			endfor;

			echo "\n", "The value summation between ".($params[0] + 1).", ".($params[1] + 1).", ".($params[2] + 1)." and ".($params[3] + 1).", ".($params[4] + 1).", ".($params[5] + 1).", is {$result}", "\n";
		else:
			echo "\n", "Coordinates not valid.", "\n";
		endif;
	}
}

$Matrix = new Matrix3D();
/**
 * Only helps to check the length of params
 * @param  array $params Params providen into the shell
 * @param  integer $qty    How many params should be there.
 * @return boolean         If valid or not
 */
function validateParams($params, $qty) {
	$valid = sizeof($params) >= $qty;

	$valid or print("\n Not enough params, try again. \n");

	return $valid;
}

while(($line = trim(fgets(STDIN))) !== 'exit'):
	$params = explode(' ', $line);
	switch ($params[0]):
		case 'new':
			$Matrix->resetMatrix();
		break;

		case 'rows':
			validateParams($params, 2) and $Matrix->setRows($params[1]);
		break;

		case 'UPDATE':
			validateParams($params, 5) and $Matrix->setValue($params);
		break;

		case 'QUERY':
			validateParams($params, 7) and $Matrix->getValues($params);
		break;

		default:
			echo "\n", 'Not valid option', "\n";
		break;
	endswitch;
endwhile;

echo "\n", 'Goodbye', "\n";
?>