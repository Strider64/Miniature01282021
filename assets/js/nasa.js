'use strict';

//const nasaAPI = "YcDMPqrsh4sblBCV68d5AdNCpbd6HkZjpxEIS7Bf";
//const nasaAPI = "YcDMadersh4sblBCV68d5AdNCpbd6HkZjpxEIS7Bf";
const nasaAPI = "yVrO2JW3x6rbmyI7TfhYBplAfiZbneySyU9PdTsD";
//const nasaUrl = "https://api.nasa.gov/planetary/apod?api_key=";
const nasaUrl = "https://api.nasa.gov/mars-photos/api/v1/rovers/perseverance/latest_photos?api_key=";

const nasa_perseverance_image = document.querySelector('#perseverance_image');
const nasa_image_info = document.querySelector('#image_info');
document.querySelector('#nasaInfo');
const requestUrl = nasaUrl + nasaAPI;
document.querySelector('#video');
/* Success function utilizing FETCH */
const nasaUISuccess = function (parsedData) {
    let image_length = parsedData.latest_photos.length;
    let nasa_image = parsedData.latest_photos[image_length-1].img_src;
    console.log('Nasa Data JSON', parsedData);
    // console.log ('object', parsedData.latest_photos[106].img_src);
    // console.log ('object', parsedData.latest_photos.length);
    // console.log ('object', parsedData.latest_photos);

    nasa_perseverance_image.setAttribute('src', nasa_image);
    //console.log(parsedData.latest_photos[image_length-1].camera);
    let nasaInfo = parsedData.latest_photos[image_length-1].camera;
    //console.log(nasaInfo.full_name);
    nasa_image_info.textContent = nasaInfo.full_name;
};

/* If nasa API did not load correctly */
const nasaUIError = function (error) {
    console.log("Database Table did not load", error);

};


/*
 * Throw error response if something is wrong:
 */
const handleErrors = function (response) {
    if (!response.ok) {
        throw (response.status + ' : ' + response.statusText);
    }
    return response.json();
};

/* create FETCH request */
const createRequest = function (url, succeed, fail) {
    fetch(url)
        .then((response) => handleErrors(response))
        .then((data) => succeed(data))
        .catch((error) => fail(error));
};

createRequest(requestUrl, nasaUISuccess, nasaUIError);

//const nasaUrl = "https://api.nasa.gov/mars-photos/api/v1/rovers/Opportunity/photos?sol=1&camera=PANCAM&api_key=";
//const nasaUrl = "https://api.nasa.gov/mars-photos/api/v1/manifests/opportunity?api_key=";