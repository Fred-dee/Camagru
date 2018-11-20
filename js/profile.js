window.addEventListener("DOMContentLoaded", function () {

    var emsubs = document.querySelector("input[name='em_subs']");

    emsubs.addEventListener("change", function ()
    {
        if (this.getAttribute("value") == 0)
        {
            this.setAttribute("value", 1);
            this.setAttribute("checked");
        } else
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
        request.onreadystatechange = function (obj)
        {
            if (this.readyState == 4 && this.status == 200)
            {
                if (this.responseText == "Successfully removed image")
                {
                    
                    var node = document.getElementById(obj.parentNode.getAttribute("id"));
                    console.log(node);
                    obj.parentNode.parentNode.removeChild(node);
                } else
                    console.log(this.responseText);
            }
        }.bind(request, this);

        request.open("POST", "./includes/deleteimg.php", true);
        request.send(fd);
    }
    var dels = document.querySelectorAll(".delete-par");
    for (var x = 0; x < dels.length; x++)
    {
        dels[x].addEventListener("click", deleteParent.bind(dels[x]));
    }
});