<?php

/**
 * PhpToHtml 1.0.2
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tag;

class ClassTag extends Style
{

	protected $class = [];

	public function addClass($className)
	{
		if ($this->validClassName($className))
		{
			if ($this->hasClass($className) == false)
			{
				$this->class[] = $className;
			}
		}
		
		return $this;
	}

	public function removeClass($className)
	{
		if ($this->validClassName($className))
		{
			$this->class = array_diff($this->class, [$className]);
		}
		
		return $this;
	}

	public function hasClass($className)
	{
		if ($this->validClassName($className))
		{
			return in_array($className, $this->class);
		}
	}
	
	public function getClassList()
	{
		return $this->class;
	}
	
	public function classRender()
	{
		return implode(' ', $this->class);
	}
	
	private function validClassName($className)
	{
		if (preg_match('/^[a-zA-Z]{1}[a-zA-Z0-9-]{0,32}$/', $className) > 0)
		{
			return true;
		}
		else
		{
			throw new \Exception('Invalid class name: "' . $className . '".');
		}
	}
}