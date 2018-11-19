window.addEventListener("DOMContentLoaded", function(){
	
	var emsubs = document.querySelector("input[name='em_subs']");
	
	emsubs.addEventListener("change", function()
	{
		if(this.getAttribute("value") == 0)
		{
			this.setAttribute("value", 1);
			this.setAttribute("checked");
		}
		else
		{
			this.setAttribute("value", 0);
			this.removeAttribute("checked");
		}
	});
	
	
	function deleteParent()
	{
		var request = new XMLHttpRequest();
		
		var fd = new FormData();
		fd.append("img_id", this.parentNode.getAttribute("id").replace("art", ""));
		request.onreadystatechange = function()
		{
			if (this.readyState == 4 && this.status == 200)
			{}
		}
		
		request.open("POST", "./includes/deleteimg.php", true);
		request.send(fd);
	}
	var dels = document.querySelectorAll(".delete-par");
	for (var x = 0; x < dels.length; x++)
	{
		dels[x].addEventListener("click", deleteParent.bind(dels[x]));
	}
});