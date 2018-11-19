/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

window.addEventListener("DOMContentLoaded", function ()
{
    document.querySelector("input[name='s_password'").addEventListener("input", function () {
        var uppercase = this.value.match(/[A-Z]/g);
        var lowercase = this.value.match(/[a-z]/g);
        var number = this.value.match(/[0-9]/g);
        var arr = this.className.split(" ");
  
        if (!uppercase || !lowercase || !number || this.value.length < 8 && this.value.length != 0)
        {
            if (arr.indexOf("is-invalid") == -1)
            {
                this.classList.remove("is-valid");
                this.classList.add("is-invalid");

            }
        } else if (this.value.length == 0)
        {
                this.classList.remove("is-invalid");
                this.classList.remove("is-valid");
        } else
        {
            this.classList.remove("is-invalid");
            this.classList.add("is-valid");
        }
    });
    document.querySelector("#form_register").addEventListener("submit", function (e) {
        if (!this.checkValidity())
        {
            e.preventDefault();
        }
    });
});
