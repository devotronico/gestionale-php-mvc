import { request } from './module/request.js';
import { getMessageSendEmail } from './module/template.js';
// import { requestTemplate } from './module/request-template.js';

//document.addEventListener('DOMContentLoaded', function() {

let path, email, password, data;

// selezionare un inseme di elementi e aggiungere a ognuno di essi un evento
function addEventToButton() {
    const buttons = document.querySelectorAll('.btn');
    for ( const button of buttons ) { button.addEventListener('click', fn); }
}
addEventToButton();


function fn(e) {
    switch(e.target.id) {
        case 'signin-btn': console.log('signin');
            e.preventDefault();
            path = '/auth/signin/access';
            const token = document.querySelector('#signin-token').value;
            email = document.querySelector('#signin-email').value;
            password = document.querySelector('#signin-password').value;
            data = `data=${JSON.stringify({ token: token, email: email, password: password })}`
            console.log("TCL: fn -> data", data)
            request(path, data)
            .then((message) => {
                console.log('TCL: fn -> message', message)
                // return requestTemplate('home.tpl.html', message);
            })
            .then((email) => {
                console.log(email);
                getMessageSendEmail(email);
                addEventToButton();
                // const el = document.querySelector('.message-template');
                // el.innerHTML = message;
            })
            .catch(err => console.log(err));
        break;
        case 'error__close': console.log('close');
            const errorWrapper = document.querySelector('.error__wrapper');
            errorWrapper.remove();
            break;
/*

        case 'verify': // console.log('verify');
            e.preventDefault();
            file = 'verify';
            email = document.querySelector('#email-verify').value;
            data = `${file}=${JSON.stringify({ email: email })}`
            request(file , data)
            .then((message)=>{
                return requestTemplate('verify.tpl.html', message);
            })
            .then((html)=>{
                console.log(html);
                addEventToButton();
            })
            .catch(err => console.log(err));
        break;


        case 'logout':
            e.preventDefault();

            file = 'logout';

            data = `${file}=${JSON.stringify({ email: 'dan@mail.it' })}`

            request(file, data)
            .then((message)=>{
                return requestTemplate('home.tpl.html', message);
            })
            .then((message)=>{
                console.log(message);
                document.querySelector('.message-template').innerHTML = message;
                addEventToButton();
            })
            .catch((err)=>console.log(err))
        break;


        case 'pass-emailform':
            e.preventDefault();

            file = 'passrecovery';
            const template = 'passrecovery.tpl.html';

            loadTemplate(template)
            .then((html)=>{
                console.log(html);
                addEventToButton();
            })
            .catch((err)=>console.log(err))
        break;


        case 'pass-emailcheck':
            e.preventDefault();

            file = 'pass-emailcheck';

            email = document.querySelector('#email-signup').value;

            data = `${file}=${JSON.stringify({ email: email })}`

            request(file, data)
            .then((success)=>{
                console.log(success);
            })
            .then((html)=>{
                console.log(html);
                addEventToButton();
            })
            .catch((err)=>console.log(err))
        break;


        case 'truncate':
            file = 'truncate';

            request(file)
            .then((message)=>{
                return requestTemplate('truncate.tpl.html', message);
            })
            .then((html)=>{

                console.log(html);
                addEventToButton();
            })
            .catch(obj => { console.log(obj[0]) })
        break;


        case 'type-signin':  console.log('type-signin');

            e.target.parentNode.classList.add('active');

            document.getElementById('type-signup').parentNode.classList.remove('active');

            document.getElementById('form-signin').hidden = false;
            document.getElementById('form-signup').hidden = true;
        break;


        case 'type-signup': console.log('type-signup');

            e.target.parentNode.classList.add('active');

            document.getElementById('type-signin').parentNode.classList.remove('active');

            document.getElementById('form-signin').hidden = true;
            document.getElementById('form-signup').hidden = false;
        break;
        */
       default: console.log('DEFAULT'); break;
    }
}

export { addEventToButton };


