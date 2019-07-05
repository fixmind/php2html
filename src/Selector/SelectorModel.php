<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Selector;

use FixMind\PhpToHtml\Tag\Tag;

class SelectorModel
{
	private $selector = false;
	
	private $tag = false;
	
	private $class = [];
	
	private $id = false;

	public function __construct($selector)
	{
		// SELECTOR
		$this->selector = $selector;
		
		// TAG
		if (strpos($selector, '#') > 0)
		{
			$this->tag = substr($selector, 0, strpos($selector, '#'));
		}
		elseif(strpos($selector, '#') > 0 && strpos($selector, '.') > 0)
		{
			$this->tag = substr($selector, 0, strpos($selector, '.'));
		}
		elseif(strpos($selector, '.') > 0 && preg_match('/#/', $selector) == false)
		{
			$this->tag = substr($selector, 0, strpos($selector, '.'));
		}
		elseif(preg_match('/#/', $selector) == false && preg_match('/\./', $selector) == false)
		{			
			$this->tag = $selector;
		}
		
		// OBJECT
		if (preg_match('/#/', $selector) == true)
		{
			if (preg_match('/\./', $selector) == true)
			{
				$this->id = substr($selector, strpos($selector, '#') + 1, strpos($selector, '.') - strpos($selector, '#') - 1);
			}
			else
			{
				$this->id = substr($selector, strpos($selector, '#') + 1);
			}
		}
		
		// CLASSES
		if (preg_match('/\./', $selector) == true)
		{
			$classes = explode('.', $selector);
			for($i = 1; $i < count($classes); $i++)
			{
				if ($classes[$i] != '') $this->class[] = $classes[$i];
			}
		}
		
		// SELF TEST
		if ((string) $this != $this->selector)
		{
			new \Exception('Unrecongnized ERROR in selector.');
		}
	}
	
	public function __toString()
	{
		$selector = ($this->tag != false) ? $this->tag : '';
		$selector .= ($this->id != false) ? '#' . $this->id : '';
		$selector .= (count($this->class) > 0) ? '.' . implode('.', $this->class) : '';
		return $selector;
	}
	
	public function checkMatch(Tag $tag)
	{
		// TAG
		if ($this->notMatchTag($tag))
		{
			return false;
		}
		
		// ID
		elseif ($this->notMatchId($tag))
		{
			return false;
		}
		
		// CLASSES
		elseif ($this->notMatchClass($tag))
		{
			return false;
		}
		
		// OK
		else
		{
			return true;
		}
	}
	
	private function setTag($tag)
	{
		$this->tag = $tag;
	}

	private function setClass($class)
	{
		if (is_array($class))
		{
			$this->class = $class;
		}
		else
		{
			$this->class = [$class];
		}
	}
	
	private function setId($id)
	{
		$this->id = $id;
	}
	
	
	
	private function notMatchTag(Tag $tag)
	{
		if ($this->tag == false || $this->tag == $tag->getTag())
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	private function notMatchId(Tag $tag)
	{
		if ($this->id == false || $this->id == $tag->getId(true))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	
	
	private function notMatchClass(Tag $tag)
	{
		if (count($this->class) == 0 || $this->classMatch($tag->getClassList()))
		{
			return false;
		}
		else
		{
			return true;
		}
	}
		
	private function classMatch($classList)
	{
		return count(array_diff($this->class, $classList)) > 0 ? false : true;
	}
	
	private function getSelector()
	{
		return $this->selector;
	}
}