// import { removeAlerts, activateButton } from "./handlerCommon.js";


/**
 * Mostra un messaggio di riuscito login/accesso.
 * Nasconde il form con i rispettivi campi input e il bottone.
 * Nella barra di navigazione:
 * - nasconde i link con label "Accedi" e "Registrati"
 * - mostra il link con label: "Docs", "New Doc", "Profilo", "Logout"
 * @param {object} obj - viene utilizzata solo la proprietà obj.body.message
 */
function handlerUserSuccess(obj) {
    const navProfil = document.querySelector('.nav-user > a');
    navProfil.href = `/user/${obj.body.id}`;
    navProfil.innerHTML = obj.body.name;
    console.log(obj.body.name);
    const messageContainer = document.querySelector('.message-container');
    messageContainer.innerHTML = obj.body.message;

    document.querySelector('#signin-form').hidden = true;

    const hideElements = document.querySelectorAll('.nav-li');
    hideElements.forEach(element => {
        if (element.classList.contains('nav-hide')) { console.log('nav-hide');
            element.classList.remove('nav-hide');
            element.classList.add('nav-show');
        } else if (element.classList.contains('nav-show')) {
            element.classList.remove('nav-show');
            element.classList.add('nav-hide');
        }
    });
}

export { handlerUserSuccess };