/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener("DOMContentLoaded", function () {

    function getUserID()
    {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var resp;
                
                resp = this.responseText;
                if (resp == "guest")
                    return "guest";
                else
                    return resp;
                alert(resp);
                //return(this.responseText);
            }
        };
        xhttp.open("GET", "./includes/likes.php?uid", true);
        xhttp.send();
    }
    /*function hasClass(selector, element)
     {
     var className = " " + selector + " ";
     if ( (" " + element.className + " ").replace(/[\n\t]/g, " ").indexOf(" thatClass ") > -1 ) 
     }*/
    function like(data)
    {
        var span = data.childNodes[0];
        var id;
        id = getUserID();
        if (id  != "guest")
        {
            //alert(id);
            if ((" " + span.className + " ").replace(/[\n\t]/g, " ").indexOf(" far ") > -1)
            {
                //This means I have yet to like the thing, I need to send a request giving 
                //an insert into the table

            } else
            {
                //This means I have liked the thing, I need to remove my like
            }
        }
        /*
         var xhttp = new XMLHttpRequest(obj);
         xhttp.onreadystatechange = function () {
         if (this.readyState == 4 && this.status == 200) {
         
         document.getElementById("demo").innerHTML = this.responseText;
         }
         };
         xhttp.open("POST", "ajax_info.txt", true);
         xhttp.send();
         */
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

