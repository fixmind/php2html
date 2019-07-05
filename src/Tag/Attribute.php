<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tag;

class Attribute extends Id
{
	protected $attr = [];
	
	public function addAttr($attrName, $attrValue)
	{
		if ($this->validAttributeName($attrName))
		{
			if (preg_match('/^class$/i', $attrName))
			{
				$this->addClass($attrValue);
			}
			
			elseif (preg_match('/^style$/i', $attrName))
			{
				$style = explode(':', $attrValue);
				$this->addStyle($style[0], $style[1]);
			}
			
			elseif (preg_match('/^id$/i', $attrName))
			{
				$this->addId($attrValue);
			}
			
			else
			{
				$this->attr[$attrName] = $attrValue;
			}
		}
		
		return $this;
	}

	public function removeAttr($attrName)
	{
		if ($this->validAttributeName($attrName))
		{
			if (preg_match('/^class$/i', $attrName))
			{
				$this->class = [];
			}
			
			elseif (preg_match('/^style$/i', $attrName))
			{
				$this->style = [];
			}
			
			elseif (preg_match('/^id$/i', $attrName))
			{
				$this->removeId();
			}
			
			else
			{
				unset($this->attr[$attrName]);
			}
		}
		
		return $this;
	}

	public function hasAttr($attrName)
	{
		if ($this->validAttributeName($attrName))
		{
			if (preg_match('/^class$/i', $attrName))
			{
				return count($this->class) > 0 ? true : false;
			}
			
			elseif (preg_match('/^style$/i', $attrName))
			{
				return count($this->style) > 0 ? true : false;
			}
			
			elseif (preg_match('/^id$/i', $attrName))
			{
				return $this->hasId();
			}
			
			else
			{
				return array_key_exists($attrName, $this->attr);
			}
		}
	}
	
	public function getAttrValue($attrName)
	{
		if ($this->validAttributeName($attrName))
		{
			return $this->attr[$attrName];
		}
	}
	
	public function attributeRender()
	{
		$property = [];
		$this->attributeBuild($this->attr, $property);
		$this->attributeBuild(['id' => $this->idRender()], $property);
		$this->attributeBuild(['class' => $this->classRender()], $property);
		$this->attributeBuild(['style' => $this->styleRender()], $property);
		
		if (count($property) > 0) 
		{
			return implode(' ', $property);
		}
		else
		{
			return '';
		}
	}
	
	private function attributeBuild($addProperty, &$propertyList)
	{
		foreach($addProperty as $propName => $propValue)
		{
			if ($propValue != '')
			{
				$propertyList[] = $propName . '="' . $propValue . '"';
			}
		}
	}
	
	private function validAttributeName($attrName)
	{
		if (preg_match('/^[a-zA-Z]{1}[a-zA-Z-]{0,32}[a-zA-Z]{1}$/', $attrName) > 0)
		{
			return true;
		}
		else
		{
			throw new \Exception('Invalid attribute nane: "' . $attrName . '".');
		}
	}
}