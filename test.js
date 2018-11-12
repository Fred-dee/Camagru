/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener("DOMContentLoaded", function ()
{
    var lbDown = false;
    resize(document.querySelector('.resizable'));
    var width = 0;
    var height = 0;
    var cursorinitX = 0;
    var cursorinitY = 0;
    var movx;
    var movy;

    function resize(elmnt)
    {


        var childNodes = elmnt.childNodes;

        for (var x = 1; x < childNodes.length; x++)
        {
            childNodes[x].addEventListener("mousedown", resizeMouseDown, false);
            childNodes[x].addEventListener("mousemove", elementResize, false);
            childNodes[x].addEventListener("mouseup", closeElementResize, false);
            childNodes[x].addEventListener("mouseleave", closeElementResize, false);
            //childNodes[x].onmousedown = resizeMouseDown.bind(childNodes[x]);
            //childNodes[x].onmousemove = elementResize.bind(childNodes[x]);
            //childNodes[x].onmouseup = closeElementResize.bind(childNodes[x]);
            
        }

        function resizeMouseDown(event)
        {
            event = event || window.event;
            event.preventDefault();

            lbDown = true;
            cursorinitX = event.clientX;
            cursorinitY = event.clientY;
        }

        function elementResize(e)
        {
            e = e || window.event;
            e.preventDefault();
            if (lbDown == true)
            {
                var computed = window.getComputedStyle(elmnt);
                var widthinit = parseFloat(computed.getPropertyValue('width'));
                var heightinit = parseFloat(computed.getPropertyValue('height'));

                var rectangle = elmnt.getBoundingClientRect();

                //console.log(rectangle);

                var className = ((" " + this.className + " ").replace(/[\n\t]/g, " "));
                var valid = false;
                if (className.indexOf(" resize-middleright ") > -1)
                {
                    movx = e.clientX - cursorinitX;
                    movy = 0;
                    console.log(movx);
                    valid = true;
                } else if (className.indexOf(" resize-bottomright ") > -1 || className.indexOf(" resize-topright ") > -1)
                {
                    movx = e.clientX - cursorinitX;
                    movy = e.clientY - cursorinitY;
                    valid = true;
                } else if (className.indexOf(" resize-middleleft ") > -1)
                {
                    movx = -e.clientX + cursorinitX;
                    movy = 0;
                    console.log(movx);
                    valid = true;
                } else if (className.indexOf(" resize-bottomleft ") > -1 || className.indexOf(" resize-topleft ") > -1)
                {
                    movx = -e.clientX + cursorinitX;
                    movy = -e.clientY + cursorinitY;
                    valid = true;
                }
                if (valid == true)
                {
                    //cursorinitX = e.clientX;
                    //cursorinitY = e.clientY;
                    width = widthinit + movx;
                    height = heightinit + movy;


                    //console.log("height : " + height);
                    elmnt.style.width = width + "px";
                    elmnt.style.height = height + "px";
                }
            }

        }

        function closeElementResize(e)
        {
            lbDown = false;
            this.removeEventListener("mousemove", resizeMouseDown);
            this.removeEventListener("mouseup", closeElementResize);
            //this.onmousemove = null;
        }

    }
});
