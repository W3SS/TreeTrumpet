<?php 
if(!isset($menu)){
    $menu = '';
}
view('page_header',Array('page' => $page,'menu' => $menu)); ?>
<article>
    <div class='tt-content'>
    <?php 
    print $page->body;
    print $page->bodyright;
    ?>
    </div>
</article>
<?php view('page_footer',Array('page' => $page,'menu' => $menu)); 
