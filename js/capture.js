/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */



function changeFilter(obj)
{
    overlay = document.querySelector('#img_overlay');
    overlay.setAttribute("src", obj.src);
}

function add_filter(obj)
{
	document.querySelector(".overlay").appendChild(obj);
}

function remove_filter(obj)
{
	document.querySelector(".overlay").removeChild(obj);
}


function uploadSnaps()
{
    carosel = document.querySelector("#col-right");
    var formData = new FormData();
    var request = new XMLHttpRequest();
    for (var x = 0; x < carosel.childElementCount; x++)
    {
        formData.append("imgs", carosel.childNodes[x].childNodes[0].src);
        alert(carosel.childNodes[x].childNodes[0].src);
    }
    request.open("POST", "update.php", true);
    request.send(formData);
    while(formData.firstChild)
    {
        formData.removeChild(formData.firstChild);
    }


}
function clearSnaps()
{
    carosel = document.querySelector("#col-right");
    while (carosel.firstChild) {
        carosel.removeChild(carosel.firstChild);
    }
}

function removeThis(obj)
{
    alert(obj.getAttribute("src"));
}


window.addEventListener("DOMContentLoaded", function () {
    
	
	/*
			-----Checkbox Selecting Overlays-----
	*/
	var checkboxes = document.querySelectorAll(".form-check-input");
	for (var x = 0; x < checkboxes.length; x++)
	{
		checkboxes[x].addEventListener("change", function(obj)
	   	{
			var label = obj.nextElementSibling;
			var img = label.firstChild.cloneNode(true);
			var id= img.getAttribute("id");
			var videlem = document.getElementById("videoElement");
			if(obj.checked)
			{
				
				img.setAttribute("id", "overlay_"+id);
				img.classList.add("icon");
				img.style.width = "inherit";
				img.style.height = "inherit";
				add_filter(img);
				dragElement(img, videlem);
			}
			else
				remove_filter(document.querySelector("#overlay_"+id));
				
		}.bind(null, checkboxes[x]));
	}
	
	/*
			-----Drag Element Section-----
	*/
    function dragElement(elmnt, videlem){
        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            // if present, the header is where you move the DIV from:
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            // otherwise, move the DIV from anywhere inside the DIV:
            elmnt.onmousedown = dragMouseDown;
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            document.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            document.onmousemove = elementDrag;
        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
            pos1 = pos3 - e.clientX;
            pos2 = pos4 - e.clientY;
            pos3 = e.clientX;
            pos4 = e.clientY;
            // set the element's new position:
            elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
            elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
            //alert(document.querySelector("#videoElement").style.top);
            
            alert(window.getComputedStyle(videlm).getPropertyValue("top"));
            if(parseInt(elmnt.style.top) < parseInt(videlem.style.top))
                elmnt.style.top = videlem.style.top;
        }

        function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
	
	
	/*
			------Navigator.mediaDevices-----
	*/
	var video = document.querySelector("#videoElement");

	if (navigator.mediaDevices.getUserMedia) {
		navigator.mediaDevices.getUserMedia({video: true})
				.then(function (stream) {
					video.srcObject = stream;
					//var over;
					//over = document.querySelectorAll(".icon");
					var canvas = document.getElementById("canvasVid");
					var can2 = document.querySelector("#canvasOver");
					var button = document.getElementById("btn_snap");

					button.disabled = false;
					button.onclick = function () {
						var over = document.querySelectorAll(".icon");
						canvas.getContext("2d").drawImage(video, 0, 0, 500, 375);
						for (var x = 0; x < over.length; x++)
						{
							canvas.getContext("2d").drawImage(over[x], 0, 0, 500, 375);
							can2.getContext("2d").drawImage(over[x], 0, 0, 500, 375);
						}
						var img = canvas.toDataURL("image/png");
								const imgnew = document.createElement("img");
								const colnew = document.createElement("div");
								imgnew.setAttribute('src', img);
						colnew.setAttribute("class", "flex-col-item");
						colnew.appendChild(imgnew);
								const btnclose = document.createElement("button");
								btnclose.setAttribute("class", "close");
						btnclose.setAttribute("aria-label", "Close");
						btnclose.setAttribute("type", "button");
						btnclose.onclick = function (btnclose)
						{
							objParent = btnclose.parentNode;
							row = objParent.parentNode;
							row.removeChild(objParent);
						}.bind(null, btnclose);
						ico = document.createElement("span");
						ico.setAttribute("aria-hidden", "true");
						ico.innerHTML = "&times;";
						btnclose.appendChild(ico);
						colnew.appendChild(btnclose);
						var right = document.querySelector("#col-right");
						right.insertBefore(colnew, right.childNodes[0]);

					};
				})
				.catch(function (err0r) {
					console.log("Something went wrong!");
				});
	}
});
