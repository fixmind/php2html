<?php

/**
 * PhpToHtml 1.0.2
 * Copyright 2019 Michal Barcikowski
 * Available via the MIT or new BSD @license.
 * Project: https://github.com/fixmind/phptohtml/
 */
namespace FixMind\PhpToHtml\Tests;

use FixMind\PhpToHtml\Html;
use FixMind\PhpToHtml\Selector;
use FixMind\PhpToHtml\Selector\SelectorModel;

class SelectorTest extends \PHPUnit\Framework\TestCase
{
	
	public function testSelectorModel()
	{
		$this->assertTrue((new SelectorModel('')) == '');
		
		$this->assertTrue((new SelectorModel('span')) == 'span');
		
		$this->assertTrue((new SelectorModel('span#idObject')) == 'span#idObject');
		$this->assertTrue((new SelectorModel('span#idObject.mark.special')) == 'span#idObject.mark.special');
		$this->assertTrue((new SelectorModel('span#idObject.mark.special.superSpecial')) == 'span#idObject.mark.special.superSpecial');
		
		$this->assertTrue((new SelectorModel('span.mark')) == 'span.mark');	
		$this->assertTrue((new SelectorModel('span.mark.special')) == 'span.mark.special');
		$this->assertTrue((new SelectorModel('span.mark.special.superSpecial')) == 'span.mark.special.superSpecial');
		
		$this->assertTrue((new SelectorModel('#idObject')) == '#idObject');
		$this->assertTrue((new SelectorModel('#idObject.mark')) == '#idObject.mark');
		$this->assertTrue((new SelectorModel('#idObject.mark.special')) == '#idObject.mark.special');
		$this->assertTrue((new SelectorModel('#idObject.mark.special.superSpecial')) == '#idObject.mark.special.superSpecial');
		
		$this->assertTrue((new SelectorModel('.class')) == '.class');
		$this->assertTrue((new SelectorModel('.class.moreClass')) == '.class.moreClass');
		$this->assertTrue((new SelectorModel('.class.moreClass.nextMoreClass')) == '.class.moreClass.nextMoreClass');
		$this->assertTrue((new SelectorModel('.class.moreClass.nextMoreClass.superSpecial')) == '.class.moreClass.nextMoreClass.superSpecial');
	}
	
	/**
	 * @dataProvider HtmlProvider
	 */
	public function testSelector($html)
	{
		// 1
		$this->assertTrue($html->selectorFirst('li.lastLi')->render() == '<li class="lastLi">last third</li>');
		$this->assertTrue($html->selectorFirst('li')->render() == '<li class="firstClass">first li</li>');

		$this->assertTrue($html->selectorLast('#idSubContainer1 li')->render() == '<li id="idThird">first third</li>');
		$this->assertTrue($html->selectorLast('#idSubContainer1 li', 1)->render() == '<li id="idThird">first third</li>');
		$this->assertTrue($html->selector('#idSubContainer1 li', -1)->render() == '<li id="idThird">first third</li>');

		$this->assertTrue($html->selectorLast('#idSubContainer2 li.firstClass') == false);
		$this->assertTrue($html->selectorLast('#idSubContainer2 li.firstClass', 1) == false);
		$this->assertTrue($html->selector('#idSubContainer2 li.firstClass', -1) == false);

		$this->assertTrue($html->selectorFirst('#idSubContainer2 li')->render() == '<li>first</li>');
		$this->assertTrue($html->selectorFirst('#idSubContainer2.subContainer li')->render() == '<li>first</li>');
		$this->assertTrue($html->selectorFirst('#idSubContainer2.subContainer.backgroundRed li')->render() == '<li>first</li>');
		$this->assertTrue($html->selectorFirst('#idSubContainer2.backgroundRed.subContainer li')->render() == '<li>first</li>');
		$this->assertTrue($html->selectorFirst('#idSubContainer2.backgroundRed.subContainer li')->getContent() == 'first');
		$this->assertTrue($html->selectorFirst('.backgroundRed.subContainer li')->getContent() == 'first');
		$this->assertTrue($html->selectorFirst('.subContainer.backgroundRed li')->getContent() == 'first');
		$this->assertTrue($html->selectorFirst('.backgroundRed li')->getContent() == 'first');
		$this->assertTrue($html->selectorFirst('.backgroundRed li')->getContent() == 'first');
		$this->assertTrue($html->selectorFirst('.backgroundRed li', 1)->getContent() == 'first');
		$this->assertTrue($html->selector('.backgroundRed li', 1)->getContent() == 'first');
		$this->assertTrue($html->selectorFirst('.subContainer li')->getContent() == 'first');
		$this->assertTrue($html->selector('.subContainer li', 1)->getContent() == 'first');
		$this->assertTrue($html->selector('.subContainer li', -1)->getContent() == 'last third');
		$this->assertTrue($html->selector('.subContainer li', -2)->getContent() == 'second');
		$this->assertTrue($html->selector('.subContainer li', 2)->getContent() == 'second');
		$this->assertTrue($html->selectorFirst('.subContainer.notExists li') == false);
		
		// 2
		$html->selectorFirst('#idSubContainer2.backgroundRed ul')->addId('specialUl')->selectorFirst('.firstClass')->addId('idFirstClass');
		$this->assertTrue($html->selectorFirst('#specialUl li')->getContent() == 'first');
		
		// 3
		$found = $html->selector('.backgroundRed li');
		$this->assertTrue($found[1]->getContent() == 'second');
		$found[1]->addClass('secondLiClass');
		$found[2]->removeClass('lastLi')->addClass('thirdClass');
		$this->assertTrue($html->selectorFirst('.lastLi') == false);
		$this->assertTrue($html->selectorFirst('.thirdClass')->getContent() == 'last third');
	}

	/**
	 * @dataProvider HtmlProvider
	 */
	public function testException($html)
	{
		$this->assertTrue(count($html->selector('#idSubContainer1 li')) == 3);

		$this->expectExceptionMessage('Selector index');
		$html->selectorLast('#idSubContainer1 li', 4);

		$this->expectExceptionMessage('Selector index');
		$html->selectorLast('#idSubContainer1 li', -2);
	}

	public function HtmlProvider()
	{
		return [
			[
				Html::div()->addId('idContainer')
					->div()->addId('idSubContainer1')
						->ul()
							->li('first li')->addClass('firstClass')->getParent()
							->li('second')->getParent()
							->li('first third')->addId('idThird')->getParent()->getParent()->getParent()
					->div()->addId('idSubContainer2')
						->addClass('subContainer')
						->addClass('backgroundRed')
							->ul()
								->li('first')->getParent()
								->li('second')->getParent()
								->li('last third')->addClass('lastLi')
			]
		];
	}	
}