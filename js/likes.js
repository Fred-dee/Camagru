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
        var span = data.firstChild;

        var img_id = data.parentNode.querySelector("input[name='img_id']").value;
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
                }
                else
					genAlert("alert-danger", this.responseText);
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
	
	var comm_form = document.querySelectorAll(".form-comment");
	for (var i = 0; i < comm_form.length; i++)
	{
		comm_form[i].addEventListener("submit", function(e){
			e.preventDefault();
			
			var request = new XMLHttpRequest();
			var data = new FormData(this);
			
			request.onreadystatechange = function(form)
			{
				if (this.readyState == 4 && this.status == 200)
				{
					var art = form.parentNode.parentNode;
					var comm_section = art.querySelector(".comment_section");
					
					var span = document.createElement("span");
					
					//console.log(art);
					span.innerHTML = this.responseText + "<br/>";
					comm_section.appendChild(span);
					form.reset();
				}
			}.bind(request, this);
			request.open("POST", "./includes/comment.php", true);
			request.send(data);
			
		}.bind(comm_form[i]));
	}

});

