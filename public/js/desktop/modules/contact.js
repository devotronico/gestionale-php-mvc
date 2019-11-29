function contact(data, div) {




    div.id = "contact-box"; // aggiunge 'id' al contenitore senza canvas


    // CONTACT TITOLO
    let contactTitle = document.createElement("div"); // crea contenitore del titolo
    contactTitle.id = "contact-title"; // aggiunge 'id' al contenitore del titolo
    contactTitle.classList.add("section-title"); // aggiunge 'id' al contenitore del titolo
    contactTitle.innerHTML = "<p>Contact</p>"; // aggiunge il testo al contenitore del titolo
    div.appendChild(contactTitle); // appende il contenitore senza canvas nel contenitore 'row'

    // CONTACT CONTENT (contiene il form)
    let contactContent = document.createElement('form'); 
    contactContent.id = 'contact-content';
    contactContent.classList.add("content"); // aggiunge la classe 'content'
    contactContent.setAttribute('method', 'post');   
    contactContent.setAttribute('action', '/home/contact'); 
    div.appendChild(contactContent);
        
    for (let i=0; i<data.length; i++) {
        let element = document.createElement(data[i].tag); // CREA TAG INPUT PER OGNI ELEMENTO DEL FORM
        if ( i < 5) { 
            // crea tag LABEL
            let label = document.createElement('label');
            label.setAttribute('for', data[i].field);
            label.innerHTML = data[i].field;
            contactContent.appendChild(label); 
        
            // crea tag INPUT
            element.classList.add("contact__input"); // aggiunge la classe 'content'
            element.setAttribute('type', data[i].type);   
            element.setAttribute('name', data[i].field);    
            element.setAttribute('placeholder', data[i].field); 
            element.setAttribute('maxlength', data[i].textLen); 
            if ( i==4) { //attributi aggiuntivi solo per il tag TEXTAREA 
                element.setAttribute('rows', '3');  
                element.setAttribute('cols', '50'); 
            }
        } else { // attributi esclusivi per il bottone SUBMIT
           
            element.setAttribute('type', data[i].type);  
            element.setAttribute('id', 'contact-btn');    
            element.setAttribute('value', data[i].field); 
        }
        contactContent.appendChild(element); 
    }
}
export {contact}


