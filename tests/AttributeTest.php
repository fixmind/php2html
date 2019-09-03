<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tests;

use FixMind\PhpToHtml\Tag\Attribute;

class TagAttributeTest extends \PHPUnit\Framework\TestCase
{
	public function testTagAttribute()
	{
		$attribute = new Attribute();
		
		$attribute->addClass('toCenter');
		$this->assertTrue($attribute->attributeRender() == 'class="toCenter"');
		
		$attribute->addAttr('checked', 'checked');
		$this->assertTrue($attribute->attributeRender() == 'checked="checked" class="toCenter"');
		
		$attribute->addAttr('type', 'text');
		$attribute->addClass('toBottom');
		$this->assertTrue($attribute->attributeRender() == 'checked="checked" type="text" class="toCenter toBottom"');
	}
}