/*
window.onbeforeunload = function () { 
    window.scrollTo(0, 0); //quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
}
import {canvas, init, animate} from "../modules/animation.js"; 
console.log('home');



/********** CLICK ********** CLICK ********** CLICK ********** CLICK ********** CLICK **********/
/*
document.addEventListener('click', clickFunc, {passive: false}); 

let navbarIsOpen = false;

function clickFunc(e){ 

let element = e.target;


switch ( element.classList.item(0) ) { // controlliamo il nome della prima classe dell' elemento

    case 'toggleNav':   //se è stato cliccato il bottone del menu della navbar
        // alert('toggleNav'); 
        let nav = document.querySelector('nav'); 

        element.classList.toggle('open'); // aggiunge la classe .open al bottone del menu
        if ( navbarIsOpen === false) { // se navbarIsOpen è su false diventa true
            // console.log('DISATTIVA LO SCROLL');
            document.body.style.overflow = 'hidden'; // disattiva lo scroll
            nav.style.display = 'block'; // mostra la lista dei link per la navigazione
            //   navbarIsOpen = true;
        } else {    // se navbarIsOpen è su true diventa false
            //  console.log('ATTIVA LO SCROLL');
              document.body.style.overflow = 'visible'; 
              nav.style.display = 'none'; // nasconde la lista dei link per la navigazione
            
        }
        navbarIsOpen = !navbarIsOpen; // cambia lo stato da false a true e viceversa
    break; 

    case 'liNavLink' : //se è stato cliccato il tag <li> del menu della navbar
    
        e.preventDefault();
        setTimeout(function(){ console.log('navbarIsOpen = false'); navbarIsOpen = false; }, 500);
        document.body.style.overflow = 'visible'; // attiva lo scroll

        // se clicchiamo sul elemento <li> che NON ha link{href}
        // del tag <a> che è figlio dell' elemento  <li> 
        // seleziona il nome del link con l'hash{#}   
        //taglia il primo char che è il simbolo '#'.               
        // es. se il link è href="#contact" diventa contact 
        var goToId = element.firstElementChild.hash.slice(1);

        smoothScroll(document.getElementById(goToId)) // attiva lo scroll
        if ( window.innerWidth < 992 ) { // se la risoluzione è minore di ...

          document.querySelector('nav').style.display = 'none'; // chiude la nav che contiene la lista dei link
        }
        document.querySelector('.toggleNav').classList.toggle('open'); // 
    break;
   
    case 'aNavLink' : //se è stato cliccato il tag <a> del menu della navbar
    
        e.preventDefault();
        setTimeout(function(){ console.log('navbarIsOpen = false'); navbarIsOpen = false; }, 500);
        document.body.style.overflow = 'visible'; // attiva lo scroll

        // se clicchiamo sul elemento <a> che ha il link{href}
        // seleziona il nome del link con l'hash{#}   
        //taglia il primo char che è il simbolo '#'.               
        // es. se il link è href="#contact" diventa contact 
        var goToId = element.hash.slice(1);
        console.log(goToId);
        smoothScroll(document.getElementById(goToId))
        if ( window.innerWidth < 992 ) { // se la risoluzione è minore di ...
          document.querySelector('nav').style.display = 'none';
        }
        document.querySelector('.toggleNav').classList.toggle('open'); 
    break;
    case 'cover-btn': // se è stato cliccato il tag <a> del bottone sulla Cover
        e.preventDefault();
        var goToId = element.hash.slice(1);
        console.log(goToId);
        smoothScroll(document.getElementById(goToId))
    break;


    case 'liPageLink' : //se dal menu della navbar è stato cliccato il tag <li> del link per il blog 

        window.location.href = '/blog';
    break; 
    
    case 'aPageLink' : //se dal menu della navbar è stato cliccato il tag <a> del link per il blog 
        window.location.href = '/blog';

    break; 

    case 'scrollFA' :
    e.preventDefault();
    window.scrollTo({top: 0,behavior: "smooth"});
    //window.scrollTo(0, 0);
    //document.documentElement.scrollTop=0;

    //console.log(document.documentElement.scrollTop);
    break;


    default :

    if (navbarIsOpen) {  // se la navbar è aperta
        e.preventDefault();
    }
}

}

/********** END CLICK ********** END CLICK ********** END CLICK ********** END CLICK ********** END CLICK **********/






/**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********/


/********** AUTOMATIC SCROLL **********/
/*
window.smoothScroll = function(target) {
  var scrollContainer = target;
  do { //find scroll container
      scrollContainer = scrollContainer.parentNode;
      if (!scrollContainer) return;
      scrollContainer.scrollTop += 1;
  } while (scrollContainer.scrollTop == 0);
  
  var targetY = 0;
  do { //find the top of target relatively to the container
      if (target == scrollContainer) break;
     
      targetY += target.offsetTop;
  } while (target = target.offsetParent);
  
  scroll = function(c, a, b, i) {
      i++; if (i > 30) return;
      c.scrollTop = a + (b - a) / 30 * i;
      setTimeout(function(){ scroll(c, a, b, i); }, 20);
  }
  // start scrolling
  scroll(scrollContainer, scrollContainer.scrollTop, targetY, 0);
}
/********** END AUTOMATIC SCROLL **********/
/*

document.addEventListener('scroll', Scrolling, false);

//altezzaTotale = document.body.scrollHeight; // [!]

// variabili per lo scroll loading
let altezza = document.querySelector('#portfolio').offsetTop - window.innerHeight * 0.8;
const state = ['init', 'portfolio', 'skill', 'contact', 'canvas', 'footer', 'end'];
let indexOfState = 0;

// variabili per lo scroll navbar
let offset = 0;
let navbar = document.querySelector('header');
let scrollBtn = document.querySelector('#btn-scroll');

function Scrolling(e) {


/**********SCROLL NAVBAR AND BUTTON ANIMATION*********/
/*
  if ( window.scrollY > offset ) {

    navbar.classList.add('nav-bottom');
    navbar.classList.remove('nav-top');

    if (!scrollBtn.classList.contains('scrollDown')) {
     
      scrollBtn.classList.remove('scrollTop');
      scrollBtn.classList.add('scrollDown');
    }

  } else {

    navbar.classList.add('nav-top');
    navbar.classList.remove('nav-bottom');

    if (scrollBtn.classList.contains('scrollDown')) {
      
      scrollBtn.classList.replace('scrollDown','scrollTop');
    }
  }
/*********END*SCROLL NAVBAR *********/



/**********SCROLL LOADING*********/
/*
  if ( window.scrollY > altezza ) {
    
    indexOfState++;

    switch( state[indexOfState] ) {

      case 'portfolio': //APRE PORTFOLIO ------------------------------------------------------
        console.log('portfolio loading'); 

        let head = document.querySelector('head');

        // FONTAWESOME --> <link href="img/fontawesome/css/fontawesome-all.min.css" rel="stylesheet">
        let fontawesome = document.createElement('link');
        fontawesome.setAttribute('rel', 'stylesheet');   
        fontawesome.setAttribute('href', '/img/fontawesome/css/fontawesome-all.min.css');  
        head.appendChild(fontawesome);

        // DEVICON --> <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css">
        let devicon = document.createElement('link');
        devicon.setAttribute('rel', 'stylesheet');   
        devicon.setAttribute('href', 'https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css');  
        head.appendChild(devicon);


        let body = document.querySelector('body');
        altezza = document.querySelector('#skill').offsetTop - window.innerHeight * 0.8;
        console.log('portfolio completato'); 
      break;  //CHIUDE PORTFOLIO

      case 'skill':  //APRE SKILLS ------------------------------------------------------
        console.log('skill loading'); 
        altezza = document.querySelector('#contact').offsetTop - window.innerHeight * 0.8;
        console.log('skills completato'); 
      break;  //CHIUDE SKILLS

      case 'contact': //APRE CONTACT ------------------------------------------------------
        console.log('contact loading'); 
        altezza = document.querySelector('#canvas').offsetTop - window.innerHeight * 0.8;
        console.log('contact completato');
      break; // CHIUDE CONTACT 

      case 'canvas': //APRE CANVAS ------------------------------------------------------
        console.log('canvas loading'); 
        
       
        // import {init, animate} from "./modules/animation.js";
        var play = true;
        init();
        animate(play);
        canvas.addEventListener('click', function(){

            play = !play;
            animate(play);
        });


        altezza = document.querySelector('#footer').offsetTop - window.innerHeight * 0.8;
        console.log('canvas completato');
      break; // CHIUDE CANVAS 

      case 'footer':   //APRE FOOTER ------------------------------------------------------
        console.log('footer loading');

        console.log('footer completato');
      break; //CHIUDE FOOTER
    }
  }
}

/**********END SCROLL LOADING*********/

     






