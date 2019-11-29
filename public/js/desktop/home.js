import {initCanvas, canvasResize, indexOfBall, animate} from "./modules/canvas.js"; // <--import deve andare prima dell evento 'DOMContentLoaded'
import{request} from "./modules/request.js";
import{portfolio} from "./modules/portfolio.js";
import{project} from "./modules/project.js";
import{skill} from "./modules/skill.js";
import{contact} from "./modules/contact.js";
import{about} from "./modules/about.js";
import{footer} from "./modules/footer.js";
import{debug} from "./modules/debug.js";
import{navbarRefresh, navbarClick, navbarScroll, navbarResize} from "./modules/navbar.js";


    
//==VARIABILI==    
let section = [
    {init: false, direction: 'vertical',   fn: portfolio, name: 'portfolio', color1: '#fff', color2: '#2c8cff'},
    {init: false, direction: 'vertical',   fn: project,   name: 'project', color1: '#fff', color2: '#2c8cff'},
    {init: false, direction: 'vertical',   fn: skill,     name: 'skill', color1: '#2c8cff', color2: '#fff'},
    {init: false, direction: 'vertical',   fn: contact,   name: 'contact', color1: '#2c8cff', color2: '#fff'},
    {init: false, direction: 'full',       fn: about,     name: 'about', color1: '#2c8cff', color2: '#fff'}, 
    {init: false, direction: 'horizontal', fn: footer,    name: 'footer', color1: '#fff', color2: '#2c8cff'}
];

let num; // contatore dei contenitori
const heightTrigger = -200 // window.innerHeight/2; // variabile che determina in che altezza della pagina attivare il prossimo canvas
let play = true; // attiva e disattiva l' animazione
let containerList = document.querySelectorAll('.wrapper'); // il numero dei contenitori da scrollare
const listOffSetTop = []; // lista del valore 'offsetTop' di ogni contenitore
for (let i=0; i<containerList.length; i++) { 
    listOffSetTop.push(containerList[i].offsetTop); // inizializza la lista di 'offsetTop' 
} 


// console.dir('altezza con scroll 1 : '+document.scrollingElement.scrollTop+' e num: '+num);
// console.dir('altezza con scroll 2 : '+window.scrollY+' e num: '+num);


function loadSection(){
    
    let start = listOffSetTop[0] + heightTrigger;

    if (window.scrollY < start  ) { // lo scroll è nella cover
        play = false; 
        indexOfBall(section[0].name); // disattiva l'animazione a ultima palla prima della cover
        animate(play);  // disattiva l'animazione a ultimo palla 
        return
    }
    else 
    {
        for (let i=0; i<listOffSetTop.length; i++) {

            let begin = listOffSetTop[i] + heightTrigger;

            let end = listOffSetTop[i+1] ? listOffSetTop[i+1] + heightTrigger : 100000;

            if (window.scrollY > begin && window.scrollY < end ) { 
                if (num != i) {num = i; play = false;} 
            } 
        }
    }

   
    if ( num != undefined ) { // evita di caricare se ci troviamo nella cover
        if (!section[num].init) { // se il canvas e la palla non sono stati ancora creati
            section[num].init = true; // settiamo questo elemento con il canvas e la palla come creati
    
            initSection(section[num].direction, section[num].fn, section[num].name, section[num].color1, section[num].color2);
        } 

   
        if ( section[num].name != 'about') { // se non c'è il canvas (in about non c'è il canvas)
        
            // SELEZIONA CANVAS E BALL 
            if ( !play ) {
                indexOfBall(section[num].name); // disattiva l'animazione a questa palla
              
                animate(play);  // disattiva l'animazione a questa palla
                if ( window.innerWidth >= 320 ) { 
                    play = true;
                    animate(play);
                }
            }
            // END SELEZIONA CANVAS E BALL 
        }
    }
}


function initSection(direction, sectionFunction, sectionString, color1, color2 ){

    let section = document.querySelector("#"+sectionString); // seleziona la riga
    let div = document.createElement("div"); // contenitore senza canvas
    div.classList.add("col-"+direction); // aggiunge classe al contenitore senza canvas
    div.classList.add("col-"+num); // aggiunge classe al contenitore senza canvas
    section.appendChild(div); // appende il contenitore senza canvas nel contenitore 'section'
    section.classList.add('section-anim-alpha');
    request(sectionFunction, sectionString, div); // chiamata XMLHttpRequest

   

    if (  sectionString != 'about') { 
    
        // CREA CANVAS E BALL 
        let bgColor = color1; // colore sfondo canvas
        let ballColor = color2; // colore palla    
        let canvasBox = document.createElement("div"); // contenitore del canvas
        canvasBox.classList.add("col-"+direction+"-canvas");
        canvasBox.classList.add("col-canvas-"+sectionString);
        section.appendChild(canvasBox);
        initCanvas( sectionString, canvasBox, bgColor, ballColor); // crea un canvas e la sua palla
        // END CREA CANVAS E BALL 
    }
}



//========================================================================================================================
// EVENTI
//========================================================================================================================
// REFRESH DELLA PAGINA --------------------------------------------------------------------------
// loadSection();  // carica la sezione attuale al refresh della pagina
// navbarRefresh(); 
// END REFRESH DELLA PAGINA ----------------------------------------------------------------------

console.log('1');


// SCROLL ----------------------------------------------------------------------------------------

document.addEventListener('scroll', scrollFunc); // evento scroll

function scrollFunc() { // funzione di scroll
    console.log('OOOOKKKKK');
    loadSection();
    navbarScroll();
    debug(listOffSetTop, heightTrigger. num); 
}// chiude funzione scrollFunc




// CLICK ----------------------------------------------------------------------
document.addEventListener('click', function(e){

    navbarClick(e);
    //navbarEffect();
    play = !play;
    indexOfBall(section[num].name); // e.target.id può restituire uno dei seguenti valori: 'portfolio', 'project', 'skill', 'contact', 'footer'

    animate(play);
});
// END CLICK ----------------------------------------------------------------------




// RESIZE ----------------------------------------------------------------------
/*
* OTTIMIZZAZIONI PER IL RESIZE
* http://loopinfinito.com.br/2013/09/24/throttle-e-debounce-patterns-em-javascript/
* https://davidwalsh.name/javascript-debounce-function
* https://www.html5rocks.com/en/tutorials/speed/animations/
*/
window.addEventListener('resize', function(){
    navbarResize();
    canvasResize();
});
// END RESIZE ----------------------------------------------------------------------



// Carica gif della cover
let downloadingImage = new Image(); // crea elemento immagine

downloadingImage.src = "/img/gif/cover_anim.gif"; // assegna percorso della gif da caricare

downloadingImage.onload = function(){ // se il file immagine è stato caricato

    document.querySelector(".loader").classList.add('hidden'); // nasconde la schermata di caricamento
    let elements = document.querySelector("#cover__animation-gif"); // seleziona elemento al quale deve essere assegnato la gif
    elements.src = this.src;   // assegna il percorso del file della gif
    document.body.style.overflow = 'visible'; // attiva lo scroll per la pagina 

/*
    let head = document.querySelector('head'); 
    for (let i=0; i<containerList.length; i++) {
        let css = document.createElement('link');
        css.setAttribute('rel', 'stylesheet');   
        css.setAttribute('href', 'css/'+section[i].name+'.css'); 
        // css.setAttribute('href', 'css/project.css'); 
        head.appendChild(css);
    }
*/
    loadSection();  // carica la sezione attuale al refresh della pagina
    navbarRefresh(); 
}



