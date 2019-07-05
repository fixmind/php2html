<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace fixmind\PhpToHtml\Tag;

use fixmind\PhpToHtml\Selector\Selector;

class Style extends Selector
{
	protected $style = [];
	
	public function addStyle($style, $styleValue = false)
	{
		if (is_array($style) && $styleValue == false)
		{
			foreach($style as $styleName => $styleValue)
			{
				$this->addStyleElement($styleName, $styleValue);
			}
		}
		else
		{
			$this->addStyleElement($style, $styleValue);
		}
		
		return $this;
	}

	public function removeStyle($styleName)
	{
		if ($this->validStyleName($styleName))
		{
			if ($this->hasStyle($styleName))
			{
				unset($this->style[$styleName]);
			}
			else
			{
				throw new \Exception('Tag hasn\'t style defined: "'.$styleName.'".');
			}
		}
		
		return $this;
	}

	public function hasStyle($styleName)
	{
		if ($this->validStyleName($styleName))
		{
			if (array_key_exists($styleName, $this->style))
			{
				return true;
			}
			else
			{
				return false;
			}
		}
	}
	
	public function getStyle($styleName)
	{
		if ($this->hasStyle($styleName))
		{
			return $this->style[$styleName];
		}
		else
		{
			throw new \Exception('There is no style: "' . $styleName . '".');
		}
	}
	
	public function styleRender()
	{
		$styleList = [];
		foreach($this->style as $styleName => $styleValue)
		{
			$styleList[] = "{$styleName}: {$styleValue};";
		}
		return implode(' ', $styleList);
	}

	private function addStyleElement($styleName, $styleValue)
	{
		if ($this->validStyleName($styleName))
		{
			if ($this->validStyleValue($styleValue))
			{
				$this->style[$styleName] = $styleValue;
			}
		}
	}

	private function validStyleName($styleName)
	{
		if (preg_match('/^[a-z-]{1,32}$/', $styleName) > 0)
		{
			return true;
		}
		else
		{
			throw new \Exception('Invalid style name: "' . $className . '".');
		}
	}
	
	private function validStyleValue($styleValue)
	{
		if (preg_match('/^[^;"]{1,64}$/', $styleValue) > 0)
		{
			return true;
		}
		else
		{
			throw new \Exception('Invalid style value: "' . $className . '". Style can not contain ";", \'"\' character.');
		}
	}
}