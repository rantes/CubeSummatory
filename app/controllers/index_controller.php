<?php
class IndexController extends Page{
    public $layout = 'layout';
    private $_matrix = [];
    private $_rows = 0;

    public function indexAction() {

    }

    public function resetAction() {
    	$this->_matrix = [];
    	$this->render = array('text'=>'Matrix is reset to empty');
    }

    public function rowsAction() {
    	$rows = 0 + $_POST['rows']['elements'];

		if (empty($rows)):
			$this->render = array('text'=>'Value for rows must be an integer greater than 0');
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

			$this->render = array('text'=>'Added {$this->_rows} to the matrix...');
		endif;
    }
}
