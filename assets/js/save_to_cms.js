'use strict';
(function () {

    const form = document.querySelector('#formData');
    const data = new FormData(form);

    console.log("hello");

    document.addEventListener('submit', function (event) {

        // Prevent form from submitting to the server
        event.preventDefault();

        // Do some stuff...
        console.log(data);
    });



})(); // End of Main Function: