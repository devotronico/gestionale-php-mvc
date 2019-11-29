function requestTemplate(template, message) {
    return new Promise((resolve, reject) =>{
        const xhr = typeof XMLHttpRequest != 'undefined' ? new XMLHttpRequest() : new ActiveXObject('Microsoft.XMLHTTP');
		console.log("TCL: requestTemplate -> xhr", xhr)
        xhr.open('GET', '/auth/signup/template', true);
        // xhr.open('GET', `/layout/inc/${template}`, true);
        xhr.onreadystatechange = function() {

            if (xhr.readyState == 4 ) {

                if (this.status >= 200 && this.status < 300) {
                    // document.querySelector('#message-container').innerHTML = xhr.responseText;
                    resolve(message);
                } else {
                    reject("Errore: html non caricato" );
                }
            }
        }
        xhr.send();
    });
}


export { requestTemplate };