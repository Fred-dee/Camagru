<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if (!isset($_SESSION))
    session_start();
require_once('Element.php');
class form_group extends Element
{
    public function __construct($input_attr = array(), $lbl_attr = array(), $lblText)
    {
        parent::__construct("div", false);
        $this->add_class("form-group");
        $input = new Element("input", true);
        $input->add_attributes($input_attr);
        $lbl = new Element("label", false);
        $lbl->add_attributes($lbl_attr);
        $lbl->add_text($lblText);
        $this->add_child($lbl);
        $this->add_child($input);
    }
}
?>