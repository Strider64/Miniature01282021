'use strict';

const d = document; // Shorten document to d:
const ePrev = d.querySelector('#ePrev');
const status = d.querySelector('#status');
const position = d.querySelector('#position');
const eNext = d.querySelector('#eNext');
const submitBtn = d.querySelector('#submitBtn');

const id = d.querySelector('#id');
const user_id = d.querySelector('#user_id');
const hidden = d.querySelector('#hiddenQ');
const question = d.querySelector('#addQuestion');

const answer1 = d.querySelector('#addAnswer1');
const answer2 = d.querySelector('#addAnswer2');
const answer3 = d.querySelector('#addAnswer3');
const answer4 = d.querySelector('#addAnswer4');

const correct = d.querySelector('#addCorrect');

const saveUrl = "saveRecord.php";
const deleteRecord = d.querySelector('#delete_quiz_record');

console.log(deleteRecord);
let saveRecord = null;

//var api_key = d.querySelector('#editTrivia').getAttribute('data-key');

let tableIndex = 0,
    totalRecords = 0,
    records = null,
    record = null;

const insertData = (data) => {

    record = data;

    position.textContent = record.id;
    id.value = parseInt(record.id);
    deleteRecord.setAttribute("href", "delete_quiz_record.php?id=" + id.value);
    console.log(deleteRecord);
    user_id.value = parseInt(record.user_id);

    hidden.value = record.hidden;
    question.value = record.question;
    answer1.value = record.answer1;
    answer2.value = record.answer2;
    answer3.value = record.answer3;
    answer4.value = record.answer4;


    correct.value = record.correct;
};

const forward = (e) => {
    status.style.color = "#fff";
    e.preventDefault();
    if (tableIndex < totalRecords - 1) {

        tableIndex += 1;
        insertData(records[tableIndex]);
    } else {
        tableIndex = 0;
        insertData(records[tableIndex]);
    }
};

eNext.addEventListener("click", forward, false);

const reverse = (e) => {
    status.style.color = "#fff";
    e.preventDefault();

    if (tableIndex > 0) {
        tableIndex -= 1;
        insertData(records[tableIndex]);
    } else {
        tableIndex = totalRecords - 1;
        insertData(records[tableIndex]);

    }
};

ePrev.addEventListener("click", reverse, false);

let requestUrl = "retrieve_table.php";

/* Success function utilizing FETCH */
const tableUISuccess = function (parsedData) {
    totalRecords = parsedData.length;
    records = parsedData;
    insertData(records[tableIndex]);
};

/* If Database Table fails */
const tableUIError = function (error) {
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

/* FETCH request */
const createRequest = function (url, succeed, fail) {
    fetch(url)
        .then((response) => handleErrors(response))
        .then((data) => succeed(data))
        .catch((error) => fail(error));
};

createRequest(requestUrl, tableUISuccess, tableUIError);


/* Success function utilizing FETCH */
const saveUISuccess = function () {
    status.style.color = "#45A049";
    setTimeout(function () { status.style.color = "#fff" ; }, 4000);
};

/* If Database Table fails to update data in mysql table */
const saveUIError = function (error) {
    console.log("Database Table did not load", error);
};

const handleSaveErrors = function (response) {
    if (!response.ok) {
        throw (response.status + ' : ' + response.statusText);
    }
    return response.json();
};

const saveRequest = (saveUrl, succeed, fail) => {
    //const data = {username: 'example'};

    fetch(saveUrl, {
        method: 'POST', // or 'PUT'
        body: JSON.stringify(saveRecord)
    })
        .then((response) => handleSaveErrors(response))
        .then((data) => succeed(data))
        .catch((error) => fail(error));
};

const serializeArray = function () {

    const serialized = {

        id: parseInt(record.id),
        user_id: parseInt(record.user_id),
        hidden: hidden.value,
        question: question.value,
        answer1: answer1.value,
        answer2: answer2.value,
        answer3: answer3.value,
        answer4: answer4.value,
        correct: parseInt(correct.value)
    };


    record.id = id.value;
    record.user_id = user_id.value;
    record.hidden = hidden.value;
    record.question = question.value;
    record.answer1 = answer1.value;
    record.answer2 = answer2.value;
    record.answer3 = answer3.value;
    record.answer4 = answer4.value;

    record.correct = correct.value;
    insertData(record);
    return serialized;

};


const sendToTable = (e) => {
    e.preventDefault();
    let form = d.querySelector('#editTrivia');
    saveRecord = serializeArray(form);
    saveRequest(saveUrl, saveUISuccess, saveUIError);
};

submitBtn.addEventListener('click', sendToTable, false);


createRequest("retrieve_table.php", tableUISuccess, tableUIError);
