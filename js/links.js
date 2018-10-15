/*$(document).ready(function () {

    $(".nav-link").on("click", function () {
        if ($(".nav-link").parent().hasClass("active"))
        {
            $(".nav-link").parent().removeClass("active");
        }
        $(this).parent().addClass("active");
    });

    $(document).on('click', function (event)
   {
        var $clickedOn = $(event.target),
                $collapsableItems = $('.collapse'),
                isToggleButton = ($clickedOn.closest('.navbar-toggler').length == 1),
                isLink = ($clickedOn.closest('a').length == 1),
                isOutsideNavbar = ($clickedOn.parents('.navbar').length == 0);
        if ((!isToggleButton && isLink) || isOutsideNavbar) {
            $collapsableItems.each(function () {
                $(this).collapse('hide');
            });
        }
    });

});
*/
function onReady()
{
	var nav_toggle = document.getElementsByClassName("navbar-toggler");
	for (var i = 0; i < nav_toggle.length; i++)
	{
		nav_toggle[i].addEventListener("click", function (clicked)
		{
			alert("I have been clicked");
			var collapsable = document.getElementsByClassName('collapse');
			for (var j = 0; j < collapsable.length; j++)
			{
				collapsable[j].classList.toggle('collapse');	
			}
		});
	}

}