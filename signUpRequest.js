import {sendRequest} from "./sendRequest.js";

const form = document.querySelector('.form-sign-up');
form.addEventListener('submit', handler);

function handler(e) {
    e.preventDefault();

    let body = {}
    let formData = new FormData(form);

    body["login"] = formData.get('login');
    body["password"] = formData.get('password');
    body["passwordConfirm"] = formData.get('passwordConfirm');
    body["email"] = formData.get('email');
    body["name"] = formData.get('name');

    sendRequest(body,'register.php')
}


























