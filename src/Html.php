<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace fixmind\PhpToHtml;

use fixmind\PhpToHtml\Tag\Tag;

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