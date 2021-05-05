'use strict';
/* Convert RGBa to HEX  */
const rgba2hex = (orig) => {
    let a,
        rgb = orig.replace(/\s/g, '').match(/^rgba?\((\d+),(\d+),(\d+),?([^,\s)]+)?/i),
        alpha = (rgb && rgb[4] || "").trim(),
        hex = rgb ?
            (rgb[1] | 1 << 8).toString(16).slice(1) +
            (rgb[2] | 1 << 8).toString(16).slice(1) +
            (rgb[3] | 1 << 8).toString(16).slice(1) : orig;

    if (alpha !== "") {
        a = alpha;
    } else {
        a = "01";
    }
    // multiply before convert to HEX
    a = ((a * 255) | 1 << 8).toString(16).slice(1);
    hex = hex + a;

    return hex;
};

const myColor = (colorcode) => {
    let hexColor = rgba2hex(colorcode);
    return '#' + hexColor;
};

/*
 * Constants & Variables Initialization Section.
 */
const myGreen = myColor("rgba(29, 100, 31, 0.70)"); /* Green with 70% transparency */
const myRed = myColor("rgba(84, 0, 30, 0.50)"); /* Red with 70% transparency */
const myBorder = myColor("rgba(85, 85, 85, 1.00");
const contact = () => {
    const d = document;
    const sendUrl = 'sendMsg.php';
    const submit = d.querySelector('#submitForm');
    const radioBtn = d.querySelector('#message-type');
    const buttons = d.getElementsByName("reason");
    const message = d.querySelector('#message');
    const messageSuccess = d.querySelector('#messageSuccess');

    let name = d.querySelector('#name');
    let email = d.querySelector('#email');
    let phone = d.querySelector('#phone');
    let website = d.querySelector('#web');
    let notice = d.querySelector('#notice');
    let sendEmail = {};
    let sendStatus = {
        name: false,
        email: false,
        comments: false
    };
    sendEmail.reason = 'message';
    sendEmail.token = d.querySelector('#token').value;

    message.style.display = "none";

    let comments = d.querySelector("textarea");
    let output = d.querySelector("#length");

    //d.getElementById('contact').scrollIntoView();


    name.addEventListener('input', () => {
        const value = name.value.trim();

        if (value) {
            name.style.borderColor = myBorder;
            sendEmail.name = name.value;
            sendStatus.name = true;
        } else {
            name.style.borderColor = "red";
            name.value = "";
            name.placeholder = "Name Required";
            name.focus();

        }

    });

    const emailIsValid = (email) => {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    };

    email.addEventListener('change', () => {
        let status = emailIsValid(email.value);
        console.log('Email Address', email.value, 'Status', status);
        if (!status) {
            email.value = "";``
            email.placeholder = "Email Address is Invalid!";
            email.style.borderColor = "red";
            email.focus();
        } else {
            email.style.borderColor = myBorder;
            sendEmail.email = email.value;
            sendStatus.email = true;
        }
    });


    /*
     * Selection Element
     */
    buttons.forEach((value, index) => {
        //console.log(value, index);
        buttons[index].addEventListener('change', (e) => {
            sendEmail.reason = e.target.value;
            //console.log('Reason:', sendEmail.reason);
        });
    });


    comments.addEventListener("input", () => {
        output.textContent = comments.value.length;
        const value = comments.value.trim();

        if (value) {
            comments.style.borderColor = myBorder;
            sendEmail.comments = comments.value;
            sendStatus.comments = true;
        } else {
            comments.style.borderColor = "red";
            comments.placeholder = "Message Required!";
            comments.focus();
        }
    });


    /* Success function utilizing FETCH */
    const sendUISuccess = function (result) {
        //console.log('Result', result);
        if (result) {
            d.querySelector('#recaptcha').style.display = "none";
            submit.style.display = "none";
            notice.style.display = "grid";

            notice.textContent = "Email Successfully Sent!";
            notice.style.color = "green";
            message.style.display = "grid";
            //messageSuccess.style.display = "block";
            d.querySelectorAll('form > *').forEach(function (a) {
                a.disabled = true;
            });
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
        //const data = {username: 'example'};
        fetch(sendUrl, {
            method: 'POST', // or 'PUT'
            body: JSON.stringify(sendEmail)

        })
            .then((response) => handleSaveErrors(response))
            .then((data) => succeed(data))
            .catch((error) => fail(error));
    };

    submit.addEventListener('click', (e) => {
        e.preventDefault();
        sendEmail.phone = phone.value;
        sendEmail.website = website.value;
        sendEmail.response = submit.getAttribute('data-response');
         if (sendStatus.name && sendStatus.email && sendStatus.comments) {
            saveRequest(sendUrl, sendUISuccess, sendUIError);
        } else {
            notice.style.display = "block";
            notice.textContent = "Name, Email, and Message Required!";
        }
    }, false);


};


contact();