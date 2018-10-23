<?php
    if(!isset($_SESSION))
        session_start();
	require_once('Element.php');
	class Article extends Element
	{
		public function __construct($data)
		{
			parent::__construct("article", false);
			$img = new Element("img", true);
			$img->add_attribute("src", $data["img_src"]);
			$img->add_class($data["img_classes"]);
			$img->add_attribute("id", $data["img_id"]);
			$head_div = new Element("header", false);
			$head_div->add_text($data["user_id"]);
			$avatar = new Element("img", true);
			$avatar->add_class("avatar");
			$avatar->add_attribute("src", $data["avatar_src"]);
			$avatar->add_attribute("alt", "Avatar");
			$head_div->add_child($avatar);
			$img_div = new Element("div", false);
			$img_div->add_class("img-wrapper");
			$img_div->add_child($img);
			$comm_div = new Element("div", false);
			$comm_div->add_class("comment_section");
			$heart_span = new Element("span", false);
			$heart_span->add_class("glyphicon glyphicon-heart");
			$heart_span->add_attribute("style", "font-size: 50px");
			$like_button = new Element("button", false);
            if($_SESSION["login"] == "guest")
                $like_button->add_inlineattr("disabled");
			$like_button->add_class("btn btn-primary grey darken-3");
			$like_button->add_text($heart_span."Like");
			$comm_div->add_child($like_button);
			$this->add_child($head_div);
			$this->add_child($img_div);
			$this->add_child($comm_div);
		}
	}
?>