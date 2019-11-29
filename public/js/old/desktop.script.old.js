document.addEventListener('DOMContentLoaded', function() {

//quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
window.onbeforeunload = function () { 
  
    window.scrollTo(0, 0);
}

console.log('window.location.pathname');
console.log(window.location.pathname);



function downloadJSAtOnload () {

    let element = document.createElement ("script");


  

    switch (window.location.pathname) {
        
        case '/' : 
        case '/home/contact':
    
        element.setAttribute('type', 'module');   // element.src = " example.js" ;
        element.setAttribute('src', '/js/desktop/home.js');   // element.src = " example.js" ;
        break;

        case '/post/create':
         
            element.setAttribute('src', '/js/desktop.postcreate.js'); 
        break;

    
        default : 

            //var mystr = window.location.pathname;
            //var myarr = mystr.split('/');
            //var myvar = myarr[0] + ":" + myarr[1];
            //console.log(myarr[0]);
            //console.log(myarr[1]);
            //console.log(myarr[2]);
    
        element.setAttribute('src', '/js/desktop.blog.js');   
    }

    document.body.appendChild (element); 
}




if (window.addEventListener) {
    console.log('LOAD');
window.addEventListener ("load", downloadJSAtOnload, false);
}
else if (window.attachEvent) {
    console.log('ONLOAD');
window.attachEvent ("onload", downloadJSAtOnload);
}
else { 
    console.log('ELSE');
window.onload = downloadJSAtOnload;
}






/********** RESIZE ********** RESIZE ********** RESIZE ********** RESIZE ********** RESIZE **********/
window.addEventListener('resize', Resizing, false); 

let risoluzione = document.querySelector('#risoluzione');

let resizeTimer;

function Resizing(e) {

  clearTimeout(resizeTimer);
  resizeTimer = setTimeout(function() {

    risoluzione.style.display = 'none';
            
  }, 3000);

  risoluzione.style.display = 'block';
  risoluzione.innerHTML = window.innerWidth;

  
if ( window.innerWidth >= 260 && window.innerWidth < 320 ) {

    risoluzione.style.backgroundColor = "pink";
}
else if ( window.innerWidth >= 320 && window.innerWidth < 576 ) { 

    risoluzione.style.backgroundColor = "blue";
}
else if ( window.innerWidth >= 576 && window.innerWidth < 768 ) {

    if ( document.querySelector('nav').style.display == 'block' ) { 

        navbarIsOpen = false;
        document.body.style.overflow = 'visible'; // attiva lo scroll
        document.querySelector('.toggleNav').classList.remove('open');
        document.querySelector('nav').style.display = 'none';
    } 
    risoluzione.style.backgroundColor = "green";
}
else if ( window.innerWidth >= 768 && window.innerWidth < 992 ) {

    if ( document.querySelector('nav').style.display == 'none' ) { 

    document.querySelector('nav').style.display = 'block';
    } 
    risoluzione.style.backgroundColor = "violet";
}
else if ( window.innerWidth >= 992 && window.innerWidth < 1200 ) {

    risoluzione.style.backgroundColor = "orange";
} 
else if ( window.innerWidth >= 1200 ) {

    risoluzione.style.backgroundColor = "yellow";
}

}
/********** END RESIZE ********** END RESIZE ********** END RESIZE ********** END RESIZE ********** END RESIZE **********/







}); // chiude DOMContentLoaded
     








