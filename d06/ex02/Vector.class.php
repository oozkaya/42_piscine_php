<?php
	require_once "Color.class.php";

	class Vector
	{
		private $_x = 0;
		private $_y = 0;
		private $_z = 0;
		private $_w = 0.0;
		public static $verbose = False;

		public function			__construct( array $kwargs )
		{
			if (array_key_exists('dest', $kwargs) && $kwargs['dest'] instanceof Vertex)
			{
				if (array_key_exists('orig', $kwargs) && $kwargs['orig'] instanceof Vertex)
					$orig = $kwargs['orig'];
				else
					$orig = new Vertex(array('x' => 0, 'y' => 0, 'z' => 0));
				$this->_x = $kwargs['dest']->getX() - $orig->getX();
				$this->_y = $kwargs['dest']->getY() - $orig->getY();
				$this->_z = $kwargs['dest']->getZ() - $orig->getZ();
			}
			if (self::$verbose)
			{
				$x = sprintf("%.2f", $this->_x);
				$y = sprintf("%.2f", $this->_y);
				$z = sprintf("%.2f", $this->_z);
				$w = sprintf("%.2f", $this->_w);
				$str = "Vector( x:".$x.", y:".$y.", z:".$z.", w:".$w." ) constructed".PHP_EOL;
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
				$str = "Vector( x:".$x.", y:".$y.", z:".$z.", w:".$w." ) destructed".PHP_EOL;
				echo $str;
			}
		}

		public function			__toString()
		{
			$x = sprintf("%.2f", $this->_x);
			$y = sprintf("%.2f", $this->_y);
			$z = sprintf("%.2f", $this->_z);
			$w = sprintf("%.2f", $this->_w);
			$str = "Vector( x:".$x.", y:".$y.", z:".$z.", w:".$w." )";
			return ($str);
		}

		public static function	doc()
		{
			if (file_exists('Vector.doc.txt'))
			{
				$doc = file_get_contents("Vector.doc.txt");
				echo $doc;
			}
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

		public function magnitude()
		{
			$x2 =	$this->_x * $this->_x;
			$y2 =	$this->_y * $this->_y;
			$z2 =	$this->_z * $this->_z;
			//$w2 =	$this->_w * $this_w;
			return (sqrt($x2 + $y2 + $z2));// + $w2));
		}

		public function normalize()
		{
			$norme = $this->magnitude();
			if ($norme == 1)
				return (clone $this);
			$vertex = new Vertex(array('x' => $this->_x / $norme,
									   'y' => $this->_y / $norme,
									   'z' => $this->_z / $norme));
			return (new Vector(array('dest' => $vertex)));
		}

		public function add(Vector $rhs)
		{
			$vertex = new Vertex(array('x' => $this->_x + $rhs->getX(),
									   'y' => $this->_y + $rhs->getY(),
									   'z' => $this->_z + $rhs->getZ()));
			return (new Vector((array('dest' => $vertex))));
		}

		public function sub(Vector $rhs)
		{
			$vertex = new Vertex(array('x' => $this->_x - $rhs->getX(),
									   'y' => $this->_y - $rhs->getY(),
									   'z' => $this->_z - $rhs->getZ()));
			return (new Vector((array('dest' => $vertex))));
		}

		public function opposite()
		{
			$vertex = new Vertex(array('x' => $this->_x * -1,
									   'y' => $this->_y * -1,
									   'z' => $this->_z * -1));
			return (new Vector((array('dest' => $vertex))));
		}

		public function scalarProduct($k)
		{
			$vertex = new Vertex(array('x' => $this->_x * $k,
									   'y' => $this->_y * $k,
									   'z' => $this->_z * $k));
			return (new Vector((array('dest' => $vertex))));	
		}

		public function dotProduct(Vector $rhs)
		{
			$product = $this->_x * $rhs->getX() +
					   $this->_y * $rhs->getY() +
					   $this->_z * $rhs->getZ();
			return ($product);
		}

		public function cos(Vector $rhs)
		{
			$numerator = $this->dotProduct($rhs);
			$denominator = $this->magnitude() * $rhs->magnitude();
			return ($numerator / $denominator);
		}

		public function crossProduct(Vector $rhs)
		{
			$x = $this->_y * $rhs->getZ() - $this->_z * $rhs->getY();
			$y = $this->_z * $rhs->getX() - $this->_x * $rhs->getZ();
			$z = $this->_x * $rhs->getY() - $this->_y * $rhs->getX();
			$vertex = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z));
			return (new Vector(array('dest' => $vertex)));
		}
	}
?>