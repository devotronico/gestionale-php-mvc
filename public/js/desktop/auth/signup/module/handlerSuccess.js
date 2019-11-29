import { removeAlerts, activateButton } from "./handlerCommon.js";

// function singleErrorTest(obj) { console.log('OK-1');
//     removeAlerts();
//     activateButton('signup');
//     const alert = document.querySelector(`.alert-${obj.body.dom}`);
//     if ( alert === null ) { return; } // [!]
//     alert.hidden = false;
//     alert.innerHTML = obj.body.message;
// }


function handlerUserSuccess(obj) {
    removeAlerts();
    activateButton('signup');
    const messageContainer = document.querySelector('.message-container');
    messageContainer.innerHTML = obj.body.message;
    // if ( alert === null ) { return; }
    // alert.hidden = false;
    // alert.innerHTML = obj.body.message;
}

export { handlerUserSuccess };