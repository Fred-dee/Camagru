const sleep = (milliseconds) => {
  return new Promise(resolve => setTimeout(resolve, milliseconds))
}

function removeAlert(alert)
{
	var cont = alert.parentNode;
	alert.style.transition = "all 0.4s ease-in-out";
	alert.style.height = "0px";
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
	
	sleep(1000).then(() =>
	{
		removeAlert(alert);
	});
					
}

window.addEventListener("DOMContentLoaded", function(){
	

});