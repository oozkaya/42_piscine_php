<?php
	class Lannister
	{
		public function sleepWith($someone)
		{
			if (get_parent_class($someone) == "Lannister")
				print "Not even if I'm drunk !".PHP_EOL;
			else
				print "Let's do this.".PHP_EOL;
		}
	}
?>