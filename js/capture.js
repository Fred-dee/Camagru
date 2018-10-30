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
    for (var x = 0; x < carosel.childElementCount; x++)
    {
        alert(carosel.childNodes[x].src);
    }
}

function removeThis(obj)
{
    objParent = document.getElementById(obj.parentNode.getAttribute("id"));
    //alert(objParent.parentNode);
    //objParent.parentNode.removeChild(objParent); // delete just the article
    var row = objParent.parentNode.parentNode;
    row.removeChild(objParent.parentNode); // delete the entire column
    //document.removeChild(objParent.parentNode);
}
