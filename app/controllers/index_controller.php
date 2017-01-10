<?php
class IndexController extends Page{
    public $layout = 'layout';
    private $_matrix = [];
    private $_rows = 0;

    public function __construct() {
    	isset($_SESSION['matrix']) or ($_SESSION['matrix'] = $this->_matrix);
    	isset($_SESSION['rows']) or ($_SESSION['rows'] = $this->_rows);
    }

    public function before_filter(){
		$this->_matrix = $_SESSION['matrix'];
		$this->_rows = $_SESSION['rows'];
	}

	public function after_render() {
    	$_SESSION['matrix'] = $this->_matrix;
    	$_SESSION['rows'] = $this->_rows;
	}
    /**
     * Exposes the form
     */
    public function indexAction() {

    }
    /**
     * Reset the matrix
     */
    public function resetAction() {
    	$this->_matrix = [];
    	$this->render = array('text'=>'Matrix is reset to empty');
    }
    /**
     * Set the number of elements for the cube
     */
    public function rowsAction() {
    	$rows = 0 + $_POST['rows']['elements'];

		if (empty($rows)):
			$this->render = array('text'=>'Value for rows must be an integer greater than 0');
		else:
			sizeof($this->_matrix) > 0 and ($this->resetAction());
			$this->_rows = $rows;

			for ($i=0; $i < $this->_rows; $i++):
				for ($j=0; $j < $this->_rows; $j++):
					for ($k=0; $k < $this->_rows; $k++):
						$this->_matrix[$i][$j][$k] = 0;
					endfor;
				endfor;
			endfor;

			$this->render = array('text'=>"Added {$this->_rows} elements to the matrix...");
		endif;
    }
	/**
	 * Set the value to the given coordinate
	 * @param array $params x,y and z points and the value to set
	 */
    public function setValueAction() {
		if (empty($this->_matrix)):
			$this->render = array('text'=>'Set a new matrix before insert values.');
		else:
			$x = $_POST['value']['x'] - 1;
			$y = $_POST['value']['y'] - 1;
			$z = $_POST['value']['z'] - 1;
			$value = 0 + $_POST['value']['value'];

			$this->_matrix[$x][$y][$z] = $value;

			$this->render = array('text'=>"The new value for ".($x + 1).", ".($y + 1).", ".($z + 1).", is {$value}");
		endif;
	}

	/**
	 * Does the sumation; goes trough the matrix from x,y,z to x1,y1,z1
	 * @param  array $params coordinates x,y,z and x1,y1,z1
	 */
	public function getValuesAction() {
		$result = 0;
		$realRows = $this->_rows - 1;

		foreach ($_POST['coordinates'] as $coord => $val):
			$_POST['coordinates'][$coord] = $val - 1;
		endforeach;

		if (isset($this->_matrix[$_POST['coordinates']['x']][$_POST['coordinates']['y']][$_POST['coordinates']['z']])
		    and isset($this->_matrix[$_POST['coordinates']['x1']][$_POST['coordinates']['y1']][$_POST['coordinates']['z1']])):

			for ($i = $_POST['coordinates']['x']; $i <= $_POST['coordinates']['x1']; $i++):
				$yBegin = 0;
				$yEnd = $realRows;

				if ($i === $_POST['coordinates']['x']):
					$yBegin = $_POST['coordinates']['y'];
					$yEnd = $realRows;
				elseif ($i === $_POST['coordinates']['x1']):
					$yBegin = 0;
					$yEnd = $_POST['coordinates']['y1'];
				endif;

				for ($j = $yBegin; $j <= $yEnd; $j++):
					$zBegin = 0;
					$zEnd = $realRows;

					if ($i === $_POST['coordinates']['x']):
						$zBegin = $_POST['coordinates']['z'];
						$zEnd = $realRows;
					elseif ($i === $_POST['coordinates']['x1']):
						$zBegin = 0;
						$zEnd = $_POST['coordinates']['z1'];
					endif;

					for ($k = $zBegin; $k <= $zEnd; $k++):
						$result += $this->_matrix[$i][$j][$k];
					endfor;
				endfor;
			endfor;

			$this->render = array('text'=>"The value summation between ".($_POST['coordinates']['x'] + 1).", ".($_POST['coordinates']['y'] + 1).", ".($_POST['coordinates']['z'] + 1)." and ".($_POST['coordinates']['x1'] + 1).", ".($_POST['coordinates']['y1'] + 1).", ".($_POST['coordinates']['z1'] + 1).", is {$result}");
		else:
			$this->render = array('text'=>"Coordinates not valid.");
		endif;
	}
}
