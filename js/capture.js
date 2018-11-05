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
function uploadSnaps()
{
    carosel = document.querySelector("#col-right");
    var formData = new FormData();
    var request = new XMLHttpRequest();
    for (var x = 0; x < carosel.childElementCount; x++)
    {
        alert(carosel.childNodes[x].childNodes[0].src);
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


    function dragElement(elmnt){
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
        }

        function closeDragElement() {
            // stop moving when mouse button is released:
            document.onmouseup = null;
            document.onmousemove = null;
        }
    }
    // Make the DIV element draggable:
    var icons = document.querySelectorAll(".icon");
    alert(icons.length);
    for(var x = 0; x < icons.length; x++)
    {
        dragElement(icons[x]);
    }
    //icons.forEach(dragElement(this));
    //dragElement(document.getElementsByClassName("icon"));
});
