<?php

class submitter {
    var $submitter;
    var $pretty_gedcom;

    function __construct($submitter,$gedcom){
        $this->submitter = $submitter;
        $this->pretty_gedcom = model('pretty_gedcom',$gedcom);
    }

    function contactInfo(){
        return $this->pretty_gedcom->printSubm($this->submitter);
    } 

    function emailForm(){
        global $_CONFIG;
        $form = model('emailform');
        if($form && $form->enabled()){
            return $form;
        }
        return FALSE;
    }

    function emailAddress(){
        global $_CONFIG;
        if($_CONFIG['show_email_address'] && 
            $_CONFIG['email_address'] != 'example@example.com'
        ){
            return "<a href='mailto:{$_CONFIG['email_address']}'>{$_CONFIG['email_address']}</a>";
        }
        return FALSE;
    }
}
