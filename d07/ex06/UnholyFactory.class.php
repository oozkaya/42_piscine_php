<?php
	class UnholyFactory
	{
		private $_absorbed;
		private $_fighters;
		public function absorb($fighter)
		{
			if (!($fighter instanceof Fighter))
			{
				print "(Factory can't absorb this, it's not a fighter)".PHP_EOL;
				return ;
			}
			$type = $fighter->getType();
			if (isset($this->_fighters) && in_array($type, $this->_fighters))
				print "(Factory already absorbed a fighter of type ".$type.")".PHP_EOL;
			else
			{
				$this->_fighters[] = $type;
				$this->_absorbed[] = clone $fighter;
				print "(Factory absorbed a fighter of type ".$type.")".PHP_EOL;
			}
		}

		public function fabricate($fighter)
		{
			if (in_array($fighter, $this->_fighters))
			{
				print "(Factory fabricates a fighter of type ".$fighter.")".PHP_EOL;
				foreach ($this->_absorbed as $f)
					if ($f->getType() == $fighter)
						return (clone $f);
			}
			else
				print "(Factory hasn't absorbed any fighter of type ".$fighter.")".PHP_EOL;
		}
	}
?>