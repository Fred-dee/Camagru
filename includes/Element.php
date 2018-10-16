<?php
	class Element
	{
		protected $_tagname;
		protected $_classes = array();
		protected $_attributes = array();
		protected $_children = array();
		protected $_isInline;
		protected $_text;
		
		public function __construct($elem_name, $inline)
		{
			$this->_tagname = $elem_name;
			$this->_isInline = $inline;
			$this->_text = "";
		}
		
		public function add_class($class)
		{
			$class = trim($class);
			if (!(array_search($class, $this->_classes)))
			{
				array_push($this->_classes, $class);
			}
		}
		public function __toString()
		{
			$ret_string = "<".$this->_tagname;
			$ret_string .= " class='";
			$arrkeys = array_keys($this->_classes);
			$last_key = end($arrkeys);
			foreach($this->_classes as $key => $value)
			{
				if (!($key == $last_key))
				{
					$ret_string .= $value.",";
				}
				else
				{
					$ret_string .= $value;
				}
			}
			$ret_string .= "' ";
			foreach($this->_attributes as $key => $value)
			{
				foreach($value as $ind => $val)
				{
					$ret_string .= $ind." = '".$val."'";
				}
			}
			if ($this->_isInline == true)
			{
				$ret_string .=" />";
			}
			else
			{
				$ret_string .= ">".$this->_text;
				foreach($this->_children as $value)
					$ret_string .= $value;
				$ret_string .= "</".$this->_tagname.">";
			}
			return $ret_string;
		}
		
		public function get_tagname()
		{
			return $this->_tagname;
		}

		
		public function add_attribute($att_name, $value)
		{
			if (!array_search(trim($att_name), $this->_attributes))
			{
				array_push($this->_attributes, array(trim($att_name) => trim($value)));
			}
		}
		
		public function remove_class($class)
		{
			$class = trim($class);
			$index;
			if(($index = array_search($class, $this->_classes)))
			{
				$this->_classes[$index] = NULL;
				$this->_classes = array_filter($this->_classes);
			}
		}
		
		public function remove_attribute($att_name)
		{
			$att_name = trim($att_name);
			$index;
			if (($index = array_search($att_name, $this->_attributes)))
			{
				$this->_attributes[$index] = NULL;
				$this->_attributes = array_filter($this->_attributes);
			}
		}
		
		public function mod_attribute($att_name, $nvalue)
		{
			$att_name = trim($att_name);
			$nvalue = trim($nvalue);
			if (($index = array_search($att_name, $this->_attributes)))
			{
				$this->_attributes[$index] = $nvalue;
			}
			else
			{
				array_push($this->_attributes, array($att_name => $nvalue));
			}
		}
		
		public function add_text($string)
		{
			$this->_text = $string;
		}
		
		public function get_text()
		{
			return $this->_text;
		}
		
		public function add_child($elem)
		{
			array_push($this->_children, $elem);
		}
		
		public function get_children()
		{
			return $this->_children;
		}
	}
?>