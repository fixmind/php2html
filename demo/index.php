<?php

include('../src/Selector/SelectorSearch.php');
include('../src/Selector/SelectorModel.php');
include('../src/Selector/Selector.php');
include('../src/Tag/Style.php');
include('../src/Tag/ClassTag.php');
include('../src/Tag/Id.php');
include('../src/Tag/Attribute.php');
include('../src/Tag/Tag.php');
include('../src/Html.php');

use FixMind\PhpToHtml\Html;

// CREATION HTML STRUCTURE
$html = Html::pre()
			->div()
				->h1('Hello World')->addStyle('color', '#777')->getParent()
				->h2('Php')->addText('To')->addText('Html')->addStyle('color', '#AC0000')->getParent()
				->ul()->addId('idUl')
					->li('first point')->getParent()
					->li('second point')->addClass('mark')->getParent()
					->li('third point')->getParent()
					->li('fourth point')->getParent()
						->getFirst()->addText('[firstPoint]')->getParent()
						->getLast()->addText('[lastPoint]')->getParent()
						->getLast(3)->addText('[thirdPointFromLast]')->addClass('secondPoint')->addId('specialPoint')->getParent()
						->getFirstTag(3)->addText('[thirdPointFromFirst]')->getParent()
						->selectorFirst('.secondPoint')
						->ul()->addClass('subUl')
							->li('p1')->getParent()
							->li('p2')->getParent()
							->li('p3')
								->ul()
									->li('sub1')->getParent()
									->li()->strong('sub2')->addClass('markThis')->addStyle('color', '#AC0000')->getParent()->getParent()
									->li('sub3')->getParent()->getParent()->getParent()
							->li('p4')->getParent()
							->li('p5');

// MODIFICATIONS
$html->selectorFirst('.markThis')->addText('***');
$html->selectorFirst('.mark')->addText('***');
$html->selectorFirst('h1')->addText('!!!');
$html->selectorFirst('#specialPoint')->addStyle('list-style', 'circle');

$subListElement = $html->selector('.secondPoint li li');
foreach($subListElement as $tag)
{
	$tag->addStyle('background', '#FFFF88');
}

// ENTIRE OBJECT
echo $html;

// PART OF OBJECT
echo $html->selectorFirst('ul ul')->render();

