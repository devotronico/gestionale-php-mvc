import { deactivateButton, activateButton, removeAlerts } from './handlerCommon.js';
import { singleError, singleErrorTest, multiError, errorTemplate } from './handlerErrors.js';
import { handlerUserSuccess } from './handlerSuccess.js';




function IsValidJSONString(str) {
    try {
        return JSON.parse(str);
    } catch (e) {
        return false;
    }
   // return JSON.parse(str);
}

// RICHIESTA FILE DI JSON --------------------------------------------------
/**
 *
 * @param {string} path - path php al quale fare la request
 * @param {string} data - stringa json da far processare lato backend
 *
 * readyState values:
 * 0: request not initialized (.onerror)
 * 1: server connection established
 * 2: request received
 * 3: processing request (.onprogress)
 * 4: request finished and response is ready (.onload)
 *
 * HTTP Status
 * 200: "OK"
 * 403: "Forbidden"
 * 404: "Not Found"
 */
function request(path, data=null) { 
    console.log("TCL: request -> data", data)
    return new Promise((resolve, reject) => {
        const xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        xhr.onreadystatechange = function() {
            switch (this.readyState) {
                case 0: console.log('readyState 0: '+xhr.readyState); break;
                case 1: console.log('readyState 1: '+xhr.readyState);
                    deactivateButton();
                    break;
                case 2: console.log('readyState 2: '+xhr.readyState); break;
                case 3: console.log('readyState 3: '+xhr.readyState); break;
                case 4: console.log('readyState 4: '+xhr.readyState);

                    if (this.status >= 200 && this.status < 300) {
                       // console.log(xhr.responseText);
                       // const obj = JSON.parse(xhr.responseText); console.log(obj);

                        const obj = IsValidJSONString(xhr.responseText);

                        if (!obj) { return reject(xhr.responseText); }
                        console.log(obj);
                        // controllare se l'oggetto ha la proprieta` head
                        if (!obj.head.hasOwnProperty('status')) { return reject('TEST'); }

                        if (obj.head.status === 'success') {
                            switch (obj.head.code) {
                                case 10: handlerUserSuccess(obj); break
                                case 20: errorTemplate(obj); break // caso che si verifica?
                            }
                        } else if (obj.head.status === 'error') {
                            removeAlerts();
                            activateButton();
                            switch (obj.head.code) {
                            // case 0: errorTemplate(obj); break
                            case 0: singleErrorTest(obj); break
                            case -10: singleError(obj); break
                            case -11: singleError(obj); break
                            case -15: multiError(obj); break
                            case -20:
                            case -30: errorTemplate(obj); break
                            case -50: errorTemplate(obj); break
                            }
                            reject('ERRORE');
                        } else if (obj.head.status === 'hacking') {
                            removeAlerts();
                            activateButton();
                            switch (obj.head.code) {
                                case -40: errorTemplate(obj); break
                                case -41: errorTemplate(obj); break // codice non ancora utilizzato
                            }
                            reject('ERRORE');
                        }
                    } else {
                        reject("Errore code:"+this.status);
                    }
            break;
            }
        };
        xhr.open('POST', path, true);
        xhr.setRequestHeader('HTTP_X_REQUESTED_WITH', 'XMLHttpRequest');
        xhr.setRequestHeader('Accept', 'application/json');
        // xhr.setRequestHeader('Content-type', 'application/json');
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(data);
    });
}

export { request };
