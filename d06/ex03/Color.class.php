<?php
	class Color
	{
		public	$red = 0;
		public	$green = 0;
		public	$blue = 0;
		public static $verbose = False;

		public function			__construct( array $kwargs )
		{
			if (array_key_exists('rgb', $kwargs))
			{
				$rgb = intval($kwargs['rgb']);
				$this->red = (0xFF0000 & $rgb) >> 16;
				$this->green = (0xFF00 & $rgb) >> 8;
				$this->blue = 0xFF & $rgb;
			}
			else if ($this->_array_keys_exists(array('red', 'blue', 'green'), $kwargs))
			{
				$this->red = intval($kwargs['red']);
				$this->green = intval($kwargs['green']);
				$this->blue = intval($kwargs['blue']);
			}
			if (self::$verbose == True)
			{
				$r = sprintf("%3d", $this->red);
				$g = sprintf("%3d", $this->green);
				$b = sprintf("%3d", $this->blue);
				echo "Color( red: ".$r.", green: ".$g.", blue: ".$b." ) constructed.".PHP_EOL;
			}
		}

		public function			__destruct()
		{
			if (self::$verbose == True)
			{
				$r = sprintf("%3d", $this->red);
				$g = sprintf("%3d", $this->green);
				$b = sprintf("%3d", $this->blue);
				echo "Color( red: ".$r.", green: ".$g.", blue: ".$b." ) destructed.".PHP_EOL;
			}
		}
		
		public function			__toString()
		{
			$r = sprintf("%3d", $this->red);
			$g = sprintf("%3d", $this->green);
			$b = sprintf("%3d", $this->blue);
			return ("Color( red: ".$r.", green: ".$g.", blue: ".$b." )");
		}

		private function		_array_keys_exists(array $keys, array $arr)
		{
			return !array_diff_key(array_flip($keys), $arr);
		}

		public static function	doc()
		{
			if (file_exists('Color.doc.txt'))
			{
				$doc = file_get_contents("Color.doc.txt");
				echo $doc;
			}
		}

		public function			add(Color $rhs)
		{
			$new = new Color(array('red' => $this->red + $rhs->red,
									'green' => $this->green + $rhs->green,
									'blue' => $this->blue + $rhs->blue));
			return ($new);
		}

		public function			sub(Color $rhs)
		{
			$new = new Color(array('red' => $this->red - $rhs->red,
									'green' => $this->green - $rhs->green,
									'blue' => $this->blue - $rhs->blue));
			return ($new);
		}

		public function			mult($f)
		{
			$new = new Color(array('red' => $this->red * $f,
									'green' => $this->green * $f,
									'blue' => $this->blue * $f));
			return ($new);
		}
	}
?>