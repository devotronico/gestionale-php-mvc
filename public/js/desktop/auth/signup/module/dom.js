function removeAlerts() {

    const alerts = document.querySelectorAll(".alert");
    for ( const alert of alerts ) { alert.hidden = true; }
}

// TODO: disattivare anche i campi input name, email, password
function deactivateButton(path) {

// const arr = [ "truncate", "logout", "verify"];
// let newArr = arr.filter((a) => a > 12);
// console.log(newArr); // return [20, 30]
// posts.filter((post) => post.img !== null && post.likes > 50);
// path = '/auth/signup/store';

    const type = path.split('/')[2];
    const lista = ["signin", "signup"];
    if ( lista.indexOf(type) === -1 ) return;

    // if ( type !== "truncate" && type !== "logout" && type !== "verify" ) {

    removeAlerts();

    if ( type === "signup" ) {
        const name = document.querySelector("#name-"+type); // id: name-signin
        // name.setAttribute("disabled","true");
        name.disabled = true;
    }
    const email = document.querySelector("#email-"+type); // id: email-signin
    // email.setAttribute("disabled","true");
    email.disabled = true;

    const password = document.querySelector("#password-"+type); // id: password-signin
    // password.setAttribute("disabled","true");
    password.disabled = true;

    const button = document.querySelector("#"+type);
    // button.setAttribute("disabled","true");
    button.disabled = true;
    button.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>&nbspLoading...`;
    // }
}

function activateButton(buttonName) {
    const inputs = document.getElementsByTagName('INPUT');
    for(let i = 0; i < inputs.length; i++) {
        inputs[i].disabled = false;
    }

    const element = document.querySelector("#"+buttonName);
    element.removeAttribute('disabled');

    if (typeof buttonName !== 'string') {  element.innerText = buttonName; }
    element.innerText = buttonName.charAt(0).toUpperCase() + buttonName.slice(1);
}

function singleErrorTest(obj) { console.log('OK-1');
    removeAlerts();
    activateButton('signup');

    const alert = document.querySelector(`.alert-${obj.body.dom}`); // alert-danger alert-signin-email // alert-signup-email
    // const alert = document.querySelector(`.alert-${obj.error}`); // alert-danger alert-signin-email
    if ( alert === null ) { return; } // [!]
    alert.hidden = false;
    alert.innerHTML = obj.body.message;
}


function singleError(obj) {
    removeAlerts();
    // activateButton(buttonId);
    activateButton('signup');

    const alert = document.querySelector(`.alert-${obj.body.dom}`); // alert-danger alert-signin-email // alert-signup-email
    // const alert = document.querySelector(`.alert-${obj.error}`); // alert-danger alert-signin-email
    if ( alert === null ) { return; } // [!]
    alert.hidden = false;
    alert.innerHTML = obj.body.message;
}


function multiError(obj) {
    removeAlerts();
    activateButton('signup');

    for (let i = 0; i < obj.body.length; i++) {
        const alert = document.querySelector(`.alert-${obj.body[i].dom}`); // alert-signup-name
        alert.hidden = false;
        alert.innerHTML = obj.body[i].message;
    }
}


const errorTemplate = (obj) => {
    const body = document.querySelector('BODY');
    const wrapper = document.createElement('DIV');
    wrapper.classList.add('error__wrapper');
    body.appendChild(wrapper);

    const table = document.createElement('TABLE');
    table.classList.add('error__table');
    wrapper.appendChild(table);

    // <THEAD>
    const thead = document.createElement('THEAD');
    thead.classList.add('error__thead');
    table.appendChild(thead);

    const tr = document.createElement('TR');
    tr.classList.add('error__tr');
    thead.appendChild(tr);

    const th = document.createElement('TH');
    th.classList.add('error__th');
    th.setAttribute('colspan', 2);
    thead.appendChild(th);

    const close = document.createElement('A');
    close.classList.add('error__close');
    close.setAttribute('href', '#');
    close.innerHTML = '&times;';
    th.appendChild(close);
    // </THEAD>

    const tbody = document.createElement('TBODY');
    tbody.classList.add('error__tbody');
    table.appendChild(tbody);

    for (const item in obj) {
      console.log(item);
      const tr = document.createElement('TR');
      tr.classList.add('error__tr');
      tbody.appendChild(tr);

      const th = document.createElement('TH');
      th.classList.add('error__th');
      th.setAttribute('colspan', 2);
      th.innerText = item;
      tr.appendChild(th);

        for (const key in obj[item]) {
        console.log(key);
        const tr = document.createElement('TR');
        tr.classList.add('error__tr');
        tbody.appendChild(tr);

        const th = document.createElement('TH');
        // th.setAttribute('colspan', '2');
        th.classList.add('error__th');

        th.innerText = key;
        tr.appendChild(th);

        const td = document.createElement('TD');
        td.classList.add('error__td');
        td.innerText = obj[item][key];
        tr.appendChild(td);
        }
    }
}



// TODO: permettere all' utente di inviare un messaggio al webmaster e riportare gli errori
// Disattivata momentaneamente
/*
function getFatalError(obj, message) {
    removeAlerts();
    activateButton(obj.head.page);

    const alert = document.querySelector(".alert-fatal-error");
    alert.hidden = false;

    const mess = document.createElement("p");
    mess.innerText = message +' codice errore: '+obj.code;

    const boxBtn = document.querySelector(".box-btn-fatal-error"); // bottone verify

    alert.insertBefore(mess, boxBtn);
}
*/

// Disattivata momentaneamente
/*
function sendVerifiedEmail(obj) {
    removeAlerts();
    activateButton(obj.head.page);

    const alert = document.querySelector(".alert-verify-email");
    alert.hidden = false;

    const mess = document.createElement("p");
    mess.innerText = obj.body.message;

    const boxBtn = document.querySelector(".box-btn-verify-email"); // bottone verify
    // const verifyBtn = document.querySelector("#verify"); // bottone verify
   // verifyBtn.hidden = false;

   // alert.appendChild(mess);
    alert.insertBefore(mess, boxBtn);
    const valueMailSignin = document.querySelector('#email-signin').value;   console.log(valueMailSignin);
    document.querySelector("#email-verify").value = valueMailSignin;
}
*/



export { deactivateButton, activateButton, singleError, singleErrorTest, multiError, errorTemplate };