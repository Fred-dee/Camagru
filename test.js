/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener("DOMContentLoaded", function ()
{
	var lbDown = "none";
	var lock = false;
    //resize(document.querySelector('.resizable'));
	dragElement(document.querySelector('.resizable'));
    var width = 0;
    var height = 0;
    var cursorinitX = 0;
    var cursorinitY = 0;
    var movx;
    var movy;

	
	document.addEventListener("mousdown", function(){
		lock = true;
	});
	
	document.addEventListener("mouseup", function(){
		if (lock == true)
			lock = false;
	});
	
    function resize(elmnt)
    {
        var childNodes = elmnt.childNodes;
		var className;

        for (var x = 1; x < childNodes.length; x++)
        {
            childNodes[x].addEventListener("mousedown", resizeMouseDown, false);
            childNodes[x].addEventListener("mousemove", elementResize, false);
            childNodes[x].addEventListener("mouseup", closeElementResize, false);
            childNodes[x].addEventListener("mouseleave", closeElementResize, false);
            
        }

        function resizeMouseDown(event)
        {
            event = event || window.event;
            event.preventDefault();
			if(lbDown == "none")
            	lbDown = "resize";
            cursorinitX = event.clientX;
            cursorinitY = event.clientY;
		  	className = ((" " + this.className + " ").replace(/[\n\t]/g, " "));
        }

        function elementResize(e)
        {
            e = e || window.event;
            e.preventDefault();
            if (lbDown == "resize")
            {
                var computed = window.getComputedStyle(elmnt);
                var widthinit = parseFloat(computed.getPropertyValue('width'));
                var heightinit = parseFloat(computed.getPropertyValue('height'));
  
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
            if(lbDown == "resize")
				lbDown = "none";
            this.removeEventListener("mousemove", resizeMouseDown);
            this.removeEventListener("mouseup", closeElementResize);
            this.onmousemove = null;
        }

    }
	
	
	function dragElement(elmnt) {
        var pos1 = 0, pos2 = 0, pos3 = 0, pos4 = 0;

		elmnt.addEventListener("mousedown", dragMouseDown, false);
		elmnt.addEventListener("mouseup", closeDragElement, false);
		elmnt.addEventListener("mousemove", elementDrag, false);

        function dragMouseDown(e)
		{
			e = e || window.event;
            e.preventDefault();
			if(lbDown == "none" && lock == false)
			{
				lbDown = "drag";
            pos3 = e.clientX;
            pos4 = e.clientY;
			}

        }

        function elementDrag(e) {
            e = e || window.event;
            e.preventDefault();
            // calculate the new cursor position:
			if (lbDown == "drag" && lock == false)
			{
				pos1 = pos3 - e.clientX;
				pos2 = pos4 - e.clientY;
				pos3 = e.clientX;
				pos4 = e.clientY;
				// set the element's new position:
				elmnt.style.top = (elmnt.offsetTop - pos2) + "px";
				elmnt.style.left = (elmnt.offsetLeft - pos1) + "px";
			}

        }

        function closeDragElement(e) {
            // stop moving when mouse button is released:
			if(lbDown == "drag")
			{
				lbDown = "none";
				lock = false;
			}
            //elmnt.removeEventListener("mouseup", closeDragElement, false);
			//elmnt.removeEventListener("mousemove", elementDrag, false);
            //elmnt.removeEventListener("mousedown", dragMouseDown, false);
        }
    }


});
