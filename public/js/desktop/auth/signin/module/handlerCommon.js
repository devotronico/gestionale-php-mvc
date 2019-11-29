function removeAlerts() {
    const alerts = document.querySelectorAll('.alert');
    for ( const alert of alerts ) { alert.hidden = true; }
}


function deactivateButton() {
    removeAlerts();

    const email = document.querySelector('#signin-email');
    email.disabled = true;

    const password = document.querySelector('#signin-password');
    password.disabled = true;

    const button = document.querySelector('#signin-btn');
    button.disabled = true;
    button.innerHTML = `<span>&nbspLoading...</span>`;
    // button.innerHTML = `<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>&nbspLoading...`;
}


/**
 * @author  Daniele Manzi
 * @updated 6-23-2019
 * Seleziona il bottone del form e
 * - rimette il testo nel valore iniziale (Accedi)
 * - rimuove l'attributo disabled
 * Seleziona tutti gli elementi input e per ognuno di essi viene
 * rimosso l'attributo disabled
 */
function activateButton() {
    const element = document.querySelector('#signin-btn');
    element.innerText = 'Accedi';
    element.removeAttribute('disabled');

    const inputs = document.querySelectorAll('INPUT');
    inputs.forEach(input => {
        input.disabled = false;
    });
}

export { removeAlerts, deactivateButton, activateButton };



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