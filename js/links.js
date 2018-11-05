function onReady()
{
    var nav_toggle = document.getElementsByClassName("navbar-toggler");
    for (var i = 0; i < nav_toggle.length; i++)
    {
        nav_toggle[i].addEventListener("click", function (clicked)
        {

            var collapsable = document.getElementsByClassName('collapse');
            for (var j = 0; j < collapsable.length; j++)
            {
                collapsable[j].classList.toggle('collapse');
            }
        });
    }

}