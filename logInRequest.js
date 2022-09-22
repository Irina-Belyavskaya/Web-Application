import {sendRequest} from "./sendRequest.js";

const form = document.querySelector('.form-log-in');
form.addEventListener('submit', handler);

function handler(e) {
    e.preventDefault();
    let body = {}
    let formData = new FormData(form);

    body["login"] = formData.get('login');
    body["password"] = formData.get('password');
    sendRequest(body, 'logIn.php');
}






























/*//--------------- XHR----------------------------------
let body = {}

const form = document.querySelector('.form-sign-up');
let formData = new FormData(form);

body["login"] = formData.get('login');
body["password"] = formData.get('password');
body["email"] = formData.get('email');
body["name"] = formData.get('name');

//console.log(JSON.stringify(body));

let xhr = new XMLHttpRequest();
xhr.open('POST', 'register.php');
xhr.responseType = 'json';
xhr.send(JSON.stringify(body));
xhr.onload = () => {
    if (xhr.status !== 200) {
        alert('error ${xhr.status}')
    } else {
        console.log(xhr.response);
        console.log(xhr.responseText);
    }
}*/

// console.log(formData.get('name'));
// console.log(formData);
// console.log(JSON.stringify(formData));
//form.reset();


/* let response = await fetch('register.php', {
     method: 'POST',
     body: formData // JSON.stringify(data)
 });
 console.log(response);
 if (response.ok) {
     let result = await response.json();
     alert(result.message);
     form.reset();
 } else {
     alert('Error!');
 }*/
