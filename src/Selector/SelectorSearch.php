<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace fixmind\PhpToHtml\Selector;

class SelectorSearch
{

	protected function search($selector, $selectorIndex = 0, $checkChildrenOnly = false)
	{
		if ($selector[$selectorIndex]->checkMatch($this) && $checkChildrenOnly == false)
		{
			if ($selectorIndex == count($selector) - 1)
			{
				return array_merge([$this], $this->search($selector, $selectorIndex, true));
			}
			else
			{
				return $this->search($selector, $selectorIndex + 1, true);
			}
		}

		elseif ($this->getContentCountTag() > 0)
		{
			$found = [];
			foreach ($this->getContentTagList() as $tag)
			{
				$found = array_merge($found, $tag->search($selector, $selectorIndex));
			}

			return $found;
		}
		
		else
		{
			return [];
		}
	}

}