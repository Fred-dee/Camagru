function removeAlert(alert)
{
	var cont = alert.parentNode;
	console.log("I am doing this thing now");
	cont.removeChild(alert);
}



function genAlert(type, message)
{
	var alert = document.createElement("div");
	alert.classList.add("alert",type);
	alert.innerHTML = message;
	var cont = document.querySelector(".container-fluid");
	alert.style.transition = "ease-in 2s delay";
	cont.insertBefore(alert, cont.firstChild);
	setTimeout(removeAlert(alert), 500);
}

window.addEventListener("DOMContentLoaded", function(){
	

});