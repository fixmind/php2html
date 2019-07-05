# Html Generator
```php

// EXAMPLE 01
echo Html::ul()->li('first point')->getParent()->li('second point');
// <ul>
//     <li>first point</li>
//     <li>second point</li>
// </ul>

// EXAMPLE 02
echo Html::div()->h1('title')->addId('title')->getParent()->p('just text')->addClass('normal')->addStyle(['color' => 'red']);
// <div>
//     <h1 id="title">title</h1>
//     <p class="normal" style="color: red;">just text</p>
// </div>

// EXAMPLE 03
$html = Html::div()->addClass('box')->ul()->li('first')->getParent()->li('second')->getParent()->li('third')->getParent()->getFirst(2)->ul()->li('subFirst')->getParent()->li('subSecond');
echo $html;
// <div class="box">
//    <ul>
//      <li>first</li>
//      <li>
//          second
//          <ul>
//              <li>subFirst</li>
//              <li>subSecond</li>
//          </ul>
//      </li>
//      <li>third</li>
//    </ul>
// </div>

```

# Use Selector to modified
```php

// EXAMPLE 01
// $html from previous example
$html->selectorFirst('ul ul')->addClass('sub');
$html->selectorLast('ul ul li')->addId('subLastId');
echo $html;
// <div class="box">
//     <ul>
//         <li>first</li>
//         <li>second
//             <ul class="sub">
//                 <li>subFirst</li>
//                 <li id="subLastId">subSecond</li>
//             </ul>
//         </li>
//         <li>third</li>
//     </ul>
// </div>

// EXAMPLE 02
$html->selectorFirst('ul.sub')->li('subThird');
$html->selectorFirst('#subLastId')->addText('!!!');
echo $html;
// <div class="box">
//     <ul>
//         <li>first</li>
//         <li>second
//             <ul class="sub">
//                 <li>subFirst</li>
//                 <li id="subLastId">subSecond!!!</li>
//                 <li>subThird</li>
//             </ul>
//         </li>
//         <li>third</li>
//     </ul>
// </div>

// EXAMPLE 03
foreach($html->selector('ul') as $ul)
{
    $ul->addClass('myUl');
}
echo $html;
// <div class="box">
//     <ul class="myUl">
//         <li>first</li>
//         <li>second
//             <ul class="sub myUl">
//                 <li>subFirst</li>
//                 <li id="subLastId">subSecond!!!</li>
//                 <li>subThird</li>
//             </ul>
//         </li>
//         <li>third</li>
//     </ul>
// </div>

```