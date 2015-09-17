<?php

namespace Core\Html;

class HtmlBootstrapTable extends Html {

  /**
	 * [IcoCheck description]
	 * @param [type] $value [description]
	 */
	public function IcoCheck($value)
  {
      if ($value)
      {
				return '<i class="fa fa-check-square-o .success" style="color: green;"></i>';
			}
			else
      {
				return '<i class="fa fa-square-o" style="color: red;"></i>';
			}
	}

} // end of class



?>