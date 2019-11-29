
let offset = 0; 
let navbar = document.querySelector('header');


/******************** REFRESH ********************/
/*
* AL REFRESH APPLICA EFFETTI ALLA NAVBAR
* Alla navbar aumenta l' opacità(no trasparenza) quando è verso il fondo della pagina
*/
function navbarRefresh(){
   
    console.log('REFRESH');
    // console.log('document.body.scrollTop: '+document.body.scrollTop);
    // console.log('document.documentElement.scrollTop: '+document.documentElement.scrollTop);
    // console.log('window.pageYOffset: '+window.pageYOffset);
    // console.log('window.scrollY: '+window.scrollY);
    if ( window.innerWidth >= 768 ) {
        if ( window.scrollY > offset ) { // se lo scroll NON è in cima(TOP) ma si trova più in basso

            navbar.classList.add('navbar__refresh-down'); // aggiunge una classe senza animazione 
        } 
        else 
        {
            navbar.classList.add('navbar__refresh-up'); // aggiunge una classe senza animazione 
        }
    }
}




/******************** SCROLL ********************/
// navbar__refresh-up
/*
* AL SCROLL APPLICA EFFETTI ALLA NAVBAR
* Alla navbar diminuisce l' opacità quando è in cima della pagina
* Alla navbar aumenta l' opacità quando è verso il fondo della pagina
*/
function navbarScroll(){

    if ( window.innerWidth >= 768 ) {

        if ( window.scrollY > offset ) { // se lo scroll NON è in cima(TOP) ma si trova più in basso

            if (!navbar.classList.contains('navbar__refresh-down')) { // Se è già presente la classe aggiunta con il refresh evita di aggiungere la classe 'navbar__move-down'

                navbar.classList.add('navbar__move-down');
            }

            navbar.classList.remove('navbar__refresh-up'); 
            navbar.classList.remove('navbar__move-up');

        } else { // se lo scroll è in cima(TOP) alla pagina
        
            navbar.classList.add('navbar__move-up');
            navbar.classList.remove('navbar__move-down');
            navbar.classList.remove('navbar__refresh-down');
        }
    }
}
// END NAVBAR EFFECT ON SCROLL ----------|----------|----------|----------|----------|----------|----------







/******************** CLICK ********************/
let navbarIsOpen = false;   

function navbarClick(e){ 

    let element = e.target;

    switch ( element.classList.item(0) ) { // controlliamo il nome della prima classe dell' elemento

    case 'toggleNav':   //se è stato cliccato il bottone del menu della navbar
       
        element.classList.toggle('open'); // aggiunge la classe .open al bottone del menu
        if ( navbarIsOpen === false) { // se navbarIsOpen è su false diventa true
          
            document.body.style.overflow = 'hidden'; // disattiva lo scroll
            document.querySelector('nav').style.display = 'block'; // mostra la lista dei link per la navigazione

        } else {    
          
              document.body.style.overflow = 'visible'; // attiva lo scroll
              document.querySelector('nav').style.display = 'none'; // nasconde la lista dei link per la navigazione
        }
        navbarIsOpen = !navbarIsOpen; // cambia lo stato da false a true e viceversa
    break; 

    case 'liNavLink' : //se è stato cliccato il tag <li> del menu della navbar
    case 'aNavLink' : //se è stato cliccato il tag <a> del menu della navbar
    
     //   e.preventDefault();
        setTimeout(function(){ navbarIsOpen = false; }, 500);
        document.body.style.overflow = 'visible'; // attiva lo scroll

        // se clicchiamo sul elemento <li> che NON ha link{href}
        // del tag <a> che è figlio dell' elemento  <li> 
        // seleziona il nome del link con l'hash{#}   
        //taglia il primo char che è il simbolo '#'.               
        // es. se il link è href="#contact" diventa contact 
      //  goToId = element.firstElementChild.hash.slice(1); console.log(goToId);
      //  goToId = element.hash.slice(1); console.log(goToId);

        let goToId = element.hash? element.hash.slice(1) : element.firstElementChild.hash.slice(1); 
   
        smoothScroll(document.getElementById(goToId)) // attiva lo scroll
        if ( window.innerWidth < 768 ) { // se la risoluzione è minore di ...

          document.querySelector('nav').style.display = 'none'; // chiude la nav che contiene la lista dei link
        }
        document.querySelector('.toggleNav').classList.toggle('open'); // 

    break;

    case 'liPageLink' : //se dal menu della navbar è stato cliccato il tag <li> del link per il blog 
    case 'aPageLink' :  //se dal menu della navbar è stato cliccato il tag <a> del link per il blog 
        window.location.href = '/blog';
    break; 

    case 'cover__btn': // se è stato cliccato il tag <a> del bottone sulla Cover
     //   e.preventDefault();
        let linkToId = element.hash.slice(1);
       // console.log(goToId);
        smoothScroll(document.getElementById(linkToId))
    break;

    default :

    if (navbarIsOpen) {  // se la navbar è aperta
        e.preventDefault();
        e.stopPropagation();
    }
}

}


/********** RESIZE ********** RESIZE ********** RESIZE ********** RESIZE ********** RESIZE **********/
// RESIZE NAVBAR
function navbarResize() {  

    document.body.style.overflow = 'visible'; // attiva lo scroll
}




/* RESIZE TEST */

var mqls = [
    window.matchMedia("(max-width: 767px)"),
    window.matchMedia("(min-width: 768px)")
   
]
 
function mediaqueryresponse(mql){
    if (mqls[0].matches){ // {max-width: 840px} query matched
       
    if ( document.querySelector('nav').style.display == 'block' ) { 
  
        navbarIsOpen = false;
     //   document.body.style.overflow = 'visible'; // attiva lo scroll
        //navbar.className = '';
        navbar.classList.remove('navbar__refresh-up'); // 
        document.querySelector('.toggleNav').classList.remove('open'); // 
        document.querySelector('nav').style.display = 'none'; // rende invisibile la lista dei link per la navigazione
    } 
      
    }
    if (mqls[1].matches) { // {max-width: 600px} query matched

    if ( document.querySelector('nav').style.display == 'none' ) { 
  
        document.querySelector('nav').style.display = 'block';  // rende visibile la lista dei link per la navigazione
        } else {
           // document.body.style.overflow = 'visible'; // attiva lo scroll
           
        }

        if (window.screenY > 0) {
            // navbar__refresh-down
        }
    }
} 
 
for (var i=0; i<mqls.length; i++){
    mediaqueryresponse(mqls[i]) // call listener function explicitly at run time
    mqls[i].addListener(mediaqueryresponse) // attach listener function to listen in on state changes
}
/* END RESIZE TEST */



/********** END RESIZE ********** END RESIZE ********** END RESIZE ********** END RESIZE ********** END RESIZE **********/









/********** SMOOTH SCROLL ON AUTOMATIC SCROLL **********/
window.smoothScroll = function(target) {
    var scrollContainer = target;
    do { //find scroll container
        scrollContainer = scrollContainer.parentNode;
        if (!scrollContainer) return;
        scrollContainer.scrollTop += 1;
    } while (scrollContainer.scrollTop == 0);
    
    var targetY = -60; // serve a settare la distanza dal contenuto che lo scroll deve raggiungere {-numero si ferma prima, 0 si ferma al confine, +numero si ferma dopo} 
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
/********** END SMOOTH SCROLL ON AUTOMATIC SCROLL **********/


export{navbarRefresh, navbarClick, navbarScroll, navbarResize}
/********** END CLICK **********/



