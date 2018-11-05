/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function changeFilter(obj)
{
    overlay = document.querySelector('#img_overlay');
    overlay.setAttribute("src", obj.src);
}

function uploadSnaps()
{
    carosel = document.querySelector("#col-right");
    
    var formData = new FormData();
    var request = new XMLHttpRequest();
    for (var x = 0; x < carosel.childElementCount; x++)
    {
        alert(carosel.childNodes[x].childNodes[0].src);
    }
    

}


function clearSnaps()
{
    carosel = document.querySelector("#col-right");
    while (carosel.firstChild) {
        carosel.removeChild(carosel.firstChild);
    }
}

function removeThis(obj)
{
    alert(obj.getAttribute("src"));

}
