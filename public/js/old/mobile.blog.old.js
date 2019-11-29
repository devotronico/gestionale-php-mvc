console.log('BLOG mobile script');

/********** NAVBAR SENZA BOOTSTRAP **********/
document.addEventListener('touchstart', clickFunc,  {passive: false}); // mouseenter
    
let navbarIsOpen = false;
    
function clickFunc(e){ 
    //console.log('CLICK');
    let element = e.target;
    //console.log( element.classList.item(0));
    switch ( element.classList.item(0) ) {

        case 'toggleNav':   //se è stato cliccato il bottone del menu della navbar
            // alert('toggleNav'); 
            let nav = document.querySelector('nav');

            element.classList.toggle('active'); // aggiunge la classe .active al bottone del menu
            if ( navbarIsOpen === false) { // se navbarIsOpen è su false diventa true
                // console.log('DISATTIVA LO SCROLL');
                document.body.style.overflow = 'hidden'; 
                nav.style.display = 'block'; // mostra la lista dei link per la navigazione
                //   navbarIsOpen = true;
            } else {    // se navbarIsOpen è su true diventa false
                //  console.log('ATTIVA LO SCROLL');
                document.body.style.overflow = 'visible'; 
                nav.style.display = 'none'; // nasconde la lista dei link per la navigazione
            }
            navbarIsOpen = !navbarIsOpen; // cambia lo stato da false a true e viceversa
        break; 


        case 'liPageLink' : // se non clicchiamo sul tag <a> ma sul elemento genitore <li> 

            window.location.href = element.firstElementChild.href;
   
        break;  

        case 'aPageLink' : // se clicchiamo direttamente sul tag <a>

        break; 


        case 'scrollFA' :

        document.documentElement.scrollTop=0;

        //console.log(document.documentElement.scrollTop);
        break;

        case 'message' : // chiude i messagi di errore
        case 'message-close' :
            document.querySelector('.message').style.display = 'none';
        break;


        default :
        
        if (navbarIsOpen) {  // se la navbar è aperta
            e.preventDefault();
        }

        if (e.defaultPrevented) {
          //  console.log('defaultPrevented TRUE')
        } else {
          //  console.log('defaultPrevented FALSE')
        }

    }

}

/********** END NAVBAR SENZA BOOTSTRAP **********/
    