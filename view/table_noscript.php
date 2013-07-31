<?php

$noscript = "";
$noscript .= "<div class='tttablectrl'></div><div class='tttablediv'><table class='tttable'>
    <thead><tr><th>ID</th><th>Name</th><th>Gender</th><th>Parents</th><th>Children</th><th>Events</th></tr></thead><tbody>";
foreach($ancestors as $id => $ancestor){
    $id = htmlentities($id);
    $noscript .= "<tr id='$id'>";

    // ID
    $noscript .= "<td>$id</td>";

    // names
    $noscript .= "<td><a class='ttindipage' href='" . linky("individual.php/$id/" . htmlentities(trim(preg_replace("/-+/",'-',preg_replace("/[^a-zA-Z0-9\.]/",'-',$ancestor['name'])),'-'))) . "'>";
    foreach($ancestor['names'] as $name){
        $noscript .=   preg_replace('|/(.*)/|',"<span class='ttln'>$1</span>",htmlentities($name)) ;
    }
    $noscript .= "</a></td>";

    // Gender
    $noscript .= "<td>" . $ancestor['gender'] . "</td>";

    // Parents
    $noscript .= "<td>";
    if(array_key_exists('fathers',$ancestor)){
        $noscript .= "<ul>";
        foreach($ancestor['fathers'] as $father){
            $noscript .= "<li class='ttnowrap'><a class='ttpersonlink' href='#" . htmlentities($father) . "'>" .  preg_replace('|/(.*)/|',"<span class='ttln'>$1</span>",htmlentities($ancestors[$father]['name'])) . "</a></li>";
        }
        $noscript .= "</ul>";
    }
    if(array_key_exists('mothers',$ancestor)){
        $noscript .= "<ul>";
        foreach($ancestor['mothers'] as $mother){
            $noscript .= "<li class='ttnowrap'><a class='ttpersonlink' href='#{$mother}'>" .  preg_replace('|/(.*)/|',"<span class='ttln'>$1</span>",htmlentities($ancestors[$mother]['name'])) . "</a></li>";
        }
        $noscript .= "</ul>";
    }
    $noscript .= "</td>";

    // Children 
    $noscript .= "<td>";
    if(array_key_exists('children',$ancestor)){
        $noscript .= "<ul>";
        foreach($ancestor['children'] as $child => $spouse){
            $noscript .= "<li class='ttnowrap'><a class='ttpersonlink' href='#{$child}'>" .  preg_replace('|/(.*)/|',"<span class='ttln'>$1</span>",htmlentities($ancestors[$child]['name'])) . "</a></li>";
        }
        $noscript .= "</ul>";
    }
    $noscript .= "</td>";

    // Events
    $noscript .= "<td>";
    if(array_key_exists('events',$ancestor)){
        $noscript .= "<ul>";
        foreach($ancestor['events'] as $event){
            $noscript .= "<li class='ttevent'>";
            $noscript .= "{$event['type']}: ";
            if(array_key_exists('date',$event)){
                $noscript .= htmlentities($event['date']['raw']) . " ";
            }
            if(array_key_exists('place',$event)){
                $noscript .= htmlentities($event['place']['raw']);
            }
            $noscript .= "</li>";
        }
        $noscript .= "</ul>";
    }
    $noscript .= "</td>";
    $noscript .= "</tr>";
}
$noscript .= "</tbody></table></div>";

print $noscript;
