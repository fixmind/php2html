<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tag;

class Tag extends Attribute
{

	private $tag = null;

	private $content = [];

	private $parent = false;

	private static $renderInProgress = false;

	public function __construct($tag, $parent = false)
	{
		if ($this->validTagName($tag))
		{
			$this->tag = $tag;
			
			if (is_object($parent) == true)
			{
				$this->setParent($parent);
			}
		}
		else
		{
			throw new \Exception('Tag has notallowed characters: "' . $tag . '".');
		}
			
	}

	public function __toString()
	{
		if (true == self::$renderInProgress)
		{
			return $this->renderTag();
		}
		else
		{
			return $this->renderPrimary();
		}
	}

	public function __call($tag, $params = false)
	{
		$tag = $this->addTag($tag);
		if(isset($params[0]) && $params[0] != '') $tag->addText($params[0]);
		return $tag;
	}
	
	public function addTag($tag)
	{
		$newTag = new Tag($tag, $this);
		$this->content[] = $newTag;
		return $newTag;
	}

	public function addText($text)
	{
		$this->content[] = (string) $text;
		return $this;
	}
	
	public function getParent()
	{
		if ($this->isPrimary())
		{
			return $this;
		}
		else
		{
			return $this->parent;
		}
	}
	
	public function getPrimary()
	{
		if ($this->isPrimary())
		{
			return $this;
		}
		else
		{
			return $this->parent->getPrimary();
		}
	}
	
	public function getFirst($indexFromLeft = 1)
	{
		if ($this->getContentCount() < $indexFromLeft)
		{
			return null;
		}
		else
		{
			return $this->content[$indexFromLeft - 1];
		}
	}

	public function getLast($indexFromRight = 1)
	{
		if ($this->getContentCount() < $indexFromRight)
		{
			return null;
		}
		else
		{
			return $this->content[$this->getContentCount() - ($indexFromRight)];
		}
	}

	public function getFirstTag($indexFromLeft = 1)
	{
		if ($this->getContentCountTag() < $indexFromLeft)
		{
			return null;
		}
		else
		{
			$lp = 0;
			foreach ($this->content as $content)
			{
				if (is_object($content) == true)
				{
					if (++$lp == $indexFromLeft)
					{
						return $content;
					}
				}
			}
		}
	}

	public function getLastTag($indexFromRight = 1)
	{
		if ($this->getContentCountTag() < $indexFromRight)
		{
			return null;
		}
		else
		{
			$lastTagList = [];
			foreach ($this->content as $content)
			{
				if (is_object($content) == true)
				{
					$lastTag[] = $content;
				}
			}

			return $lastTag[$this->getContentCountTag() - $indexFromRight];
		}
	}

	public function removeContent()
	{
		$this->content = [];
	}

	public function getContent()
	{
		return implode('', $this->content);
	}
	
	public function getContentCount()
	{
		return count($this->content);
	}
	
	public function getContentTagList()
	{
		$contentTag = [];
		foreach ($this->content as $content)
		{
			if (is_object($content) == true)
			{
				$contentTag[] = $content;
			}
		}
		return $contentTag;
	}
	
	public function getContentCountTag()
	{
		$count = 0;
		foreach ($this->content as $content)
		{
			if (is_object($content) == true)
			{
				++$count;
			}
		}
		return $count;
	}
	
	public function getContentCountNotTag()
	{
		$count = 0;
		foreach ($this->content as $content)
		{
			if (is_object($content) == false)
			{
				++$count;
			}
		}
		return $count;
	}

	public function render()
	{
		self::$renderInProgress = true;
		$html = (string) $this;
		self::$renderInProgress = false;
		return $html;
	}

	public function getTag()
	{
		return $this->tag;
	}
	
	private function renderPrimary()
	{
		self::$renderInProgress = true;
		$html = (string) $this->getPrimary();
		self::$renderInProgress = false;
		return $html;
	}

	private function renderTag()
	{
		$tag[] = '<';
		$tag[] = $this->getTag();
		$tag[] = (($this->attributeRender() != '') ? ' ' . $this->attributeRender() : '');
		$tag[] = (($this->isNotClosedTag()) ? '/>' : '>');
		$tag[] = (($this->isNotClosedTag()) ? '' : $this->getContent() . '</' . $this->getTag() . '>');
		return implode('', $tag);
	}

	private function setParent(Tag $parent)
	{
		$this->parent = $parent;
	}

	private function isPrimary()
	{
		return (is_object($this->parent) ? false : true);
	}

	private function isNotClosedTag()
	{
		return preg_match('/^(img|br|hr|input)$/i', $this->tag);
	}

	private function validTagName(&$tagName)
	{
		$tagName = strtolower($tagName);
		if (preg_match('/^[a-z0-9]{1}[a-z0-9-]*$/', $tagName) == true)
		{
			return true;
		}
		else
		{
			throw new \Exception('Tag has notallowed characters: "' . $tagName . '".');
		}
	}
}