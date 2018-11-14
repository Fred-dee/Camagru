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
    var images = new Array();
    for (var x = 0; x < carosel.childElementCount; x++) // flex-col-item
    {
        var pure_image = carosel.childNodes[x].querySelector("img[name='pure_image']");
        var overlays = carosel.childNodes[x].querySelectorAll("img[name='img_over']");

        images.push(pure_image.getAttribute("src"));
        for (var i = 0; i < overlays.length; i++)
            images.push(overlays[i].getAttribute("src"));
        images = JSON.stringify(images);
        formData.append("images", images)
        request.onreadystatechange = function ()
        {
            if (this.readyState == 4 && this.status == 200) {
                formData = new FormData();
                images = new Array();
                console.log(this.responseText);
            }
        };
        request.open("POST", "merge.php", true);
        request.send(formData);
    }
    clearSnaps();



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
    var video = document.querySelector("#videoElement");

    var vidStream;
    document.querySelector("input[name='clear_input']").addEventListener("click", function () {
        this.parentNode.reset();
        video.setAttribute("src", "");
        video.parentNode.style.display = "none";
        video = document.querySelector("#videoElement");
        video.style.display = "block";
    });
    /*
     * navigator.mediaDevices.getUserMedia({video: true})
     .then(function (stream) {
     video.srcObject = stream;
     */
    document.querySelector("input[type='file']").addEventListener("change", function ()
    {
        files = this.files;
        if (files.length != 0)
        {
            video.style.display = "none";
            video = document.querySelector("#img_input");
            var reader = new FileReader();
            reader.readAsDataURL(files[0]);
            video.parentNode.style.display = "block";
            reader.addEventListener("load", function () {
                video.src = reader.result;
            }, false);

            if (files[0]) {
                reader.readAsDataURL(files[0]);
            }

            console.log("I have an image");
        } else
        {
            /*video.setAttribute("src", "");
            video.parentNode.style.display = "none";
            video = document.querySelector("#videoElement");
            video.style.display = "block"; */
        }
    });


    /*
     * 
     * -----Resize Settings and Code
     */


    function resize(elmnt)
    {

        var width = 0;
        var height = 0;
        var cursorinitX = 0;
        var cursorinitY = 0;
        var movx;
        var movy;
        var childNodes = elmnt.childNodes;

        for (var x = 1; x < childNodes.length; x++)
        {
            childNodes[x].onmousedown = resizeMouseDown.bind(childNodes[x]);
        }

        function resizeMouseDown(event)
        {
            event = event || window.event;
            event.preventDefault();


            //widthinit = parseInt(computed.getPropertyValue('width'));
            //heightinit = parseInt(computed.getPropertyValue('height'));

            cursorinitX = event.clientX;
            cursorinitY = event.clientY;

            elmnt.onmouseup = closeElementResize.bind(this, event);
            // call a function whenever the cursor moves:
            elmnt.onmousemove = elementResize.bind(this, event);
        }

        function elementResize(e)
        {
            e = e || window.event;
            e.preventDefault();

            var computed = window.getComputedStyle(elmnt);
            var widthinit = parseFloat(computed.getPropertyValue('width'));
            var heightinit = parseFloat(computed.getPropertyValue('height'));

            var rectangle = elmnt.getBoundingClientRect();

            console.log(rectangle);

            var className = ((" " + this.className + " ").replace(/[\n\t]/g, " "));
            /*if (className.indexOf(" resize-middleright") > -1)
             {
             movx = cursorinitX - e.clientX;
             movy = 0;
             console.log(movx);
             }*/
            movx = cursorinitX - e.clientX;
            movy = cursorinitY - e.clientY;
            cursorinitX = e.clientX;
            cursorinitY = e.clientY;
            width = widthinit + movx;
            height = heightinit + movy;

            console.log("width: " + width + " height" + height);

            elmnt.style.width = elmnt.style.width + "px";
            elmnt.style.height = height + "px";

        }

        function closeElementResize(e)
        {
            this.onmouseup = null;
            this.onmousemove = null;
        }

    }

    /*
     -----Checkbox Selecting Overlays-----
     */
    var checkboxes = document.querySelectorAll(".form-check-input");
    for (var x = 0; x < checkboxes.length; x++)
    {
        checkboxes[x].addEventListener("change", function (obj)
        {
            var label = obj.nextElementSibling;
            var img = label.querySelector("img").cloneNode(true);
            var greatDiv = document.createElement("div");
            greatDiv.classList.add("resizable");
            var id = img.getAttribute("id");
            if (obj.checked)
            {

                img.setAttribute("id", "overlay_" + id);
                img.classList.add("icon");
                img.style.width = "inherit";
                img.style.height = "inherit";
                //img.style.position="relative";
                greatDiv.appendChild(img);
                greatDiv.innerHTML = greatDiv.innerHTML + "<span class='resize-topright'></span>"
                        + "<span class='resize-topleft'></span>"
                        + "<span class='resize-bottomleft'></span>"
                        + "<span class='resize-bottomright'></span>"
                        + "<span class='resize-middleright'></span>"
                        + "<span class='resize-middleleft'></span>";
                add_filter(greatDiv);
                //resize(greatDiv);
                dragElement(greatDiv);

            } else
                remove_filter(document.querySelector("#overlay_" + id).parentNode);

        }.bind(null, checkboxes[x]));
    }

    /*
     -----Drag Element Section-----
     */
    function dragElement(elmnt) {
        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;
        if (document.getElementById(elmnt.id + "header")) {
            // if present, the header is where you move the DIV from:
            document.getElementById(elmnt.id + "header").onmousedown = dragMouseDown;
        } else {
            // otherwise, move the DIV from anywhere inside the DIV:
            elmnt.onmousedown = dragMouseDown;
            //console.log(elmnt);
        }

        function dragMouseDown(e) {
            e = e || window.event;
            e.preventDefault();
            // get the mouse cursor position at startup:
            pos3 = e.clientX;
            pos4 = e.clientY;
            elmnt.onmouseup = closeDragElement;
            // call a function whenever the cursor moves:
            elmnt.onmousemove = elementDrag;
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
            console.log("I am dragged");

        }

        function closeDragElement() {
            // stop moving when mouse button is released:
            elmnt.onmouseup = null;
            elmnt.onmousemove = null;
        }
    }


    /*
     ------Navigator.mediaDevices-----
     */


    if (navigator.mediaDevices.getUserMedia) {
        navigator.mediaDevices.getUserMedia({video: true})
                .then(function (stream) {
                    vidStream = stream;
                    video.srcObject = stream;
                })
                .catch(function (err0r) {
                    console.log("Something went wrong!");
                })
                .finally(function () {
                    var canvas = document.getElementById("canvasVid");
                    var can2 = document.querySelector("#canvasOver");
                    var button = document.getElementById("btn_snap");
                    button.disabled = false;
                    button.onclick = function () {
                        var over = document.querySelectorAll(".icon");
                        var screen = document.querySelector("body");

                        var rect = video.getBoundingClientRect();
                        var canvases = new Array();
                        var img_overlays = new Array();
                        canvas.getContext("2d").drawImage(video, 0, 0, 500, 375);
                        var img_pure = document.createElement("img");
                        img_pure.setAttribute("src", canvas.toDataURL("image/png"));
                        img_pure.setAttribute("name", "pure_image");
                        img_pure.setAttribute("style", "display:none");
                        console.log(img_pure);
                        for (var x = 0; x < over.length; x++)
                        {
                            var tmp_canvas = document.createElement("canvas");
                            var rect_ov = over[x].getBoundingClientRect();
                            var offT = rect_ov.top - rect.top;
                            var offL = rect_ov.left - rect.left;
                            canvas.getContext("2d").drawImage(over[x], offL, offT, 500, 375);
                            tmp_canvas.getContext("2d").drawImage(over[x], offL, offT, 500, 375);
                            canvases.push(tmp_canvas);
                        }
                        for (var x = 0; x < canvases.length; x++)
                        {
                            var src = canvases[x].toDataURL("image/png");
                            var tmp_overlay = document.createElement("img");
                            tmp_overlay.setAttribute("src", src);
                            tmp_overlay.setAttribute("style", "display:none");
                            tmp_overlay.setAttribute("name", "img_over")
                            img_overlays.push(tmp_overlay);
                        }
                        var img = canvas.toDataURL("image/png");
                        var imgnew = document.createElement("img");
                        var colnew = document.createElement("div");
                        imgnew.setAttribute('src', img);
                        imgnew.setAttribute('name', "final_image");
                        colnew.setAttribute("class", "flex-col-item");
                        colnew.appendChild(imgnew);
                        colnew.appendChild(img_pure);
                        var btnclose = document.createElement("button");
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
                        for (var x = 0; x < img_overlays.length; x++)
                        {
                            colnew.appendChild(img_overlays[x]);
                            console.log(img_overlays[x]);
                        }
                        var right = document.querySelector("#col-right");
                        right.insertBefore(colnew, right.childNodes[0]);

                    };
                });
    }
});
