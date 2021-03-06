
function deleteParent()
{
	var request = new XMLHttpRequest();

	var fd = new FormData();
	console.log(this);
	fd.append("img_id", this.parentNode.getAttribute("id").replace("art", ""));
	if (confirm("Delete this image"))
	{
		request.onreadystatechange = function (obj)
		{
			if (this.readyState == 4 && this.status == 200)
			{
				if (this.responseText == "Successfully removed image")
				{

					var node = document.getElementById(obj.parentNode.getAttribute("id"));
					// console.log(node);
					obj.parentNode.parentNode.removeChild(node);
					genAlert("alert-success", "Image Succesfully Deleted");
				} else
				{
				  genAlert("alert-danger", this.responseText);
				}
			}
		}.bind(request, this);

		request.open("POST", "./includes/deleteimg.php", true);
		request.send(fd);
	}
}

window.addEventListener("DOMContentLoaded", function () {

    var emsubs = document.querySelector("input[name='em_subs']");

    emsubs.addEventListener("change", function ()
    {
        if (this.getAttribute("value") == 0)
        {
            this.setAttribute("value", 1);
            this.checked = true;
        } else
        {
            this.setAttribute("value", 0);
            this.removeAttribute("checked");
        }
    });

	document.querySelector("#deleteProPic").addEventListener("click", function(e){
		e.preventDefault();
		var request = new XMLHttpRequest();
		var formData = new FormData();
		request.onreadystatechange = function()
		{
			if (this.status == 200 && this.readyState == 4)
			{
				if (this.responseText == "success")
				{
					document.querySelector('.avatar-lg').setAttribute("src", "./imgs/avatar.png");
					document.querySelector('.avatar').setAttribute("src", "./imgs/avatar.png");
				}
				else
					genAlert("alert-danger", this.responseText);
			}
		}
		formData.append("action", "Remove Profile Picture");
		request.open("POST", "./includes/deleteimg.php", true);
		request.send(formData);
	});
});



window.addEventListener("load", function(){
	var dels = document.querySelectorAll(".delete-par");
    for (var x = 0; x < dels.length; x++)
    {
		dels[x].onclick = null;
		//dels[x].removeEventListener("click", deleteParent.bind(dels[x]));
        dels[x].addEventListener("click", deleteParent.bind(dels[x]));
    }
});