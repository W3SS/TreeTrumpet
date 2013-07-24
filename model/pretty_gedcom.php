<?php

class pretty_gedcom {
    static function findObje($id){
        global $parsedgedcom;
        foreach($parsedgedcom->getObje() as $obje){
            if($obje->hasAttribute('id') && $obje->getId() == $id){
                return $obje;
            }
        }
        return FALSE;
    }

    static function findFam($id){
        global $parsedgedcom;
        foreach($parsedgedcom->getFam() as $fam){
            if($fam->hasAttribute('id') && $fam->getId() == $id){
                return $fam;
            }
        }
        return FALSE;
    }

    static function findIndi($id){
        global $parsedgedcom;
        foreach($parsedgedcom->getIndi() as $indi){
            if($indi->hasAttribute('id') && $indi->getId() == $id){
                return $indi;
            }
        }
        return FALSE;
    }

    static function printOrdinance($ord){
        $ret = '';
        $ret .= "<dl>";

        if($stat = $ord->getStat()){
            $ret .= "<dt>Status</dt><dd>$stat</dd>";
        }
        if($date = $ord->getdate()){
            $ret .= "<dt>Date</dt><dd>$date</dd>";
        }
        if($plac = $ord->getPlac()){
            $ret .= "<dt>Place</dt><dd>$plac</dd>";
        }
        if($temp = $ord->getTemp()){
            $ret .= "<dt>Temple</dt><dd>$temp</dd>";
        }
        if($sours = $ord->getSour()){
            $ret .= "<dt>Sources</dt><dd>";
            foreach($sours as $sour){
                 $ret .= pretty_gedcom::printSour($sour);
            }
            $ret .= "</dd>";
        }

        if($notes = $ord->getNote()){
            $ret .= "<dt>Note</dt><dd>";
            foreach($notes as $note){
                 $ret .= pretty_gedcom::printNote($note);
            }
            $ret .= "</dd>";
        }

        $ret .= "</dl>";
        return $ret;
    }

    static function printChan($chan){
        $ret = '';
        $ret .= "<dl>";
        if($date = $chan->getDate()){
            $ret .= "<dt>Date</dt><dd>$date</dd>";
        }
        if($time = $chan->getTime()){
            $ret .= "<dt>Time</dt><dd>$time</dd>";
        }
        if($notes = $chan->getNote()){
            $ret .= "<dt>Notes</dt><dd>";
            foreach($notes as $note){
                 $ret .= pretty_gedcom::printNote($note);
            }
            $ret .= "</dd>";
        }
        $ret .= "</dl>";
        return $ret;
    }

    static function printFamc($fam,$selfId){
        $ret = '';

        $ret .= "<ul>";

        if($fam->hasAttribute('famc') && $famc = $fam->getFamc()){
            $ret .= "<li><a href='family.php?id=$famc'>Family $famc</a></li>";
            $cfam = findFam($famc);

            if($cfam && $wife = $cfam->getWife()){ 
                $wife = findIndi($wife);
                $name = "Wife {$wife->getId()}";
                if($names = $wife->getName()){
                    $name = $names[0]->getName();
                }
                $ret .= "<dt>Mother</dt><dd><a href='individual.php?id={$wife->getId()}'>$name</a></dd>";
            }

            if($cfam && $husb = $cfam->getHusb()){ 
                $husb = findIndi($husb);
                $name = "Husb {$husb->getId()}";
                if($names = $husb->getName()){
                    $name = $names[0]->getName();
                }
                $ret .= "<dt>Father</dt><dd><a href='individual.php?id={$husb->getId()}'>$name</a></dd>";
            }

            if($cfam && $chils = $cfam->getChil()){
                $ret .= "<dt>Children</dt><dd><ol>";
                foreach($chils as $chil){
                    $chil = findIndi($chil);
                    $name = "Child {$chil->getId()}";
                    if($names = $chil->getName()){
                        $name = $names[0]->getName();
                    }
                    if($chil->getId() == $selfId){
                        $name .= " (self) ";
                    }
                    $ret .= "<li><a href='individual.php?id={$chil->getId()}'>$name</a></li>";

                }
                $ret .= "</ol></dd>";
            }
        }

        if($fam->hasAttribute('pedi') && $pedi = $fam->getPedi()){
            $ret .= "HANDLE PEDI";
        }

        if($notes = $fam->getNote()){
            $ret .= "<li><h3>Notes</h3><li>";
            foreach($notes as $note){
                 $ret .= pretty_gedcom::printNote($note);
            }
            $ret .= "</li>";
        }

        $ret .= "</ul>";
        return $ret;
    }

    static function printFams($fam,$selfId){
        $ret = '';

        $ret .= "<ul>";

        // Turn a family reference into a de-referenced family
        if($fam->hasAttribute('fams') && $fams = $fam->getFams()){
            $ret .= "<li><a href='family.php?id=$fams'>Family $fams</a><dl>";
            $sfam = findFam($fams);

            if($sfam && $wife = $sfam->getWife()){ 
                $wife = findIndi($wife);
                $name = "Wife {$wife->getId()}";
                if($names = $wife->getName()){
                    $name = $names[0]->getName();
                }
                if($wife->getId() == $selfId){
                    $self = " (self) ";
                }else{
                    $self = '';
                }
                $ret .= "<dt>Wife$self</dt><dd><a href='individual.php?id={$wife->getId()}'>$name</a></dd>";
            }

            if($sfam && $husb = $sfam->getHusb()){ 
                $husb = findIndi($husb);
                $name = "Husb {$husb->getId()}";
                if($names = $husb->getName()){
                    $name = $names[0]->getName();
                }
                if($husb->getId() == $selfId){
                    $self = " (self) ";
                }else{
                    $self = '';
                }
                $ret .= "<dt>Husband$self</dt><dd><a href='individual.php?id={$husb->getId()}'>$name</a></dd>";
            }

            if($sfam && $chils = $sfam->getChil()){
                $ret .= "<dt>Children</dt><dd><ol>";
                foreach($chils as $chil){
                    $chil = findIndi($chil);
                    $name = "Child {$chil->getId()}";
                    if($names = $chil->getName()){
                        $name = $names[0]->getName();
                    }
                    if($chil->getId() == $selfId){
                        $name .= " (self) ";
                    }
                    $ret .= "<li><a href='individual.php?id={$chil->getId()}'>$name</a></li>";

                }
                $ret .= "</ol></dd>";
            }

            $ret .= "</ul></li>";
        }

        if($fam->hasAttribute('pedi') && $pedi = $fam->getPedi()){
            $ret .= "HANDLE PEDI";
        }

        if($notes = $fam->getNote()){
            $ret .= "<li><h3>Notes</h3><li>";
            foreach($notes as $note){
                 $ret .= pretty_gedcom::printNote($note);
            }
            $ret .= "</li>";
        }

        $ret .= "</ul>";
        return $ret;
    }

    static function printObje($obje){

        if($obje->getIsReference()){
            $obje = findObje($obje->getObje());
        }

        $ret = '';
        $ret .= "<ul>";

        $form = $obje->getForm();
        $titl = $obje->getTitl();

        if($obje->hasAttribute('file') && $file = $obje->getFile()){

            // File type
            // $mime = `file -bi $file  | sed 's/;.*//'`;
            if(file_exists($file)){
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mimeType = finfo_file($finfo, $file);

                $browserImages = Array(
                    'image/jpeg',
                    'image/gif',
                    'image/png',
                );

                $browserVideos = Array(
                    'video/mp4',
                    'video/webm',
                    'video/ogg',

                );

                $browserAudio = Array(
                    'audio/mpeg',
                    'audio/ogg',
                    'audio/wav',
                    'audio/x-wav',
                );

                if(in_array($mimeType,$browserImages)){
                    $ret .= "<li><a href='$file'><img alt='".$obje->getTitl()."'src='lib/thumbnail.php?img=" . urlencode($file) . "'/></a></li>";
                }else if(in_array($mimeType,$browserAudio)){
                    if($titl){
                        $target = $titl;
                    }else{
                        $target = $file;
                    }

                    $ret .= "<li><a title='$titl' alt='$titl'  href='$file'>$titl</a><br>";
                    $ret .= "<audio controls><source src='$file' type='$mimeType'>Your browser does not support the HTML5 audio element.</audio>";
                    $ret .= "</li>";
                }else if(in_array($mimeType,$browserVideos)){
                    if($titl){
                        $target = $titl;
                    }else{
                        $target = $file;
                    }

                    $ret .= "<li><a title='$titl' alt='$titl'  href='$file'>$titl</a><br>";
                    $ret .= "<video height='400' controls><source src='$file' type='$mimeType'>Your browser does not support the HTML5 video tag.</video>";
                    $ret .= "</li>";
                } else {

                    if($titl){
                        $target = $titl;
                    }else{
                        $target = $file;
                    }

                    $ret .= "<li><a title='$titl' alt='$titl'  href='$file'>$titl</a></li>";
                }


                // URL type
            }else if(filter_var($file,FILTER_VALIDATE_URL)){

                if($titl){
                    $target = $titl;
                }else{
                    $target = $file;
                }

                $ret .= "<li><a title='$titl' alt='$titl'  href='$file'>$target</a></li>";

                // Unknown
            }else{
                if(!$form){
                    $form = 'file';
                }
                if($titl){
                    $titl = ", titled <em>$titl</em>";
                }
                $ret .= "<li>Oh no! This $form$titl can't be found. Please <a href='contact.php'>ask the owner of this website</a> to upload it or fix the link!</li>";
            }
        }else if($obje->hasAttribute('blob') && $blob = $obje->getBlob()){
            $ret .= "<li>Please ask for support for embedded images, re-export your GEDCOM with linked images instead</li>";
        }

        if($notes = $obje->getNote()){
            $ret .= "<li><h3>Notes</h3>";
            foreach($notes as $note){
                $ret .=  $ret .= pretty_gedcom::printNote($note);
            }
            $ret .= "</li>";
        }

        if($obje->hasAttribute('chan') &&  $chan = $obje->getChan()){
            $ret .= "<li><h3>Changes</h3>";
            $ret .=  $ret .= pretty_gedcom::printChan($chan);
        }

        if($obje->hasAttribute('refn') && $refns = $obje->getRefn()){
            $ret .= "<li><h3>References</h3>";
            foreach($refns as $refn){
                $ret .=  $ret .= pretty_gedcom::printRefn($refn);
            }
            $ret .= "</li>";
        }

        if($obje->hasAttribute('rin') && $rin = $obje->getRin()){
            $ret .= "<li><h3>RIN</h3>$rin</li>";
        }

        $ret .= "</ul>";
        return $ret;
    }

    static function printRefn($refn){
        $ret = '';
        $ret .= "<dl>";
        if($refnum = $refn->getRefn()){
            $ret .= "<dt>Reference Number</dt><dd>$refnum</dd>";
        }
        if($type = $refn->getType()){
            $ret .= "<dt>Type</dt><dd>$type</dd>";
        }
        $ret .= "</dl>";
        return $ret;
    }

    // Every static function should $ret .= a set of closed and valid nodes
    static function printAsso($asso){
        $ret = '';
        $ret .= "<dl>";
        if($id = $asso->getIndi()){
            $ret .= "<dt>Associate ID</dt><dd>$id</dd>";
        }
        if($rela = $asso->getRela()){
            $ret .= "<dt>Relationship</dt><dd>$rela</dd>";
        }
        if($notes = $asso->getNote()){
            $ret .= "<dt>Notes</dt><dd>";
            foreach($notes as $note){
                 $ret .= pretty_gedcom::printNote($note);
            }
            $ret .= "</dd>";
        }
        if($sours = $asso->getSour()){
            $ret .= "<dt>Sources</dt><dd>";
            foreach($sours as $sour){
                $ret .=  $ret .= pretty_gedcom::printSour($sour); 
            }
            $ret .= "</dd>";
        }

        $ret .= "</dl>";
        return $ret;
    }

    static function printSubm($subm){
        $ret = '';
        if($name = $subm->getName()){
            $ret .= "<span>$name</span><br>";
        }

        if($addr = $subm->getAddr()){ 
            $ret .=  $ret .= pretty_gedcom::printAddr($addr);
        }

        if($phons = $subm->getPhon()){
            foreach($phons as $phon){
                $ret .=  $ret .= pretty_gedcom::printPhon($phon);
            }
        }
        return $ret;
    }

    static function printEven($even){
        $ret = '';
        $type = preg_replace("|.*\\\|",'',get_class($even));
        $ret .= "<h3>Type: $type</h3>";
        $ret .= "<span class='event'>";
        $ret .= "<dl>";
        if($even->hasAttribute('famc') && $famc = $even->getFamc()){
            $ret .= "<dt>Family ID</dt><dd>$famc</dd>";
        }
        if($even->hasAttribute('type') && $type = $even->getType()){
            $ret .= "<dt>Type</dt><dd>$type</dd>";
        }
        if($date = $even->getDate()){
            $ret .= "<dt>Date</dt><dd>$date</dd>";
        }
        if($plac = $even->getPlac()){
             $ret .= pretty_gedcom::printPlac($plac);
        }
        if($caus = $even->getCaus()){
            $ret .= "<dt>Cause</dt><dd>$caus</dd>";
        }
        if($age = $even->getAge()){
            $ret .= "<dt>Age</dt><dd>$age</dd>";
        }
        if($addr = $even->getAddr()){
             $ret .= pretty_gedcom::printAddr($addr);
        }
        $ret .= "</dl>";
        $ret .= "</span>";
        return $ret;
    }

    static function printAddr($addr){
        $ret = '';

        $address = Array();
        if($adr1 = $addr->getAdr1()){ 
            $address[] = $adr1; 
        }
        if($adr2 = $addr->getAdr2()){ 
            $address[] = $adr2; 
        }

        $stateLine = "";
        if($city= $addr->getCity()){ 
            $stateLine .= $city; 
        }

        if($stae = $addr->getStae()){ 
            if($stateLine == ""){
                $stateLine .= $stae;
            }else{
                $stateLine .= ", $stae";
            }
        }
        if($post = $addr->getPost()){ 
            if($stateLine == ""){
                $stateLine .= $post;
            }else{
                $stateLine .= " $post";
            }
        }
        if($stateLine != ""){
            $address[] = $stateLine;
        }

        if($ctry= $addr->getCtry()){ 
            $address[] = $ctry; 
        }

        if(count($address) > 0){
            $ret .= "<p>";
            $ret .= "<address>" . implode("<br>",$address) . "</address>";
            $ret .= "</p>";
        }
        return $ret;
    }

    static function printPhon($phon){
        $ret = '';
        if($ph = $phon->getPhon()){
            $ret .= "<span><a href='tel:$ph'>$ph</a></span>";
        }
        return $ret;
    }

    static function printPlac($plac){
        $ret = '';
        $ret .= "<dt>Place</dt><dd><p>";
        if($name = $plac->getPlac()){
            $ret .= "$name<br>";
        }
        if($form = $plac->getForm()){
            $ret .= "HANDLE FORM";
        }
        if($notes = $plac->getNote()){
            foreach($notes as $note){
                 $ret .= pretty_gedcom::printNote($note);
            }
        }
        if($sours = $plac->getSour()){
            foreach($sours as $sour){
                 $ret .= pretty_gedcom::printSour($sour);
            }
        }
        $ret .= "</dd>";
        return $ret;
    }

    static function printAttr($attr){
        $ret = '';
        $ret .= "<h3>Type: " . $attr->getType() . "</h3>";

        $ret .= "<dl>";
        if($attrText = $attr->getAttr()){
            $ret .= "<dt>Info</dt><dd>$attrText</dd>";
        }

        if($date = $attr->getDate()){
            $ret .= "<dt>Date</dt><dd>$date</dd>";
        }

        if($plac = $attr->getPlac()){
            $ret .= "<dt>Place</dt><dd>Place</dd>";
        }

        if($caus = $attr->getCaus()){
            $ret .= "<dt>Cause</dt><dd>$caus</dd>";
        }

        if($age = $attr->getAge()){
            $ret .= "<dt>Age</dt><dd>$age</dd>";
        }

        if($addr = $attr->getAddr()){
            $ret .= "<dt>Address</dt><dd>" .  $ret .= pretty_gedcom::printAddr($addr) . "</dd>";
        }

        if($phones = $attr->getPhon()){
            $ret .= "<dt>Phone Number</dt><dd>";
            foreach($phones as $phone){
                $ret .=  $ret .= pretty_gedcom::printPhon($phone);
            }
            $ret .= "</dd>";
        }

        if($agnc = $attr->getAgnc()){
            $ret .= "<dt>Agency</dt><dd>$agnc</dd>";
        }

        if($notes = $attr->getNote()){
            foreach($notes as $note){
                $ret .=  $ret .= pretty_gedcom::printNote($note);
            }
        }
        if($sours = $attr->getSour()){
            foreach($sours as $sour){
                $ret .=  $ret .= pretty_gedcom::printSour($sour);
            }
        }
        if($objes = $attr->getObje()){
            foreach($objes as $obje){
                $ret .=  $ret .= pretty_gedcom::printObje($obje);
            }
        }
        $ret .= "</dl>";
        return $ret;
    }

    static function printNote($note){
        $ret = '';
        $ret .= "<span class='note'>";
        //if($ref = $note->getIsRef()){
        //    $ret .= "Reference";
        //}
        if($text = $note->getNote()){
            $ret .= "<p>$text</p>";
        }
        if($sours = $note->getSour()){
            $ret .= "<h4>Sources</h4>";
            foreach($sours as $sour){
                 $ret .= pretty_gedcom::printSour($sour);
            }
        }
        $ret .= "</span>";
        return $ret;
    }

    static function printSour($sour){
        $ret = '';
        $ret .= "<dl>";
        if($sourid = $sour->getSour()){
            $ret .= "<dt>Source ID</dt><dd>$sourid</dd>";
        }
        if($page = $sour->getPage()){
            $ret .= "<dt>Page</dt><dd>$page</dd>";
        }
        if($even = $sour->getEven()){
            $ret .= "Handle even:";
        }
        if($data = $sour->getData()){
            $ret .= "<dt>Data<dl>";

            if($agnc = $data->getAgnc()){
                $ret .= "Handle AGNC";
            }
            if($date = $data->getDate()){
                $ret .= "<dt>Date</dt><dd>$date</dd>";
            }
            if($text = $data->getText()){
                $ret .= "<dt>Text</dt><dd>$text</dd>";
            }
            if($note = $data->getNote()){
                $ret .= "<dt>Note</dt><dd>$note</dd>";
            }
            $ret .= "</dl></dt>";
        }
        if($quay = $sour->getQuay()){
            $ret .= "<dt>Quay</dt><dd>$quay</dd>";
        }
        if($text = $sour->getText()){
            $ret .= "<dt>Text</dt><dd>$text</dd>";
        }
        if($obje = $sour->getObje()){
             $ret .= pretty_gedcom::printObje($obje);
        }
        if($notes = $sour->getNote()){
            $ret .= "<dt>Notes</dt><dd>";
            foreach($notes as $note){
                 $ret .= pretty_gedcom::printNote($note);
            }
            $ret .= "</dd>";
        }
        $ret .= "</dl>";
        return $ret;
    }
}
