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
});