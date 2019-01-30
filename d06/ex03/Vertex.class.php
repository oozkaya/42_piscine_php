<?php
	class Vertex
	{
		private $_x = 0;
		private $_y = 0;
		private $_z = 0;
		private $_w = 1.0;
		private $_color;
		public static $verbose = False;

		public function			__construct( array $kwargs )
		{
			if ($this->_array_keys_exists(array('x', 'y', 'z'), $kwargs))
			{
				$this->_x = $kwargs['x'];
				$this->_y = $kwargs['y'];
				$this->_z = $kwargs['z'];
			}
			if (array_key_exists('w', $kwargs))
				$this->_w = $kwargs['w'];
			if (array_key_exists('color', $kwargs) && $kwargs['color'] instanceof Color)
				$this->_color = $kwargs['color'];
			else
				$this->_color = new Color(array('red' => 255, 'green' => 255, 'blue' => 255));
			if (self::$verbose)
			{
				$x = sprintf("%.2f", $this->_x);
				$y = sprintf("%.2f", $this->_y);
				$z = sprintf("%.2f", $this->_z);
				$w = sprintf("%.2f", $this->_w);
				$str = "Vertex( x: ".$x.", y: ".$y.", z:".$z.", w:".$w.", ".$this->_color." ) constructed".PHP_EOL;
				echo $str;
			}
		}

		public function			__destruct()
		{
			if (self::$verbose)
			{
				$x = sprintf("%.2f", $this->_x);
				$y = sprintf("%.2f", $this->_y);
				$z = sprintf("%.2f", $this->_z);
				$w = sprintf("%.2f", $this->_w);
				$str = "Vertex( x: ".$x.", y: ".$y.", z:".$z.", w:".$w.", ".$this->_color." ) destructed".PHP_EOL;
				echo $str;
			}
		}

		public function			__toString()
		{
			$x = sprintf("%.2f", $this->_x);
			$y = sprintf("%.2f", $this->_y);
			$z = sprintf("%.2f", $this->_z);
			$w = sprintf("%.2f", $this->_w);
			$str = "Vertex( x: ".$x.", y: ".$y.", z:".$z.", w:".$w;
			if (self::$verbose)
				$str .= ", ".$this->_color;
			$str .= " )";
			return ($str);
		}

		public static function	doc()
		{
			if (file_exists('Vertex.doc.txt'))
			{
				$doc = file_get_contents("Vertex.doc.txt");
				echo $doc;
			}
		}

		private function		_array_keys_exists(array $keys, array $arr)
		{
			return !array_diff_key(array_flip($keys), $arr);
		}

		public function			getX()
		{
			return ($this->_x);
		}
		public function			getY()
		{
			return ($this->_y);
		}
		public function			getZ()
		{
			return ($this->_z);
		}
		public function			getW()
		{
			return ($this->_w);
		}
		public function			getColor()
		{
			return ($this->_color);
		}

		public function			setX($x)
		{
			$this->_x = $x;
		}
		public function			setY($y)
		{
			$this->_y = $y;
		}
		public function			setZ($z)
		{
			$this->_z = $z;
		}
		public function			setW($w)
		{
			$this->_w = $w;
		}
		public function			setColor($color)
		{
			$this->_color = $color;
		}
	}
?>