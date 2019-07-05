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
	
	public function selector($selector)
	{
		$this->found = [];
		$selector = $this->compileSelector($selector);
		return $this->getPrimary()->search($selector);
	}
	
	public function selectorFirst($selector)
	{
		$found = $this->selector($selector);
		if (count($found) > 0)
		{
			return $found[0];
		}
		else
		{
			return false;
		}
	}
	
	public function selectorLast($selector)
	{
		$found = $this->selector($selector);
		if (count($found) > 0)
		{
			return $found[count($found) - 1];
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