<?php

/**
 * PhpToHtml 1.0.2
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml;

use FixMind\PhpToHtml\Tag\Tag;

class Html
{

	public static function Create($tag)
	{
		return new Tag($tag);
	}

	public static function __callStatic($tag, $params)
	{
		$tag = self::Create($tag);
		if (isset($params[0]) && $params[0] != '') $tag->addText($params[0]);
		return $tag;
	}
}