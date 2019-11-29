document.addEventListener('DOMContentLoaded', function() {
    //quando viene ricaricata la pagina viene visualizzata la parte più alta della pagina
    window.onbeforeunload = function () {
        window.scrollTo(0, 0);
    }

    console.log('window.location.pathname = ' + window.location.pathname);

    function downloadJSAtOnload () {
      const app = document.createElement('script');

        switch (window.location.pathname) {
        case '/' :
        case '/auth/signin' :
            app.setAttribute('type', 'module');
            app.setAttribute('src', '/js/desktop/auth/signin/app.js');
        break;
        case '/auth/signup' :
            app.setAttribute('type', 'module');
            app.setAttribute('src', '/js/desktop/auth/signup/app.js');
            break;
        case '/docs':
            app.setAttribute('type', 'module');
            app.setAttribute('src', '/js/desktop/docs/app.js');
            break;
        case '/home/contact':
            // app.setAttribute('type', 'module');
            // app.setAttribute('src', '/js/desktop/home.js');
            break;
        case '/post/create':
            // app.setAttribute('src', '/js/desktop/postcreate.js');
            break;
        default :
            //var mystr = window.location.pathname;
            //var myarr = mystr.split('/');
            //var myvar = myarr[0] + ":" + myarr[1];
            //console.log(myarr[0]);
            //console.log(myarr[1]);
            //console.log(myarr[2]);
            // element.setAttribute('src', '/js/desktop/blog.js');
        }
        document.body.appendChild(app);
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









