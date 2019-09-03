<?php

/**
 * PhpToHtml 1.0.2
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tag\Enum;

use FixMind\Enum\Enum;

class NotClosedTag extends Enum
{
	const VALUE = [
		'br',
		'img',
		'input',
		'hr',
		'meta',
		'area',
		'base',
		'col',
		'command',
		'embed',
		'keygen',
		'link',
		'param',
		'source',
		'track',
		'wbr'
	];
	
}