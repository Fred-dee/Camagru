/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener("DOMContentLoaded", function () {

    function loadMore()
    {
        var request = new XMLHttpRequest();
		var link;

        request.onreadystatechange = function ()
        {
            if (this.readyState == 4 && this.status == 200)
            {
				
                if (this.responseText != "")
			 	{   
					document.querySelector('.container-fluid').innerHTML += (this.responseText.replace("Array", ""));

            	}
			}
				
        };
		if(window.location.href.includes("profile"))
			link = "./loadmore.php?profile=true";
		else
			link = "./loadmore.php?profile=false";
        request.open("POST", link, true);
        request.send();
    }
    window.addEventListener("scroll", scrollListen);

    function scrollListen() {

        var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);

        var h = Math.max(document.querySelector('.container-fluid').scrollHeight, window.innerHeight || 0) - document.documentElement.clientHeight;

        if (window.pageYOffset >= h) {
            loadMore();
        }
    }
});
