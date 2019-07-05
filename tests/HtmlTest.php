<?php

/**
 * Html 1.0.1
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace fixmind\Tests\PhpToHtml;

use fixmind\PhpToHtml\Html;

class HtmlTest extends \PHPUnit\Framework\TestCase
{
	public function testCreate()
	{
		$this->assertTrue(Html::Create('div') == '<div></div>', Html::Create('div'));

		$this->assertTrue(Html::Create('br') == '<br/>');
		
		$this->assertTrue(Html::Create('ul')->addTag('li')->addText('first point')->getParent()->addTag('li')->addText('second point') == '<ul><li>first point</li><li>second point</li></ul>');
		
		$this->assertTrue(Html::Create('ul')->li('first point')->getParent()->li('second point') == '<ul><li>first point</li><li>second point</li></ul>');
		
		$this->assertTrue(Html::ul()->li('first point')->getParent()->li('second point') == '<ul><li>first point</li><li>second point</li></ul>');
		
		$this->assertTrue(Html::ul()->li('first point')->getParent()->li('second point')->i('italic') == '<ul><li>first point</li><li>second point<i>italic</i></li></ul>');
	}
	
	public function testContentCount()
	{
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->getContentCount() == 3);
		
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->addText('ok')->getParent()->getContentCount() == 4);
		
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->addText('ok')->getParent()->getContentCountTag() == 3);
		
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->addText('ok')->getParent()->getContentCountNotTag() == 1);
	}
	
	public function testGetFirstLast()
	{
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->getFirst()->addText('[X]') == '<ul><li>first[X]</li><li>second</li><li>third</li></ul>');
		
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->getLast()->addText('[X]') == '<ul><li>first</li><li>second</li><li>third[X]</li></ul>');
		
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->getFirst(2)->addText('[X]') == '<ul><li>first</li><li>second[X]</li><li>third</li></ul>');
		
		$this->assertTrue(Html::ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->getLast(2)->addText('[X]') == '<ul><li>first</li><li>second[X]</li><li>third</li></ul>');
	}

	public function testAttrib()
	{
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv') == '<div name="myDiv"></div>');
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal') == '<div name="myDiv" type="normal"></div>');
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal')->addText('okej') == '<div name="myDiv" type="normal">okej</div>');
		
		$this->assertTrue(Html::div('okej')->addAttr('name', 'myDiv')->addAttr('type', 'normal') == '<div name="myDiv" type="normal">okej</div>');
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal')->addAttr('Class', 'btn') == '<div name="myDiv" type="normal" class="btn"></div>');
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal')->addAttr('Class', 'btn')->removeAttr('name') == '<div type="normal" class="btn"></div>');
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal')->addAttr('Class', 'btn')->getAttrValue('name') == 'myDiv');
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal')->addAttr('Class', 'btn')->hasAttr('type'));
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal')->addAttr('Class', 'btn')->hasAttr('class'));
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('type', 'normal')->addAttr('Class', 'btn')->hasAttr('Class'));
		
		$this->assertNotTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('Class', 'btn')->addAttr('type', 'normal')->removeAttr('class')->hasAttr('Class'));
		
	}
	
	/**
	 * @dataProvider HtmlProvider
	 */
	public function testId($html)
	{
		$this->assertTrue(Html::div()->addAttr('Id', 'myId') == '<div id="myId"></div>');
		$this->assertTrue(Html::div()->addId('myId') == '<div id="myId"></div>');
		
		$this->assertTrue(Html::div('ok')->addClass('toBottom')->addId('myId')->addClass('toCenter') == '<div id="myId" class="toBottom toCenter">ok</div>');
		
		$this->assertNotTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('Class', 'btn')->addAttr('type', 'normal')->removeAttr('class')->hasAttr('Id'));
		$this->assertNotTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('Class', 'btn')->addAttr('type', 'normal')->removeAttr('class')->hasId());
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('Class', 'btn')->addId('myId')->addAttr('type', 'normal')->removeAttr('class')->hasAttr('id'));
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('Class', 'btn')->addId('myId')->addAttr('type', 'normal')->removeAttr('class')->hasId());
		
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('Class', 'btn')->addAttr('Id', 'myId')->addAttr('type', 'normal')->removeAttr('class')->hasAttr('Id'));
		$this->assertTrue(Html::div()->addAttr('name', 'myDiv')->addAttr('Class', 'btn')->addAttr('Id', 'myId')->addAttr('type', 'normal')->removeAttr('class')->hasId('Id'));
		
		$this->assertTrue(Html::div()->addId('idDiv')->ul()->li()->getParent()->li()->getParent()->li()->getParent()->addId('idUl')->getLast()->addId('idLastLi') == '<div id="idDiv"><ul id="idUl"><li></li><li></li><li id="idLastLi"></li></ul></div>');
		
		$this->assertTrue(Html::div()->addId('idDiv')->ul()->li()->getParent()->li()->getParent()->li()->getParent()->addId('idUl')->getFirst(2)->addId('idMiddleLi') == '<div id="idDiv"><ul id="idUl"><li></li><li id="idMiddleLi"></li><li></li></ul></div>');
		
		$this->assertTrue(Html::div()->addId('idDiv')->ul()->li()->getParent()->li()->getParent()->li()->getParent()->addId('idUl')->getFirst(2)->addId('idMiddleLi')->idExists('idMiddleLi'));
		$this->assertNotTrue(Html::div()->addId('idDiv')->ul()->li()->getParent()->li()->getParent()->li()->getParent()->addId('idUl')->getFirst(2)->addId('idMiddleLi')->b('bolded text')->idExists('idMiddleLi'));
		$this->assertTrue(Html::div()->addId('idDiv')->ul()->li()->getParent()->li()->getParent()->li()->getParent()->addId('idUl')->getFirst(2)->addId('idMiddleLi')->b('bolded text')->idExistsPrimary('idMiddleLi'));
		$this->assertTrue(Html::div()->addId('idDiv')->ul()->li()->getParent()->li()->getParent()->li()->getParent()->addId('idUl')->getFirst(2)->addId('idMiddleLi')->b('bolded text')->getPrimary()->idExists('idMiddleLi'));

		$this->assertTrue($html == '<div id="idContainer"><div id="idSubContainer1" class="subContainer backgroundRed"><ul><li>first</li><li>second</li><li class="lastLi">third</li></ul></div><div id="idSubContainer2"></div></div>');
		$this->assertTrue($html->idExistsPrimary('idSubContainer2'));
		$this->assertNotTrue($html->idExists('idSubContainer2'));
		
		$this->expectExceptionMessage('Invalid tag ID');
		$html->idExists('idSubContainer!');
		
		$this->expectExceptionMessage('ID already exists in this HTML object');
		$html->addId('idContainer');
	}
		
	public function HtmlProvider()
	{
		return [
			[
				Html::div()->addId('idContainer')
							->div()->addId('idSubContainer1')->getParent()
							->div()->addId('idSubContainer2')->getParent()->getFirst()
							->addClass('subContainer')
							->addClass('backgroundRed')
									->ul()
										->li('first')->getParent()
										->li('second')->getParent()
										->li('third')->addClass('lastLi')
			]
		];
	}
		
	public function testClass()
	{
		$this->assertTrue(Html::ul()->addClass('toCenter') == '<ul class="toCenter"></ul>');
		
		$this->assertTrue(Html::ul()->addClass('toCenter')->removeClass('toCenter') == '<ul></ul>');
		
		$this->assertTrue(Html::ul()->addClass('toCenter')->removeClass('toCenter')->addClass('toRight') == '<ul class="toRight"></ul>');
		
		$this->assertTrue(Html::button()->addClass('btn')->addClass('btn-primary') == '<button class="btn btn-primary"></button>');
		
		$this->assertTrue(Html::button()->addClass('btn')->addClass('btn-primary')->addClass('btn-success')->removeClass('btn-primary') == '<button class="btn btn-success"></button>');
		
		$this->assertTrue(Html::button()->addClass('btn')->addClass('btn-primary')->addClass('btn-icon')->hasClass('btn'));
		
		$this->assertNotTrue(Html::button()->addClass('btn')->addClass('btn-primary')->addClass('btn-icon')->removeClass('btn')->hasClass('btn'));
	}

	/**
	 * @dataProvider HtmlProvider
	 */
	public function testStyle($html)
	{
		$this->assertTrue(Html::div()->addStyle('background', '#000') == '<div style="background: #000;"></div>');
		
		$this->assertTrue(Html::div()->addStyle(['background' => '#333', 'color' => '#FFF']) == '<div style="background: #333; color: #FFF;"></div>');
		
		$this->assertTrue(Html::div()->addStyle(['background' => '#333', 'color' => '#FFF', 'font-weight' => 'bold'])->removeStyle('color') == '<div style="background: #333; font-weight: bold;"></div>');
		
		$this->assertTrue($html == '<div id="idContainer"><div id="idSubContainer1" class="subContainer backgroundRed"><ul><li>first</li><li>second</li><li class="lastLi">third</li></ul></div><div id="idSubContainer2"></div></div>');
		
		$this->assertTrue($html->getParent()->addStyle(['margin' => '0', 'padding' => '0']) == '<div id="idContainer"><div id="idSubContainer1" class="subContainer backgroundRed"><ul style="margin: 0; padding: 0;"><li>first</li><li>second</li><li class="lastLi">third</li></ul></div><div id="idSubContainer2"></div></div>');
		
		$this->assertTrue($html->getParent()->addStyle(['margin' => '10px auto', 'padding' => '0'])->addStyle('background', '#000')->removeStyle('padding') == '<div id="idContainer"><div id="idSubContainer1" class="subContainer backgroundRed"><ul style="margin: 10px auto; background: #000;"><li>first</li><li>second</li><li class="lastLi">third</li></ul></div><div id="idSubContainer2"></div></div>');
		
		$this->expectExceptionMessage('Tag hasn\'t style defined: "padding".');
		$html->getParent()->removeStyle('padding');
		
		$this->assertTrue($html->hasStyle('background'));
		$this->assertTrue($html->hasStyle('margin'));
		$this->assertNotTrue($html->hasStyle('padding'));
		
		$this->assertTrue($html->getStyle('background') == '#000');
		$this->assertTrue($html->getStyle('margin') == '10px auto');
	}
}