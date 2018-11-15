/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener("DOMContentLoaded", function () {

    function loadMore()
    {
        var request = new XMLHttpRequest();

        request.onreadystatechange = function ()
        {
            if (this.readyState == 4 && this.status == 200)
            {
                //var data = JSON.parse(this.responseText);
                if (this.responseText != "")
			 	{   
					document.querySelector('.container-fluid').innerHTML += (this.responseText);

            	}
			}
				
        };

        request.open("POST", "./loadmore.php", true);
        request.send();
    }
    window.addEventListener("scroll", scrollListen);

    function scrollListen() {

        var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
		/*var h;
		if(document.querySelector('.container-fluid').scrollHeight > window.innerHeight)
		{
			h = document.querySelector('.container-fluid').scrollHeight;
			console.log("went with the scroll height");
		}
		else
		{
			h = window.innerHeight;
			console.log("went with the innerHeight");
		}
		h -= document.documentElement.clientHeight;*/
        var h = Math.max(document.querySelector('.container-fluid').scrollHeight, window.innerHeight || 0) - document.documentElement.clientHeight;
        console.log(h + " the offset " + (window.pageYOffset) + " the window,innerHeight: " + window.innerHeight);
        if (window.pageYOffset >= h) {
            loadMore();
            //document.querySelector(".container-fluid").innerHTML += "<div style'height: 50px; width: 50px; background-color:red;'>Added</div>";
        }
    }
});
