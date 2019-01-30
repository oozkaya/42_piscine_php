<?php
	class NightsWatch implements IFighter
	{
		private $_recruits;
		
		public function recruit($someone)
		{
			$this->_recruits[] = $someone;
		}
		public function fight()
		{
			foreach ($this->_recruits as $recruit)
			{
				if ($recruit instanceof IFighter)
					$recruit->fight();
			}
		}
	}
?>