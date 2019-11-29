
let offset = 0; 
let scrollButton = document.querySelector('.scroll__button');


/**
 * REFRESH EVENT
 * Applica effetti come cambio il cambio di opacità e movimento al bottone dello scroll
 * Se lo scroll della pagina si trova in basso allora appare il bottone dello scroll ( aumenta l' opacità )
 * Se lo scroll della pagina si trova in cima allora NON appare il bottone dello scroll
 */
function scrollButtonRefresh(){
   
    if ( window.scrollY > offset ) { // se lo scroll NON è in cima(TOP) ma si trova più in basso

        scrollButton.classList.add('scroll__move-down');   // fa apparire il bottone dello scroll
    }  
}




/**
 * SCROLL EVENT
 * Applica effetti come cambio il cambio di opacità e movimento al bottone dello scroll
 * Se si scrolla la pagina in basso appare il bottone dello scroll ( aumenta l' opacità )
 * Se si scrolla la pagina fino in cima scompare il bottone dello scroll ( diminuisce l' opacità )
 */
function scrollButtonScrolling() {

    if ( window.scrollY > offset ) { // se lo scroll NON è in cima(TOP) ma si trova più in basso

        if (!scrollButton.classList.contains('scroll__move-down')) {
        
            scrollButton.classList.remove('scroll__move-up');
            scrollButton.classList.add('scroll__move-down');
        }
    
    } else { // se lo scroll è in cima(TOP) alla pagina
    
        if (scrollButton.classList.contains('scroll__move-down')) {
        
            scrollButton.classList.replace('scroll__move-down','scroll__move-up');
        }
    }
}







/**
 * CLICK EVENT
 * Applica effetti come cambio il cambio di opacità e movimento al bottone dello scroll
 * Se si clicca sul bottone dello scroll ('.scroll__button') 
 * oppure si clicca sulla sua icona ('.scroll__icon')
 * la pagina scrolla in automatico fino in cima
 */
function scrollButtonClick(e){ 

    switch ( e.target.classList.item(0) ) { // controlliamo il nome della prima classe dell' elemento

        case 'scroll__button' :
        case 'scroll__icon' :
            window.scrollTo({top: 0,behavior: "smooth"});
        break;
    }
}











export { scrollButtonRefresh, scrollButtonClick, scrollButtonScrolling }



