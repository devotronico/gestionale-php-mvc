function skill(data, div) {


    // DEVICON --> http://konpa.github.io/devicon/ <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css">
    let head = document.querySelector('head'); // il link deve essere inserito nel tag head del documento html
    let devicon = document.createElement('link');
    devicon.setAttribute('rel', 'stylesheet');   
    devicon.setAttribute('href', 'https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css');  
    head.appendChild(devicon);

    //let icon = ['html5', 'css3', 'javascript', 'jquery', 'php', 'mysql', 'bootstrap', 'git', 'github', 'photoshop', 'inkscape', 'visualstudio',]
    // SKILL
    //div.id = "skill-box"; // aggiunge 'id' al contenitore senza canvas
    // SKILL TITOLO
    let skillTitle = document.createElement("div"); // crea contenitore del titolo
    skillTitle.id = "skill-title"; // aggiunge 'id' al contenitore del titolo
    skillTitle.classList.add("section-title"); // aggiunge 'id' al contenitore del titolo
    skillTitle.innerHTML = "<p>Skills</p>"; // aggiunge il testo al contenitore del titolo
    div.appendChild(skillTitle); // appende il contenitore senza canvas nel contenitore 'row'

    // SKILL CONTENITORE FLEX (contiene tutte le icone)
    let skillContent = document.createElement("div"); // crea contenitore del titolo
    skillContent.id = "skill-content"; // aggiunge 'id' al contenitore del titolo
    skillContent.classList.add("content"); // aggiunge la classe 'content'
    div.appendChild(skillContent); // appende il contenitore senza canvas nel contenitore 'row'

   
   

    // LOOP PER GENERARE LE CARD
    for (let i=0; i<data.length; i++) {
      
        // Icone
        let skillIcon = document.createElement("div"); // crea contenitore del titolo
        skillIcon.classList.add("skill-icon"); // aggiunge classe al contenitore senza canvas
        skillIcon.innerHTML = "<i class='devicon-"+data[i].icon+"-plain colored'></i>"; // aggiunge il testo al contenitore del titolo
        //skillIcon.innerHTML = "<i class='devicon-"+icon[i]+"-plain colored'></i>"; // aggiunge il testo al contenitore del titolo
    
        skillContent.appendChild(skillIcon); // appende al contenitore 'skill-container' i figli 'skill-icon'
    } // END FOR LOOP
}
export {skill}