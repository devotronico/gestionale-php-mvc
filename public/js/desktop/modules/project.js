function project(data, div) {


  // FONTAWESOME --> https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=web-fonts-with-css
  let fontawesome = document.querySelector('.fontawesome');
  if ( fontawesome == null ) { // se il link fontawesome non è stato ancora creato...
      
    let head = document.querySelector('head'); // il link deve essere inserito nel tag head del documento html
    let fontawesome = document.createElement('link');
    fontawesome.classList.add('fontawesome');   
    fontawesome.setAttribute('rel', 'stylesheet');   
    fontawesome.setAttribute('href', 'https://use.fontawesome.com/releases/v5.4.1/css/all.css');   // fontawesome.setAttribute('href', '/img/fontawesome/css/fontawesome-all.min.css');    
    fontawesome.setAttribute('integrity', 'sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz');   
    fontawesome.setAttribute('crossorigin', 'anonymous');   
    head.appendChild(fontawesome);
  }
  // END FONTAWESOME

  // PROJECT
  div.id = "project-box"; // aggiunge 'id' al contenitore senza canvas
  // PROJECT TITOLO
  let projectTitle = document.createElement("div"); // crea contenitore del titolo
  projectTitle.id = "project-title"; // aggiunge 'id' al contenitore del titolo
  projectTitle.classList.add("section-title"); // aggiunge 'id' al contenitore del titolo
  projectTitle.innerHTML = "<p>Projects</p>"; // aggiunge il testo al contenitore del titolo
  div.appendChild(projectTitle); // appende il contenitore senza canvas nel contenitore 'row'

  // PROJECT CONTENITORE FLEX (contiene tutte le card)
  let projectContent = document.createElement("div"); // crea contenitore del titolo
  projectContent.id = "project-content"; // aggiunge 'id' al contenitore del titolo
  projectContent.classList.add("content"); // aggiunge 'id' al contenitore del titolo

  div.appendChild(projectContent); // appende il contenitore senza canvas nel contenitore 'row'

  // LOOP PER GENERARE LE CARD
  for (let i=0; i<data.length; i++) {
      // Card
      let projectCard = document.createElement("div"); // crea contenitore del titolo
      projectCard.classList.add("project-card"); // aggiunge classe al contenitore senza canvas
      // Head
      let projectCardHead = document.createElement("div"); // crea contenitore del titolo
      projectCardHead.classList.add("project-card__head"); // aggiunge classe al contenitore senza canvas
      projectCardHead.innerText = data[i].title; // aggiunge il testo al contenitore del titolo
      // Icon
      let projectCardIcon = document.createElement("div"); // crea contenitore del titolo
      projectCardIcon.classList.add("project-card__icon"); // aggiunge classe al contenitore senza canvas
      projectCardIcon.innerHTML = data[i].icon; // aggiunge il testo al contenitore del titolo
// Body
let projectCardBody = document.createElement("div"); // crea contenitore del titolo
projectCardBody.classList.add("project-card__body"); // aggiunge classe al contenitore senza canvas

      // Text
      let projectCardText = document.createElement("p"); // crea contenitore del testo
      projectCardText.classList.add("project-card__text"); // aggiunge classe al contenitore del testo
      projectCardText.innerText = data[i].info; // aggiunge il testo al contenitore del testo
      // Link
      let projectCardLink = document.createElement("a"); // crea contenitore del link
      projectCardLink.classList.add("project-card__link"); // aggiunge classe al contenitore del link
      projectCardLink.setAttribute('href', data[i].link); // setta attributo 'href'
      projectCardLink.setAttribute('target', '_blank'); // setta attributo 'target'
      projectCardLink.innerText = data[i].linkText; // aggiunge il testo al contenitore del link
      // appende al contenitore 'card' i figli 'head, icon, text, link'
      projectContent.appendChild(projectCard); // appende il contenitore senza canvas nel contenitore 'row'
      projectCard.appendChild(projectCardHead); // appende il contenitore 'head' al contenitore 'card'
      projectCard.appendChild(projectCardIcon); // appende il contenitore 'icon' al contenitore 'card'
      projectCard.appendChild(projectCardBody); // appende il contenitore 'icon' al contenitore 'card'
      projectCardBody.appendChild(projectCardText); // appende il contenitore 'text' al contenitore 'card'
      projectCardBody.appendChild(projectCardLink); // appende il contenitore 'link' al contenitore 'card'
  } // END FOR LOOP
}
export {project}


