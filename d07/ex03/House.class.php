<?php
	abstract class House
	{
		public function introduce()
		{
			$name = $this->getHouseName();
			$motto = $this->getHouseMotto();
			$seat = $this->getHouseSeat();
			print "House $name of $seat : \"$motto\"".PHP_EOL;
		}
		abstract function getHouseName();
		abstract function getHouseMotto();
		abstract function getHouseSeat();
	}
?>