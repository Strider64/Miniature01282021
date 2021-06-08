'use strict';
(function () {
    const url = "check.php";
    let email = document.querySelector('#email');
    let emailLabel = document.querySelector('.emailLabel');
    let emailError = document.querySelector('.emailError');
    let username = document.querySelector('.io_username');
    let text_username = document.querySelector('.text_username');
    let error = document.querySelector('.error');
    let checkPassword1 = document.querySelector('#passwordBox');
    let checkPassword2 = document.querySelector('#redoPassword');
    let submitBtn = document.querySelector('.submitBtn');
    let send = {};

    const emailIsValid = (email) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    };

    email.addEventListener('change', () => {
        let status = emailIsValid(email.value);
        if (!status) {
            emailLabel.style.color = 'darkgreen';
            emailError.style.display = "inline-block";
            submitBtn.style.display = "none";
        } else {
            emailLabel.style.color = "#ffffff";
            emailError.style.display = "none";
            submitBtn.style.display = "inline-block";
        }
    }); // End of email Event Listener

    checkPassword2.addEventListener('change', () => {

    });
    /* Success function utilizing FETCH username */
    const sendUISuccess = function (result) {
        //console.log('Result', result);

        if (result.check) {
            text_username.style.color = "darkgreen";
            error.style.display = 'inline-block';
            submitBtn.style.display = "none";
        } else {
            text_username.style.color = "#ffffff"
            error.style.display = 'none';
            submitBtn.style.display = "inline-block";
        }

    };

    /* If Database Table fails to update data in mysql table */
    const sendUIError = function (error) {
        console.log("Database Table did not load", error);
    };

    const handleSaveErrors = function (response) {
        if (!response.ok) {
            throw (response.status + ' : ' + response.statusText);
        }
        return response.json();
    };

    const saveRequest = (sendUrl, succeed, fail) => {
        //console.log('username stringify', JSON.stringify(send))
        fetch(sendUrl, {
            method: 'POST', // or 'PUT'
            body: JSON.stringify(send)

        })
            .then((response) => handleSaveErrors(response))
            .then((data) => succeed(data))
            .catch((error) => fail(error));
    };

     username.addEventListener('input', () => {
         //console.log(check);
        send.check = username.value;
        //console.log('username', send)
        saveRequest(url, sendUISuccess, sendUIError);
    } );
})();