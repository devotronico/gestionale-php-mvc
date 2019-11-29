
//let offset = 0; 
let navbar = document.querySelector('header');

/*
* AL REFRESH APPLICA EFFETTI ALLA NAVBAR
* Alla navbar aumenta l' opacità(no trasparenza) quando è verso il fondo della pagina
*/
/*
function navbarRefresh(){
   
    console.log('REFRESH');
    // console.log('document.body.scrollTop: '+document.body.scrollTop);
    // console.log('document.documentElement.scrollTop: '+document.documentElement.scrollTop);
    // console.log('window.pageYOffset: '+window.pageYOffset);
    // console.log('window.scrollY: '+window.scrollY);
    if ( window.innerWidth >= 768 ) {
        if ( window.scrollY > offset ) { // se lo scroll NON è in cima(TOP) ma si trova più in basso

            navbar.classList.add('navbar__refresh-down'); // aggiunge una classe senza animazione 
            console.log('+ REFRESH DOWN');
    
        } 
        else 
        {
            navbar.classList.add('navbar__refresh-up'); // aggiunge una classe senza animazione 
            console.log('+ REFRESH UP');
        }
    }
    else {
        console.log('- REFRESH');
    }
}
*/


// navbar__refresh-up
/*
* AL SCROLL APPLICA EFFETTI ALLA NAVBAR
* Alla navbar diminuisce l' opacità quando è in cima della pagina
* Alla navbar aumenta l' opacità quando è verso il fondo della pagina
*/
/*
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
*/



let navbarIsOpen = false; 

function navbarToggleNav(e) { 
      
    if ( e.target.classList.item(0) === 'toggleNav' ) {
        console.log('toggleNav');
        e.target.classList.toggle('open');
        if ( navbarIsOpen === false) { // se navbarIsOpen è su false diventa true
          
            document.body.style.overflow = 'hidden'; // disattiva lo scroll
            document.querySelector('nav').style.display = 'block'; // mostra la lista dei link per la navigazione

        } else {    
          
              document.body.style.overflow = 'visible'; // attiva lo scroll
              document.querySelector('nav').style.display = 'none'; // nasconde la lista dei link per la navigazione
        }
        navbarIsOpen = !navbarIsOpen; // cambia lo stato da false a true e viceversa
    }
    return navbarIsOpen; 
}




/******************** CLICK ********************/
function navbarTouch(e){ 

    if ( !navbarToggleNav(e) ) {

        return false;
    }

    console.log('aperto');
    let element = e.target;

    switch ( element.classList.item(0) ) { // controlliamo il nome della prima classe dell' elemento


        case 'nav__item' : //se è stato cliccato il tag <li> del menu della navbar
        case 'nav__link' : //se è stato cliccato il tag <a> del menu della navbar

        setTimeout(function(){ 
            navbarIsOpen = false; 
            document.querySelector('.toggleNav').classList.remove('open');
            document.querySelector('nav').style.display = 'none'; // chiude la nav che contiene la lista dei link
            document.body.style.overflow = 'visible'; // attiva lo scroll
        }, 250);

        break;

        case 'nav__item-page' : //se dal menu della navbar è stato cliccato il tag <li> del link per il blog 
        case 'nav__link-page' :  //se dal menu della navbar è stato cliccato il tag <a> del link per il blog 
            window.location.href = '/blog';
        break; 

        case 'cover__btn': // se è stato cliccato il tag <a> del bottone sulla Cover
    
        break;
        
    // case 'scroll__button' :
    // case 'scroll__icon' :
    // e.preventDefault();
    // e.stopPropagation();
    // window.scrollTo({top: 0,behavior: "smooth"});
    // //window.scrollTo(0, 0);
    // //document.documentElement.scrollTop=0;

    // //console.log(document.documentElement.scrollTop);
    // break;
}

}








export { navbarTouch }




