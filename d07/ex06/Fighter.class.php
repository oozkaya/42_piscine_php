<?php
	abstract class Fighter
	{
		private $_type;
		abstract public function fight($target);

		public function __construct($type)
		{
			$this->_type = $type;
		}
		public function	getType()
		{
			return ($this->_type);
		}
	}
?>