    

document.addEventListener('DOMContentLoaded', function() {

    //quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
    window.onbeforeunload = function () { 
     // window.scrollTo({top: 0,behavior: "smooth"});
       // window.scrollTo(0, 0);
    }

     setTimeout (function () {
      window.scrollTo(0,0);
      }, 500); //100ms for example
    
    console.log('window.location.pathname:'+window.location.pathname);
    
    

    function downloadJSAtOnload () {

      let element = document.createElement ("script");
  
    switch (window.location.pathname) {
          
        case '/' : 
        case '/home/contact':

        element.setAttribute('src', '/js/mobile.home.js');   
        break;

        case '/post/create':

        element.setAttribute('src', '/js/desktop.postcreate.js'); 
        break;

        default : 

        element.setAttribute('src', '/js/mobile.blog.js');    
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


    
}); // chiude DOMContentLoaded





