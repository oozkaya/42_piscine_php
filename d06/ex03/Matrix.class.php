<?php
	class Matrix
	{
		const IDENTITY = "IDENTITY";
		const SCALE = "SCALE";
		const RX = "Ox ROTATION";
		const RY ="Oy ROTATION";
		const RZ = "Oz ROTATION";
		const TRANSLATION = "TRANSLATION";
		const PROJECTION = "PROJECTION";

		private $_preset;
		private $_scale;
		private $_angle;
		private $_vtc;
		private $_fov;
		private $_ratio;
		private $_near;
		private $_far;
		public static $verbose = false;
		private $_matrix = [[0, 0, 0, 0],
							[0, 0, 0, 0],
							[0, 0, 0, 0],
							[0, 0, 0, 0]];

		public function		__construct( array $kwargs = null)
		{
			if (isset($kwargs))
			{
				if (array_key_exists('preset', $kwargs) && $this->_preset_exists($kwargs['preset']))
				{
					$this->_preset = $kwargs['preset'];
					if (array_key_exists('scale', $kwargs) && $this->_preset == self::SCALE)
						$this->_scale = $kwargs['scale'];
					if (array_key_exists('angle', $kwargs) && ($this->_preset == self::RX
															|| $this->_preset == self::RY
															|| $this->_preset == self::RZ))
						$this->_angle = $kwargs['angle'];
					if (array_key_exists('vtc', $kwargs) && $this->_preset == self::TRANSLATION)
						$this->_vtc = $kwargs['vtc'];
					if (array_key_exists('fov', $kwargs) && $this->_preset == self::PROJECTION)
						$this->_fov = $kwargs['fov'];
					if (array_key_exists('ratio', $kwargs) && $this->_preset == self::PROJECTION)
						$this->_ratio = $kwargs['ratio'];
					if (array_key_exists('near', $kwargs) && $this->_preset == self::PROJECTION)
						$this->_near = $kwargs['near'];
					if (array_key_exists('far', $kwargs) && $this->_preset == self::PROJECTION)
						$this->_far = $kwargs['far'];
					if (array_key_exists('mult', $kwargs))
						$this->_matrix = $kwargs['mult'];
					$this->_apply_preset();
				}
				if (self::$verbose)
				{
					echo "Matrix ".$this->_preset;
					if ($this->_preset != self::IDENTITY)
						echo " preset";
					echo " instance constructed".PHP_EOL;
				}
			}
		}

		public function		__destruct()
		{
			if (self::$verbose)
				echo "Matrix instance destructed".PHP_EOL;
		}

		public function		__toString()
		{
			$row = array('x', 'y', 'z', 'w');
			
			$str = "M | vtcX | vtcY | vtcZ | vtxO\n";
			$str .= "-----------------------------\n";
			for ($i = 0; $i < 4; $i++)
			{
				$str .= $row[$i];
				for ($j = 0; $j < 4; $j++)
					$str .= " | ".sprintf("%.2f", $this->_matrix[$i][$j]);
				if ($row[$i] != 'w')
					$str .= "\n";
			}
			return ($str);
		}

		public static function	doc()
		{
			if (file_exists('Matrix.doc.txt'))
			{
				$doc = file_get_contents("Matrix.doc.txt");
				echo $doc;
			}
		}

		private function	_preset_exists($preset)
		{
			$types = array(self::IDENTITY, self::SCALE, self::RX, self::RY, self::RZ,
							self::TRANSLATION, self::PROJECTION);
			if (in_array($preset, $types))
				return (TRUE);
			return (FALSE);
		}

		private function	_apply_preset()
		{
			switch ($this->_preset)
			{
				case (self::IDENTITY):
					$this->_identity();
					break;
				case (self::SCALE):
					$this->_scale();
					break;
				case (self::RX):
					$this->_rotation_x();
					break;
				case (self::RY):
					$this->_rotation_y();
					break;
				case (self::RZ):
					$this->_rotation_z();
					break;
				case (self::TRANSLATION):
					$this->_translation();
					break;
				case (self::PROJECTION):
					$this->_projection();
					break;
				default:
					break;
			}
		}

		private function	_identity()
		{
			$this->_matrix[0][0] = 1;
			$this->_matrix[1][1] = 1;
			$this->_matrix[2][2] = 1;
			$this->_matrix[3][3] = 1;
		}

		private function	_scale()
		{
			$this->_identity();
			$this->_matrix[0][0] = $this->_scale;
			$this->_matrix[1][1] = $this->_scale;
			$this->_matrix[2][2] = $this->_scale;
		}

		private function	_translation()
		{
			$this->_identity();
			$this->_matrix[0][3] = $this->_vtc->getX();
			$this->_matrix[1][3] = $this->_vtc->getY();
			$this->_matrix[2][3] = $this->_vtc->getZ();
		}

		private function	_rotation_x()
		{
			$this->_identity();
			$this->_matrix[1][1] = cos($this->_angle);
			$this->_matrix[1][2] = -sin($this->_angle);
			$this->_matrix[2][1] = sin($this->_angle);
			$this->_matrix[2][2] = cos($this->_angle);
		}

		private function	_rotation_y()
		{
			$this->_identity();
			$this->_matrix[0][0] = cos($this->_angle);
			$this->_matrix[0][2] = sin($this->_angle);
			$this->_matrix[2][0] = -sin($this->_angle);
			$this->_matrix[2][2] = cos($this->_angle);
		}

		private function	_rotation_z()
		{
			$this->_identity();
			$this->_matrix[0][0] = cos($this->_angle);
			$this->_matrix[0][1] = -sin($this->_angle);
			$this->_matrix[1][0] = sin($this->_angle);
			$this->_matrix[1][1] = cos($this->_angle);
		}

		private function	_projection()
		{
			$this->_identity();
			$this->_matrix[1][1] = 1 / tan(0.5 * deg2rad($this->_fov));
			$this->_matrix[0][0] = $this->_matrix[1][1] / $this->_ratio;
			$this->_matrix[2][2] = -1 * (-$this->_near - $this->_far) / ($this->_near - $this->_far);
			$this->_matrix[3][2] = -1;
			$this->_matrix[2][3] = (2 * $this->_near * $this->_far) / ($this->_near - $this->_far);
			$this->_matrix[3][3] = 0;
		}

		public function		getMatrix()
		{
			return ($this->_matrix);
		}

		public function mult(Matrix $rhs)
		{
			$mat = array();
			for ($i = 0; $i < 4; $i++)
			{
				for ($j = 0; $j < 4; $j++)
				{
					$mat[$i][$j] += $this->_matrix[$i][0] * $rhs->getMatrix()[0][$j];
					$mat[$i][$j] += $this->_matrix[$i][1] * $rhs->getMatrix()[1][$j];
					$mat[$i][$j] += $this->_matrix[$i][2] * $rhs->getMatrix()[2][$j];
					$mat[$i][$j] += $this->_matrix[$i][3] * $rhs->getMatrix()[3][$j];
				}
			}
			$new = new Matrix();
			$new->_matrix = $mat;
			return ($new);
		}

		public function transformVertex(Vertex $vtx)
		{
			$x = ($this->_matrix[0][0] * $vtx->getX()) + ($this->_matrix[0][1] * $vtx->getY()) +
					($this->_matrix[0][2] * $vtx->getZ()) + ($this->_matrix[0][3] * $vtx->getW());
			$y = ($this->_matrix[1][0] * $vtx->getX()) + ($this->_matrix[1][1] * $vtx->getY()) +
					($this->_matrix[1][2] * $vtx->getZ()) + ($this->_matrix[1][3] * $vtx->getW());
			$z = ($this->_matrix[2][0] * $vtx->getX()) + ($this->_matrix[2][1] * $vtx->getY()) +
					($this->_matrix[2][2] * $vtx->getZ()) + ($this->_matrix[2][3] * $vtx->getW());
			$w = ($this->_matrix[3][0] * $vtx->getX()) + ($this->_matrix[3][1] * $vtx->getY()) +
					($this->_matrix[3][2] * $vtx->getZ()) + ($this->_matrix[3][3] * $vtx->getW());
			$color = $vtx->getColor();
			$vertex = new Vertex(array('x' => $x, 'y' => $y, 'z' => $z, 'w' => $w, 'color' => $color));
			return $vertex;
		}
	}
?>