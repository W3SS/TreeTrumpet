<?php
function _404($requested){
    $page = model('page');

    $page->title("Page Not Found!");
    $page->h1("You asked for <em>$requested</em>, but it isn't here!");
    $page->body .= "<p>You're searching for your ancestors, and we're searching for this lost page!</p>";
    $page->body .= "<p>Sorry the page you requested wasn't found. You can try a link above ";
    $page->body .= "or you can try contacting the site owner.</p>";
    $page->body .= "<p>If you ARE the site owner you can contact <a href='http://treetrumpet.com/'>TreeTrumpet</a> for support.</p>";
    view('page',Array('page' => $page));
}
