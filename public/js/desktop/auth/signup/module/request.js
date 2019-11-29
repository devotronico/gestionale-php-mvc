import { deactivateButton, activateButton } from './handlerCommon.js';
import { singleError, singleErrorTest, multiError, errorTemplate } from './handlerErrors.js';
import { handlerUserSuccess } from './handlerSuccess.js';


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
    return new Promise((resolve, reject) => {
        const xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
        xhr.onreadystatechange = function() {
            switch ( this.readyState ) {
                case 0: console.log('readyState 0: '+xhr.readyState); break;
                case 1: console.log('readyState 1: '+xhr.readyState);
                    deactivateButton(path);
                    break;
                case 2: console.log('readyState 2: '+xhr.readyState); break;
                case 3: console.log('readyState 3: '+xhr.readyState); break;
                case 4: console.log('readyState 4: '+xhr.readyState);

                    if (this.status >= 200 && this.status < 300) {
                        console.log(xhr.responseText);
                        const obj = JSON.parse(xhr.responseText); console.log(obj);

                        if (!obj.head.hasOwnProperty('status')) { return reject('TEST'); }

                        if (obj.head.status === 'error') {
                            // console.log(typeof obj.head.code);
                            switch (obj.head.code) {
                            /*case 0: errorTemplate(obj); break*/
                            case 0: singleErrorTest(obj); break
                            case -10: singleError(obj); break
                            case -15: multiError(obj); break
                            case -20:
                            case -30: errorTemplate(obj); break
                            }
                            reject('ERRORE');
                        } else if (obj.head.status === 'success') {
                            switch (obj.head.code) {
                                case 10: handlerUserSuccess(obj); break
                                case 20: errorTemplate(obj); break
                            }
                            activateButton(obj.body.dom);
                            // resolve(obj.body.email);
                        }
                    } else {
                        //activateButton(obj.page);
                        reject("Errore code:"+this.status);
                    }
            break;
            }
        };
        xhr.open('POST', path, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.send(data);
    });
}

export { request };
