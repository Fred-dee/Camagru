<?php
if (!isset($_SESSION))
    session_start();
header("Content-Type: tect/html");
require_once './includes/functions.php';
require_once './includes/Element.php';
require_once './includes/form_group.php';
require_once './config/database.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Password Reset</title>
        <?php require_once './includes/main-includes.php' ?>
    </head>
    <body>
        <?php require_once './includes/navbar.php' ?>
        <div class="container-fluid">
            <?php
            output_returns();
            ?>
            <div class="row">
                <div class = "col-md-6 col-md-offset-3">
                    <?php
                    $form = new Element("form", false);
                    $form->add_attribute("action", "./private/update");
                    $form->add_attribute("method", "POST");
                    $first_attrs = array();
                    $btn_attrs = array();
                    $fl = array();
                    $ft;
                    $pdo = DB::getConnection();
                    if (isset($_GET["reset"]) && $_GET["reset"] == "update") {
                        $first_attrs = array(
                            "type" => "password",
                            "name" => "psswd",
                            "class" => "form-control",
                            "id" => "psswd",
                            "required" => "true"
                        );
                        $fl = array("for" => "psswd");
                        $ft = "Current Password:";

                        $btn_attrs = array(
                            "type" => "submit",
                            "name" => "reset",
                            "class" => "form-control btn  grey darken-4",
                            "id" => "update",
                            "value" => "update"
                        );
                    } elseif ($_GET["reset"] == "forgot") {
                        if (isset($_GET["bar"])) {

                            $link = $_GET["bar"];
                            $split = preg_split("/delimiter/", base64_decode($link));
                            try {
                                $stmt = $pdo->prepare("SELECT forgot_key FROM `users` WHERE user_name=:uid");
                                $stmt->bindParam(":uid", $split[0], PDO::PARAM_STR);
                                $stmt->execute();

                                $saved_key = $stmt->fetch(PDO::FETCH_ASSOC);
                                //if (!password_verify($split[1], $saved_key["forgot_key"]))
                                if (!$split[1] === $saved_key["forgot_key"]) {
                                    throw new \PDOException("Incorrect URL: " . $split[1], -1);
                                }
                            } catch (\PDOException $ex) {
                                echo "<script>alert('" . $ex->getMessage() . "')</script>";
                                exit();
                            }
                            $first_attrs = array(
                                "type" => "text",
                                "name" => "username",
                                "class" => "form-control",
                                "id" => "username",
                                "value" => $split[0]
                            );
                            $fl = array("for" => "username");
                            $ft = "Username: ";
                            $btn_attrs = array(
                                "type" => "submit",
                                "name" => "reset",
                                "class" => "form-control btn  grey darken-4",
                                "id" => "reset",
                                "value" => "reset"
                            );
                        }
                    }
                    $fg = new form_group($first_attrs, $fl, $ft);
                    if ($_GET["reset"] == "forgot") {
                        $arr = $fg->get_children();
                        $arr[1]->add_inlineattr("readonly");
                    }
                    $form->add_child($fg);
                    $attrs = array(
                        "type" => "password",
                        "name" => "npsswd",
                        "class" => "form-control",
                        "id" => "npsswd",
                        "required" => "true"
                    );
                    $fg = new form_group($attrs, array("for" => "npsswd"), "New Password:");
                    $form->add_child($fg);

                    $attrs = array(
                        "type" => "password",
                        "name" => "npsswdc",
                        "class" => "form-control",
                        "id" => "npsswdc",
                        "required" => "true"
                    );
                    $fg = new form_group($attrs, array("for" => "npsswdc"), "Confirm Password:");
                    $form->add_child($fg);
                    $submit = new Element("input", true);
                    $submit->add_attributes($btn_attrs);
                    $form->add_child($submit);
                    echo $form;
                    ?>
                </div>
            </div>
        </div>
                    <?php require_once './includes/footer.php' ?>
    </body>
</html>