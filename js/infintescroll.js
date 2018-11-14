/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/*
 *     $(window).scroll(function() {
 
 if($(window).scrollTop() + $(window).height() >= $(document).height()) {
 
 var last_id = $(".post-id:last").attr("id");
 
 loadMoreData(last_id);
 
 }
 
 });
 
 
 function loadMoreData(last_id){
 
 $.ajax(
 
 {
 
 url: '/loadMoreData.php?last_id=' + last_id,
 
 type: "get",
 
 beforeSend: function()
 
 {
 
 $('.ajax-load').show();
 
 }
 
 })
 
 .done(function(data)
 
 {
 
 $('.ajax-load').hide();
 
 $("#post-data").append(data);
 
 })
 
 .fail(function(jqXHR, ajaxOptions, thrownError)
 
 {
 
 alert('server not responding...');
 
 });
 
 }
 
 function sleep(ms) {
 return new Promise(resolve => setTimeout(resolve, ms));
 }
 
 async function demo() {
 console.log('Taking a break...');
 await sleep(2000);
 console.log('Two seconds later');
 }
 
 demo();
 */
window.addEventListener("DOMContentLoaded", function () {

    /*function sleep(ms) {
     return new Promise(resolve => setTimeout(resolve, ms));
     }*/

    function loadMore()
    {
        var request = new XMLHttpRequest();

        request.onreadystatechange = function ()
        {
            if (this.readyState == 4 && this.status == 200)
            {
                //var data = JSON.parse(this.responseText);
                if (this.responseText != "")
                    document.querySelector('.container-fluid').innerHTML += (this.responseText);
                //else
                  //  window.removeEventListener("scroll", scrollListen);
                //console.log(data[0]);
                /*if (this.responseText == "")
                    window.removeEventListener("scroll", scrollListen);*/
                //console.log(this.responseText);
                //await sleep(5000);
            }
        };

        request.open("POST", "./loadmore.php", true);
        request.send();
    }
    window.addEventListener("scroll", scrollListen);

    function scrollListen() {

        var w = Math.max(document.documentElement.clientWidth, window.innerWidth || 0);
        var h = Math.max(document.documentElement.scrollHeight, window.innerHeight || 0) - document.documentElement.clientHeight;
        console.log(h + " the offset " + (window.pageYOffset) + "the window,innerHeight: " + window.innerHeight);
		console.log(document.querySelector('.container-fluid').offsetHeight - document.querySelector('footer').clientHeight - document.querySelector('nav').clientHeight);
        if (window.pageYOffset >= h) {
            loadMore();
            //document.querySelector(".container-fluid").innerHTML += "<div style'height: 50px; width: 50px; background-color:red;'>Added</div>";
        }
    }
});
