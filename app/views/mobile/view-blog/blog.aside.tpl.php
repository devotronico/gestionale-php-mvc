<aside>
<div id="about" class="aside-box">
    <h4 class="aside-title">About</h4>
    <p id="about-descr">Etiam porta sem malesuada magna mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
</div>
<div id="date" class="aside-box">
    <h4 class="aside-title">Archivio</h4>
<?php               
$year = $month = '';
//echo '<pre>', print_r($dates) ,'</pre>';
foreach( $dates as $date){ 

$temp = explode(" ", $date['dateformatted']);

if ( $year != $temp[2] ) { 
if ( $year != '' ) {  ?> 
</ul>
<?php      }
$year = $temp[2];  ?> 
<p class="aside-year"><?=$year?></p>
<ul id="date-list" class="aside-list">
<?php   }

if ( $month != $temp[1] ) { 

$month = $temp[1]; ?> 
<li class="aside-item"><a class="aside-link" href="/blog/<?=$month?>/<?=$year?>/"><?=$month?></a></li>
<?php }} ?> 
</div>
<div id="tags" class="aside-box">
    <h4 class="aside-title">Tags</h4>
    <ul id="tags-list" class="aside-list">
        <li class="aside-item"><a class="aside-link" href="blog/tag/news/">News</a></li>
        <li class="aside-item"><a class="aside-link" href="blog/tag/web/">Web</a></li>
        <li class="aside-item"><a class="aside-link" href="blog/tag/tech/">Tech</a></li>
        <li class="aside-item"><a class="aside-link" href="blog/tag/girls/">Girls</a></li>
        <li class="aside-item"><a class="aside-link" href="blog/tag/food/">Food</a></li>
    </ul>
</div>
</aside>



















