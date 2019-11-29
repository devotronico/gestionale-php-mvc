// RICHIESTA FILE DI JSON --------------------------------------------------
function request(section, file, div) {
    let xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
    
            section(JSON.parse(xhttp.responseText), div);
        }
    };
    xhttp.open("GET", "data/data-"+file+".json", true);
    xhttp.send();
}
// END RICHIESTA FILE DI JSON --------------------------------------------------

export {request}