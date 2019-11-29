function portfolio(data, div) {


  // FONTAWESOME --> https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=web-fonts-with-css
  let fontawesome = document.querySelector('.fontawesome');
  if ( fontawesome == null ) { // se il link fontawesome non è stato ancora creato...

    let head = document.querySelector('head'); 
    let fontawesome = document.createElement('link');
    fontawesome.classList.add('fontawesome');   
    fontawesome.setAttribute('rel', 'stylesheet');   
    fontawesome.setAttribute('href', 'https://use.fontawesome.com/releases/v5.4.1/css/all.css');   // fontawesome.setAttribute('href', '/img/fontawesome/css/fontawesome-all.min.css');    
    fontawesome.setAttribute('integrity', 'sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz');   
    fontawesome.setAttribute('crossorigin', 'anonymous');   
    head.appendChild(fontawesome);
  }
  // END FONTAWESOME

  // portfolio
  div.id = "portfolio-box"; // aggiunge 'id' al contenitore senza canvas
  // portfolio TITOLO
  let title = document.createElement("div"); // crea contenitore del titolo
  title.id = "portfolio-title"; // aggiunge 'id' al contenitore del titolo
  title.classList.add("section-title"); // aggiunge 'id' al contenitore del titolo
  title.innerHTML = "<p>portfolio</p>"; // aggiunge il testo al contenitore del titolo
  div.appendChild(title); // appende il contenitore senza canvas nel contenitore 'row'

  // portfolio CONTENITORE FLEX (contiene tutte le card)
  let content = document.createElement("div"); // crea contenitore del titolo
  content.id = "portfolio-content"; // aggiunge 'id' al contenitore del titolo
  content.classList.add("content"); // aggiunge 'id' al contenitore del titolo

  div.appendChild(content); // appende il contenitore senza canvas nel contenitore 'row'

  // LOOP PER GENERARE LE CARD
  for (let i=0; i<data.length; i++) {
      // Card
      let card = document.createElement("div"); // crea contenitore del titolo
      card.classList.add("portfolio-card"); // aggiunge classe al contenitore senza canvas
      // Head
      let cardHead = document.createElement("div"); // crea contenitore del titolo
      cardHead.classList.add("portfolio-card__head"); // aggiunge classe al contenitore senza canvas
      cardHead.innerText = data[i].title; // aggiunge il testo al contenitore del titolo
      // Icon
      let cardIcon = document.createElement("div"); // crea contenitore del titolo
      cardIcon.classList.add("portfolio-card__icon"); // aggiunge classe al contenitore senza canvas
      cardIcon.innerHTML = data[i].icon; // aggiunge il testo al contenitore del titolo
// Body
let cardBody = document.createElement("div"); // crea contenitore del titolo
cardBody.classList.add("portfolio-card__body"); // aggiunge classe al contenitore senza canvas

      // Text
      let cardText = document.createElement("p"); // crea contenitore del testo
      cardText.classList.add("portfolio-card__text"); // aggiunge classe al contenitore del testo
      cardText.innerText = data[i].info; // aggiunge il testo al contenitore del testo
     
      // appende al contenitore 'card' i figli 'head, icon, text, link'
      content.appendChild(card); // appende il contenitore senza canvas nel contenitore 'row'
      card.appendChild(cardHead); // appende il contenitore 'head' al contenitore 'card'
      card.appendChild(cardIcon); // appende il contenitore 'icon' al contenitore 'card'
      card.appendChild(cardBody); // appende il contenitore 'icon' al contenitore 'card'
      
      cardBody.appendChild(cardText); // appende il contenitore 'text' al contenitore 'card'

       // Link
       let cardLink = document.createElement("a"); // crea contenitore del link
       cardLink.classList.add("portfolio-card__link"); // aggiunge classe al contenitore del link
       cardLink.setAttribute('href', data[i].link); // setta attributo 'href'
       cardLink.setAttribute('target', '_blank'); // setta attributo 'target'
       cardLink.innerText = data[i].linkText; // aggiunge il testo al contenitore del link
       cardBody.appendChild(cardLink); // appende il contenitore 'link' al contenitore 'card'
       card.appendChild(cardLink); // appende il contenitore 'link' al contenitore 'card'

  } // END FOR LOOP




  
  
}
export {portfolio}


