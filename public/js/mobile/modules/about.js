function about(data, div) {

    /*
    * l'argomento div deve essere un contenitore full width
    * e al suo intenro dovrà avere due sezioni
    * la sezione di sopra è un div con id "about-title" che conterrà il titolo 'About'
    * la sezione di sotto è un div con id "about-content" che è full width e conterrà due colonne
    * le due colonne sono entrambi di solo testo
    */


    //div.id = "about-box"; // aggiunge 'id' al contenitore senza canvas
    
    // ABOUT TITOLO
    let aboutTitle = document.createElement("div"); // crea contenitore del titolo
    aboutTitle.id = "about-title"; // aggiunge 'id' al contenitore del titolo
    aboutTitle.classList.add("section-title"); // aggiunge 'id' al contenitore del titolo
    aboutTitle.innerHTML = "<p>About</p>"; // aggiunge il testo al contenitore del titolo
    div.appendChild(aboutTitle); // appende il contenitore senza canvas nel contenitore 'row'
    

    // ABOUT CONTENT (è full width e contiente due colonne)
    let aboutContent = document.createElement('div'); 
    aboutContent.id = 'about-content';
    aboutContent.classList.add("content"); // aggiunge la classe 'content'
    div.appendChild(aboutContent); // appende il contenitore del CONTENUTO
    
    let aboutInfoLeft = document.createElement('div'); // colonna di sinistra 
    aboutInfoLeft.classList.add("about__info-left"); // aggiunge la classe 'about__info-left'
    aboutContent.appendChild(aboutInfoLeft); // appende la colonna al contenitore'about-content' 

    let aboutInfoRight = document.createElement('div'); // colonna di sinistra 
    aboutInfoRight.classList.add("about__info-right"); // aggiunge la classe 'about__info-left'
    aboutContent.appendChild(aboutInfoRight); // appende la colonna al contenitore'about-content' 
    
    for (let i=0; i<data.length; i++) {

        let title = document.createElement('h4'); 
        title.classList.add("about__subtitle"); 
        title.innerHTML = data[i].title; 
        let info = document.createElement('p'); 
        info.classList.add("about__text"); 
        info.innerHTML = data[i].info; 

        if ( i < data.length * .5 ) {
            aboutInfoLeft.appendChild(title); 
            aboutInfoLeft.appendChild(info); 
        } else { 
            aboutInfoRight.appendChild(title); 
            aboutInfoRight.appendChild(info); 
        }
    }
}
export {about}

