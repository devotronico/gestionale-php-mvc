function removeAlerts() {
    const alerts = document.querySelectorAll('.alert');
    for ( const alert of alerts ) { alert.hidden = true; }
}

// TODO: disattivare anche i campi input name, email, password
function _deactivateButton(path) {
    const type = path.split('/')[2];
    const lista = ['signin', 'signup'];
    if ( lista.indexOf(type) === -1 ) return;
    removeAlerts();

    if ( type === 'signup' ) {
        const name = document.querySelector('#name-'+type);
        name.disabled = true;
    }
    const email = document.querySelector('#email-'+type);
    email.disabled = true;

    const password = document.querySelector('#password-'+type);
    password.disabled = true;

    const button = document.querySelector('#'+type);
    button.disabled = true;
    button.innerHTML = `<span>&nbspLoading...</span>`;
    // button.innerHTML = `<span class='spinner-border spinner-border-sm' role='status' aria-hidden='true'></span>&nbspLoading...`;
}


function deactivateButton() {
    removeAlerts();

    const name = document.querySelector('#signup-name');
    name.disabled = true;

    const email = document.querySelector('#signup-email');
    email.disabled = true;

    const password = document.querySelector('#signup-password');
    password.disabled = true;

    const button = document.querySelector('#signup-btn');
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
    const element = document.querySelector('#signup-btn');
    element.innerText = 'Registrati';
    element.removeAttribute('disabled');

    const inputs = document.querySelectorAll('INPUT');
    inputs.forEach(input => {
        input.disabled = false;
    });
}

export { removeAlerts, deactivateButton, activateButton };