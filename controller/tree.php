<?php

$gedcom = model('ttgedcom',Array(__DIR__ . '/../family.ged'));

$ancestors = $gedcom->alphabeticByName();
$focusId = $gedcom->getFocusId();

$focus = $ancestors[$focusId];

$treeNav = "<p>Back to <a href='".$focus->link()."' onclick=\"return refocusTree('{$focusId}');\">" . $focus->firstBold() . "</a></p>";

$treeNav .= "<p style='display:none;'>Filter: <input type='text' id='autocomplete'/> (<span class='ttfakelink' id='searchhelp'>Help!</span>)</p>";

$treeNav .= "<ul class='ancestorlist'>";
foreach($ancestors as $id => $ancestor){
    $treeNav .= "<li><a href='".$ancestor->link()."' onclick=\"return refocusTree('$id');\">" . $ancestor->firstBold() . "</a></li>";
}
$treeNav .= "</ul>";


$hidden = "
<div id='details' style='display:none'>
    <h3>All about <span class='name'></span></h3>
    <p>
        <a id='refocuslink' onclick='pt.refocus(this.className);return false;' class='' href='#'>Focus Tree on Me</a><br>
        <a id='gotopage' href='#' class=''>See all details</a>
    </p>
    <h4>Gender</h3>
    <div class='gender'></div>
    <h4>Events</h4>
    <div class='events'></div>
</div>
<div id='help' style='display:none'>
    <h3>Filtering Help</h3>
        <p>Filtering is case-insensitive</p>
        <dl>
            <dt>^</dt>
                <dd>The start of the name</dd>
                <dd><em>^mar</em> will match <em>MariAnne</em>, but not <em>AnnaMarie</em></dd>
            <dt>$</dt>
                <dd>The end of the name</dd>
                <dd><em>ello$</em> will match <em>Ozzello</em>, but not <em>Ellos</em></dd>
            <dt>*</dt>
                <dd>Match 0 or more of the previous character</dd>
                <dd><em>mic*</em> will match both <em>Emil</em> and <em>Michael</em></dd>
            <dt>.</dt>
                <dd>Match any single character</dd>
                <dd><em>a.a</em> will match both <em>ana</em> and <em>ada</em></dd>
            <dt>.*</dt>
                <dd>Match any number of any character</dd>
                <dd><em>mc.*nn.*s</em> will match <em>McGinnis</em>, <em>McGuinness</em> and <em>McGennis</em></dd>
        </dl>
    <h4>Advanced Filtering</h4>
    <p>The filter uses case insensitive <a href='http://www.diveintojavascript.com/articles/javascript-regular-expressions'>JavaScript Regular Expressions</a>, have fun!</p>
</div>
";

$page = model('page');

$csses = Array(
    'http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css',
    'css/3rdparty/ui/ui.slider.css',
    'css/3rdparty/tree.css',
    'css/tree.css'
);

foreach($csses as $css){
    $page->css($css);
}

$scripts = Array(
    "js/3rdparty/excanvas.js",
    "http://code.jquery.com/jquery-1.9.1.js",
    "http://code.jquery.com/ui/1.10.3/jquery-ui.js",
    "js/3rdparty/jquery.mousewheel.js",
    "js/3rdparty/sharing-time.js",
    "js/3rdparty/sharing-time-ui.js",
    "js/3rdparty/sharing-time-chart.js",
    "js/3rdparty/jsZoom.js",
    "js/3rdparty/make_chart.js",
    "js/3rdparty/tree.js",
    "js/tree.js"
);

foreach($scripts as $script){
    $page->js($script);
}

$page->title("Treetrumpet Tree Demo");
$page->h1("Treetrumpet Tree Demo");
$page->body .= "<h2>The " . $focus->firstBold() . " Family Tree</h2>";
$page->body .= $treeNav;
$page->bodyright .= "<div id='tt-tree'>Please wait...loading</div>";
$page->hidden($hidden);

view('page_v_split',Array('page' => $page,'menu' => 'tree'));
