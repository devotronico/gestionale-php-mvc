console.log('BLOG desktop script');

/********** CLICK ********** CLICK ********** CLICK ********** CLICK ********** CLICK **********/
document.addEventListener('click', clickFunc,  {passive: false}); // mouseenter
    
let navbarIsOpen = false;
    
function clickFunc(e){ 
 
    let element = e.target;
    console.log( element);
    switch ( element.classList.item(0) ) {

        case 'toggleNav':   //se è stato cliccato il bottone del menu della navbar
         
            let nav = document.querySelector('nav');

            element.classList.toggle('open'); // aggiunge la classe .open al bottone del menu
            if ( navbarIsOpen === false) { // se navbarIsOpen è su false diventa true
              
                document.body.style.overflow = 'hidden'; // disattiva lo scroll della pagina
                nav.style.display = 'block'; // mostra la lista dei link per la navigazione
                //   navbarIsOpen = true;
            } else {    // se navbarIsOpen è su true diventa false
                //  console.log('ATTIVA LO SCROLL');
                document.body.style.overflow = 'visible'; // attiva lo scroll della pagina
                nav.style.display = 'none'; // nasconde la lista dei link per la navigazione
            }
            navbarIsOpen = !navbarIsOpen; // cambia lo stato da false a true e viceversa
        break; 


        case 'liPageLink' : // se non clicchiamo sul tag <a> ma sul elemento genitore <li> 

            window.location.href = element.firstElementChild.href;
   
        break;  

        case 'aPageLink' : // se clicchiamo direttamente sul tag <a>

        break; 


        case 'btn-scroll' :
        e.preventDefault();
        window.scrollTo({top: 0,behavior: "smooth"});
        
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

/********** END CLICK ********** END CLICK ********** END CLICK ********** END CLICK ********** END CLICK **********/





/**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********SCROLL**********/


document.addEventListener('scroll', Scrolling, false);



// variabili per lo scroll button
let offset = 0;
let scrollBtn = document.querySelector('.btn-scroll');

function Scrolling(e) {


/**********SCROLL NAVBAR AND BUTTON ANIMATION*********/

  if ( window.scrollY > offset ) {


    if (!scrollBtn.classList.contains('scrollDown')) {

      scrollBtn.classList.remove('scrollTop');
      scrollBtn.classList.add('scrollDown');
    }

  } else {

    if (scrollBtn.classList.contains('scrollDown')) {

      scrollBtn.classList.replace('scrollDown','scrollTop');
    }
  }
/*********END*SCROLL NAVBAR *********/

}