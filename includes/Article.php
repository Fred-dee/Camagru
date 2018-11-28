<?php

if (!isset($_SESSION))
    session_start();
require_once('Element.php');
//require_once ('~/config/database.php');

class Article extends Element {

    public function __construct($data) {
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
        //Get All the comments
        $comm_div = new Element("div", false);
        $comm_div->add_class("comment_section");
        $pdo = DB::getConnection();

        $stmt = $pdo->prepare("SELECT * FROM events WHERE img_id = :img AND type='comment'");
        $stmt->bindParam(":img", $data["img_id"], PDO::PARAM_INT, 11);
        $stmt->execute();
		$br = new Element("br", true);
        if ($stmt->rowCount() > 0) {
            while (($row = $stmt->fetch(PDO::FETCH_ASSOC))) {
                $tmp = $pdo->prepare("SELECT user_name FROM users WHERE id = :uname");
                $tmp->bindParam(":uname", $row["user_id"], PDO::PARAM_STR, 15);
                $tmp->execute();
                $name = $tmp->fetch(PDO::FETCH_ASSOC);
                $cspan = new Element("span", false);
                $cspan->add_text($name["user_name"] . ": \t" . $row["message"]);
                $comm_div->add_child($cspan);
				
				$comm_div->add_child($br);
            }
        }
        //Done With all the comments
        //num likes //
        $stmt = $pdo->prepare("SELECT * FROM events WHERE img_id = :img AND type='like'");
        $stmt->bindParam(":img", $data["img_id"], PDO::PARAM_INT, 11);
        $stmt->execute();
        $num_likes = $stmt->rowCount();
        // end num likes //


        $heart_span = new Element("i", false);
        $heart_span->add_text($num_likes);
        $like_button = new Element("button", false);
        //Liked or not //
        if ($_SESSION["login"] == "guest") {
            $like_button->add_inlineattr("disabled");
            $heart_span->add_class("far fa-heart");
        } else {
            $stmt = $pdo->prepare("SELECT * FROM events WHERE img_id = :img AND type='like' AND user_id = :u_id");
            $stmt->bindParam(":img", $data["img_id"], PDO::PARAM_INT, 11);
            $stmt->bindParam(":u_id", $_SESSION["user_id"], PDO::PARAM_INT, 11);
            $stmt->execute();
            if ($stmt->rowCount() == 1)
                $heart_span->add_class("fas fa-heart heart-ico");
            else
                $heart_span->add_class("far fa-heart");
        }
        //end Liked or not //
        $like_button->add_attribute("type", "button");
        $like_button->add_class("like-btn");
        $like_button->add_child($heart_span);
        $comm_div->prepend_child($like_button);
        $this->add_child($head_div);
        $this->add_child($img_div);
        $this->add_child($comm_div);


        // Comment Form //
        $mcom = new Element("div", false);

        $mform = new Element("form", false);
        $mform->add_attribute("action", "");
        $mform->add_attribute("method", "POST");
		$mform->add_class("form-comment");

        $input = new Element("input", true);
        $input->add_attribute("name", "message");
		$input->add_inlineattr("required");
        $hidden = new Element("input", true);
        $hidden->add_attribute("name", "img_id");
        $hidden->add_attribute("value", $data["img_id"]);
        $hidden->add_inlineattr("hidden");
        $mform->add_child($hidden);
        $submit = new Element("button", false);
        $submit->add_attribute("name", "submit");
        $submit->add_attribute("type", "submit");
        $submit->add_text("<i class='fa fa-paper-plane' aria-hidden='true'></i>");
        $mform->add_class("form-inline");

        if ($_SESSION["login"] == "guest")
        {
            $input->add_inlineattr("disabled");
            $submit->add_inlineattr("disabled");
        }
        $input->add_class("form-control comment");
        $input->add_attribute("placeholder", "Comment...");
        $input->add_attribute("type", "input");
        $mform->add_child($input);
        $submit->add_class("form-control grey darken-3 btn comm_submit");
      
        $mform->add_child($submit);
        $mcom->add_child($mform);
        $this->add_child($mcom);

        // end Comment Form //
    }

}

?>