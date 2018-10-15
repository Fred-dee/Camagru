$(document).ready(function () {

    $(".nav-link").on("click", function () {
        if ($(".nav-link").parent().hasClass("active"))
        {
            $(".nav-link").parent().removeClass("active");
        }
        $(this).parent().addClass("active");
    });

    $(".navbar-toggler").on('click', function(e)
    {
        window.alert("I clicked on the togler");
        var collapsableItems = $('.collapse');
        collapsableItems.each(function () {
                $(this).collapse('hide');
        });
        return (true);
    });
    
    $(document).on('click', function (event) {
       // window.alert("There jas been a click");
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