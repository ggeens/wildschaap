<?php
class page_index extends Page {
    function init(){
        parent::init();
        $page=$this;

        // Adding view box with another view object inside with my custom HTML template
        $this->add('View_Info')->add('View',null,null,array('view/myinfobox'));

        // Paste any Agile Toolkit examples BELOW THIS LINE. You can remove what I have here:


    }
}
