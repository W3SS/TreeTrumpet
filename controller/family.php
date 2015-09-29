<?php

function family($familyId){
    $gedcom = model('ttgedcom',Array(__FILE__ . '/../family.ged'));

    $family = $gedcom->getFamily($familyId);

    if(!$family){
        return controller('_404',Array("Family $familyId"));
    }

    $familyName = $family->familyName();

    $page = model('page');

    controller('standard_meta_tags',Array(&$gedcom,&$page));

    $page->description .= "The family of " . $familyName;

    foreach($family->lastNames() as $surname){
        $page->keywords[] = $surname;
    }

    $page->canonical($family->link());
    $page->css("//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css");
    $page->css("css/tabs.css");
    $page->title("All about $familyName");
    $page->h1("All about $familyName");

    $details = "";
    $navigation = "<ul>";

    $parents = $family->parents();
    if($parents != ''){
        $navigation .= "<li><a href='#couples'>Couples</a></li>";
        $details .= $parents;
    }

    $children = $family->children();
    if($children != ''){
        $navigation .= "<li><a href='#children'>Children</a></li>";
        $details .= $children;
    }

    $events = $family->events();
    if($events != ''){
        $navigation .= "<li><a href='#events'>Events</a></li>";
        $details .= $events;
    }

    $refs = $family->references();
    if($refs != ''){
        $navigation .= "<li><a href='#references'>References and Sources</a></li>";
        $details .= $refs;
    }

    $notes = $family->notes();
    if($notes != ''){
        $navigation .= "<li><a href='#notes'>Notes</a></li>";
        $details .= $notes;
    }

    $mm = $family->multimedia();
    if($mm != ''){
        $navigation .= "<li><a href='#multimedia'>Multimedia</a></li>";
        $details .= $mm;
    }

    $md = $family->metadata();
    if($md != ''){
        $navigation .= "<li><a href='#metadata'>Metadata</a></li>";
        $details .= $md;
    }

    // Most people probably won't want this online
    // $ord = $family->ordinances();
    // if($ord != ''){
    //     $navigation .= "<li><a href='#ordinances'>Ordinances</a></li>";
    //     $details .= $ord;
    // }

    $navigation .= "</ul>";

    $page->body = $navigation . $details;

    $scripts = Array(
        "//code.jquery.com/jquery-1.11.3.min.js",
        "//code.jquery.com/ui/1.11.4/jquery-ui.min.js",
        "js/tabs.js",
    );

    foreach($scripts as $script){
        $page->js($script);
    }

    view('page',Array('page' => $page,'menu' => 'family'));
}
