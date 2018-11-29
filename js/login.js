/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener("DOMContentLoaded", function ()
{

    document.querySelector("a[name='forgot_link']").addEventListener("click", function (e) {
        e.preventDefault();
        var uname = document.querySelector("input[name='lusername']");
        if (uname.value.length < 4)
        {
            uname.parentNode.classList.add("has-warning");
            uname.classList.add("is-invalid");

        } else
        {
            uname.classList.remove("is-invalid");
            var request = new XMLHttpRequest();
            var fd = new FormData();
            request.open("POST", "./private/forgot_check.php", true);
            fd.append("uid", uname.value);
            request.send(fd);

            request.onreadystatechange = function ()
            {
                if (this.readyState == 4 && this.status == 200) {
					//console.log(this.responseText);
                    var response = JSON.parse(this.responseText);
                    if (response["status"] == "success")
                    {
						genAlert("alert-success","An email has been sent with the reset link" );
                    }
                    else if(response["status"] == "failure")
						genAlert("alert-danger", "No matching records for the provided username");
                        
                    else
						genAlert("alert-warning", response["data"]);
                      
                }
            }
        }
    });
    document.querySelector("input[name='s_cpassword']").addEventListener("input", function ()
    {
        var comp = document.querySelector("input[name='s_password']");
        if (this.value !== comp.value)
        {
            this.classList.remove("is-valid");
            this.classList.add("is-invalid");
        } else
        {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
        }
    });
    document.querySelector("input[name='s_password']").addEventListener("input", function () {
        var uppercase = this.value.match(/[A-Z]/g);
        var lowercase = this.value.match(/[a-z]/g);
        var number = this.value.match(/[0-9]/g);
        var arr = this.className.split(" ");

        if (!uppercase || !lowercase || !number || this.value.length < 8 && this.value.length != 0)
        {
            if (arr.indexOf("is-invalid") == -1)
            {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");

            }
        } else if (this.value.length == 0)
        {
            this.classList.remove("is-invalid");
            this.classList.remove("is-valid");
        } else
        {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
        }
    });
    document.querySelector("#form_register").addEventListener("submit", function (e) {
        if (!this.checkValidity())
        {
            e.preventDefault();
            e.stopPropagation();
        }
    });
});
