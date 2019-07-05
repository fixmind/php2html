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

use fixmind\PhpToHtml\Html;

$div = Html::Create('pre')
			->addTag('div')->addText('Hello World!')
				->addTag('a')->addText('to jest link')->getParent()
				->addTag('b')->addAttr('color', '#AC0000')->addText('to na prawdę działa!')
				->addTag('span')->addText('To jest')->addTag('i')->addText('italic')->getParent()->addText('.')
				->getParent()->getParent()
				->addText(' Super!')
				->addTag('ul')->addId('idUl')
					->addTag('li')->addText('to punkt pierwszy')->getParent()
					->addTag('li')->addClass('mark')->addText('to jest punkt drugi')->getParent()
					->addText('taki text tutaj')
					->addTag('li')->addText('kolejny trzeci punkt')->getParent()
					->addText('taki text tutaj')
					->addTag('li')->addText('czwarty element')
					->getParent()->getFirst()->addText('[firstELEMENT]')
					->getParent()->getLast()->addText('[lastElement]')
					->getParent()->getLast(3)->addText('[trzeciElementOdKonca]')->addClass('thirdElement')->addId('specialElement')
					->getParent()->getLastTag(3)->addText('[trzeciTagOdKonca]')
					->getParent()->getFirstTag(3)->addText('[trzeciTagOdPoaczatku]')
					->getParent()->getFirst(4)->addText('[czwartyElementOdPoczatku]')
						->addTag('ul')->addClass('thisOne')
							->li('x')->getParent()
							->li('x2')->getParent()
							->li('y')
								->ul()
									->li('q')->getParent()
									->li('w')->a('link')->getParent()->getParent()
									->li('e')->getParent()->getParent()->getParent()
							->li('z')->getParent()
							->li('v');

$found = $div->selector('.thisOne ul li');
$found[1]->addClass('wClass');
echo $div;

