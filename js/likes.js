/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var uid;

window.addEventListener("DOMContentLoaded", function () {

    getUserID();
    function getUserID()
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var resp;
                
                uid = this.responseText;
               
                
                //return(this.responseText);
            }
        };
        xhttp.open("GET", "./includes/likes.php?uid", true);
        xhttp.send();
    }

    function like(data)
    {
        var span = data.childNodes[0];
        var img_id = data.parentNode.parentNode.getAttribute("id").toString();
        var xhttp =  new XMLHttpRequest();
        xhttp.onreadystatechange = function()
        {
            if(this.readyState == 4 && this.status == 200)
            {
                if(this.responseText == "success")
                {
                    var numlikes = parseInt(span.textContent);
                    if ((" " + span.className + " ").replace(/[\n\t]/g, " ").indexOf(" far ") > -1)
                    {
                        span.classList.remove("far");
                        span.classList.add("fas");
                        numlikes = numlikes + 1;

                    } else
                    {
                        span.classList.remove("fas");
                        span.classList.add("far");
                        numlikes -= 1;
                    }
                    span.textContent = numlikes.toString();
					genAlert("alert-success", "Liked");
                }
                // make an error div
            }
            
        };
        xhttp.open("GET", "./includes/likes.php?method=update&img="+img_id, true);
        xhttp.send();
    }

    var form = document.querySelectorAll(".like-btn");
    for (var x = 0; x < form.length; x++)
    {
        form[x].addEventListener("click", function (e) {
            e.preventDefault();
            like(this);
        });
    }

});

