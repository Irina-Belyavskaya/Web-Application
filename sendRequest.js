async function postData (url, method,headers,body) {
    const response = await fetch(url, {
        method: method,
        headers: headers,
        body: JSON.stringify(body),
    });
    return await response.json();
}

function showErrorMessage(data) {
    const positionOnScreen = {
        'login' : '60px',
        'password' : '200px',
        'passwordConfirm' : '350px',
        'email' : '490px',
        'name' : '635px'
    }
    console.log(data);
    data.forEach(function (object) {
        const item = document.querySelector('#' + object['id']);

        let textMes = document.createElement('p');
        textMes.textContent = object['message'];
        textMes.style.fontSize = '20px';
        textMes.style.color = 'red';
        textMes.style.top = positionOnScreen[object['id']];
        textMes.classList.add('mistake-message');
        item.after(textMes);
        console.log(textMes);
    })
}

function deleteElements () {
    const elements = document.querySelectorAll('.mistake-message');
    elements.forEach(function(item) {
        item.remove();
    });
}

export function sendRequest(body, url) {

    deleteElements();

    const method = 'POST';
    const headers = {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        'dataType': 'json',
        'X-Requested-With': 'XMLHttpRequest'
    }
    try {
        postData(url, method,headers,body).then((data) => {
            if (data.length !== 0) {
                if (data.length === 1 && data['message'])
                    alert(data['message']);
                else
                    showErrorMessage(data);
            } else {
                location.reload();
            }

        });
    } catch (error) {
        console.error('Ошибка:', error);
    }
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
