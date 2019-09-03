<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tests;

use FixMind\PhpToHtml\Tag\Tag;

class TagTest extends \PHPUnit\Framework\TestCase
{
	public function testTag()
	{
		$tag = new Tag('div');
		$tag->addClass('toCenter')->addText('ok');
		$this->assertTrue($tag == '<div class="toCenter">ok</div>');
	}
}