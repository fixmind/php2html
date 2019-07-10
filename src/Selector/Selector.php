<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Selector;

class Selector extends SelectorSearch
{
	
	public function selector($selector, $index = 0)
	{
		if ($index == 0)
		{
			$this->found = [];
			$selector = $this->compileSelector($selector);
			return $this->getPrimary()->search($selector);
		}
		elseif ($index > 0)
		{
			return $this->selectorFirst($selector, $index);
		}
		else 
		{
			return $this->selectorLast($selector, -$index);
		}
	}
	
	public function selectorFirst($selector, $index = 0)
	{
		$index = $index > 0 ? --$index : 0;
		$found = $this->selector($selector);
		if (count($found) > 0)
		{
			if ($index < count($found))
			{
				if ($index >= 0)
				{
					return $found[$index];
				}
				else
				{
					throw new \Exception("Selector index '{$index}' is less than zero.");
				}
			}
			else
			{
				throw new \Exception("Selector index '{$index}' is out of range '" . count($found) . "' found elements.");
			}
		}
		else
		{
			return false;
		}
	}
	
	public function selectorLast($selector, $index = 0)
	{
		$index = $index > 0 ? --$index : 0;
		$found = $this->selector($selector);
		if (count($found) > 0)
		{
			if ($index < count($found))
			{
				if ($index >= 0)
				{
					return $found[count($found) - 1 - $index];
				}
				else
				{
					throw new \Exception("Selector index '{$index}' is less than zero.");
				}
			}
			else
			{
				throw new \Exception("Selector index '{$index}' is out of range '" . count($found) . "' found elements.");
			}
		}
		else
		{
			return false;
		}
	}
	
	private function compileSelector($selector)
	{
		$selector = $this->formatSelector($selector);

		foreach($selector as $define)
		{
			if ($this->validSelector($define))
			{
				$selectorList[] = new SelectorModel($define);
			}
		}
		
		return $selectorList;
	}

	private function formatSelector($selector)
	{	
		$selectorList = [];
		foreach(explode(' ', $selector) as $define)
		{
			$define = trim($define);
			if ($define != '') 
			{
				$selectorList[] = $define;
			}
		}
		
		return $selectorList;
	}
	
	private function validSelector($selector)
	{
		if (preg_match('/^[a-zA-Z0-9-]{0,60}(#[a-zA-Z0-9-]{1,60})?(\.[a-zA-Z0-9-]{1,60})*$/', $selector) == true)
		{
			return true;
		}
		else
		{
			throw new \Exception('Invalid selector "'.$selector.'".');
		}
	}
	
}