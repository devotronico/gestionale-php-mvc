
console.log('HOME script');
/********** SMOOTH SCROLL ON AUTOMATIC SCROLL **********/
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
    

/********** CLICK **********/
document.addEventListener('touchstart', clickFunc, {passive: false}); // mouseenter
    
let navbarIsOpen = false;
    
function clickFunc(e){ 

    let element = e.target;
  

    switch ( element.classList.item(0) ) { // controlliamo il nome della prima classe dell' elemento

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

            smoothScroll(document.getElementById(goToId))

            document.querySelector('nav').style.display = 'none';
            document.querySelector('.toggleNav').classList.toggle('active'); // 
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

            document.querySelector('nav').style.display = 'none';
            document.querySelector('.toggleNav').classList.toggle('active'); 
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

/********** END CLICK **********/
    

    
    /**********SCROLL LOADING*********/
    
    document.addEventListener('scroll', scrollLoad, false);

    let dist = 1;
    let altezza = document.querySelector('#portfolio').offsetTop - window.innerHeight * dist;
    state = ['init', 'portfolio', 'skill', 'contact', 'footer', 'end'];
    let index = 0;
    
    let offset = 150;
    let scrollBtn = document.querySelector('#btn-scroll');

    function scrollLoad(e){

        //  console.log('altezza pagina '+document.body.scrollHeight);
        //  console.log('altezza '+altezza);
        //  console.log('altezza scroll '+window.scrollY);

        /********** SCROLL BUTTON ********** SCROLL BUTTON **********/
        if ( window.scrollY >  offset ) {
           
            if (!scrollBtn.classList.contains('scrollDown')) {
                console.log('APPARE');
                scrollBtn.classList.remove('scrollTop');
                scrollBtn.classList.add('scrollDown');
            }
        } else {

            if (scrollBtn.classList.contains('scrollDown')) {
                console.log('SCOMPARE');
                scrollBtn.classList.replace('scrollDown','scrollTop');
            }
        }
        /********** END SCROLL BUTTON ********** END SCROLL BUTTON **********/


      if ( window.scrollY > altezza ) {
        
        index++;
    
        switch( state[index] ) {
    
          case 'portfolio': //APRE PORTFOLIO ------------------------------------------------------
            console.log('portfolio loading'); 

            let head = document.querySelector('head');

            // <link href="img/fontawesome/css/fontawesome-all.min.css" rel="stylesheet">          
            let fontawesome = document.createElement('link');
            fontawesome.setAttribute('href', 'img/fontawesome/css/fontawesome-all.min.css');  
            fontawesome.setAttribute('rel', 'stylesheet');   
            head.appendChild(fontawesome);
    
            // <link rel="stylesheet" href="https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css">
            let devicon = document.createElement('link');
            devicon.setAttribute('rel', 'stylesheet');   
            devicon.setAttribute('href', 'https://cdn.rawgit.com/konpa/devicon/df6431e323547add1b4cf45992913f15286456d3/devicon.min.css');
            head.appendChild(devicon);
    
            // src="/js/jquery.js"
            let scriptJQ = document.createElement('script');
            scriptJQ.setAttribute('src', '/js/jquery.js');   
            let body = document.querySelector('body');
            body.appendChild(scriptJQ);
    
    
            let titleList = ['Meteo', 'Network', 'Blog', 'Android Game', 'Wordpress', 'Angular', 'Cryptovalute', 'Database'];
            let faIcon = ['s fa-sun', 'b fa-connectdevelop', 'b fa-blogger-b', 'b fa-android', 'b fa-wordpress', 'b fa-angular', 'b fa-bitcoin', 's fa-database'];
            let arr_portfolioText =  ['Previsioni del meteo', 'Prototipo di un social', 'Un videogame 8bit', 'App per smartphone', 'Wordpress e WooCommerce', 'Vari script personali', 'Bitcoin, Ethereum, Dash,', 'Database con funzioni'];
            let address =  ['github.com/redeluni/meteo', 'github.com/redeluni/socialnetwork', 'github.com/redeluni/blog', '', 'github.com/redeluni/wp-site', 'stackblitz.com/@redeluni', 'github.com/redeluni/cryptocoin', 'github.com/redeluni/database'];
            
            let portfolio = document.querySelector('#portfolio');
            portfolio.classList.add('visibileBlue');

            let portfolioBoxTitle = document.createElement('div'); 
            portfolioBoxTitle.id = 'portfolio-title';
            let portfolioTitle = document.createElement('p'); 
            portfolioTitle.innerHTML = 'Projects';
            portfolioBoxTitle.appendChild(portfolioTitle); 
            portfolio.appendChild(portfolioBoxTitle); 

            let portfolioContainer = document.createElement('div'); 
            portfolioContainer.id = "portfolio-container";

            portfolio.appendChild(portfolioContainer); 

            for (let i=0; i<faIcon.length;  i++) {  
    
                let portfolioBox = document.createElement('div');
                portfolioBox.classList.add('portfolio-box');  
                
                let portfolioHead = document.createElement('div');
                portfolioHead.classList.add('portfolio-head');  
                portfolioHead.innerHTML = titleList[i];

                //let portfolioIcon = document.createElement('div');
                //portfolioIcon.classList.add('portfolio-icon');  
                //portfolioIcon.innerHTML = '<i class="fa'+faIcon[i]+'"></i>';

                let portfolioIcon = document.createElement('a');  
                portfolioIcon.classList.add('portfolio-icon');
                // portfolioIcon.href = 'https://github.com/redeluni/'+address[i];  
                portfolioIcon.href = 'https://'+address[i];  
                portfolioIcon.setAttribute('target', '_blank');
                portfolioIcon.innerHTML = '<i class="fa'+faIcon[i]+'"></i>';
                
                
                let portfolioText = document.createElement('p'); 
                portfolioText.classList.add('portfolio-text');
                // let arr_portfolioText =  ['meteo', 'socialnetwork', 'blog', '', 'wp-site', 'note', 'cryptocoin', 'database'];
                portfolioText.innerHTML = arr_portfolioText[i];
                
                    
                let portfolioBtn = document.createElement('a');  
                portfolioBtn.classList.add('portfolio-btn');
                portfolioBtn.href = 'https://github.com/redeluni/'+address[i];   
                portfolioBtn.setAttribute('target', '_blank');
                portfolioBtn.innerHTML = 'visita';
                
                portfolioBox.appendChild(portfolioHead); 
                portfolioBox.appendChild(portfolioIcon); 
                portfolioBox.appendChild(portfolioText); 
                portfolioBox.appendChild(portfolioBtn); 
                portfolioContainer.appendChild(portfolioBox); 
            }
            altezza = document.querySelector('#skill').offsetTop - window.innerHeight * dist;
            console.log('portfolio completato'); 
          break;  //CHIUDE PORTFOLIO
    
    
          case 'skill':  //APRE SKILLS ------------------------------------------------------
          console.log('skill loading'); 
          let skill = ['html5', 'css3', 'javascript', 'jquery', 'php', 'mysql', 'bootstrap', 'git', 'github', 'photoshop', 'inkscape', 'wordpress'];
  
          let skillContainer = document.querySelector('#skill');
          skillContainer.classList.add('visibileWhite');

          let skillTitleBox = document.createElement('div'); 
          skillTitleBox.id = "skill-title";
          let skillTitle = document.createElement('p'); 
          skillTitle.innerHTML = 'Skills';
          skillTitleBox.appendChild(skillTitle);
          skillContainer.appendChild(skillTitleBox);

        //   let skillBox = document.createElement('div');                      
        //   skillBox.id = "skill-box";     
          
          let skillBoxIcon = document.createElement('div');                      
          skillBoxIcon.id = "skill-box-icon";   

        //   skillBox.appendChild(skillBoxIcon);

/*
        let skillBoxBg = document.createElement('div');    
        skillBoxBg.id ="skill-box-bg";
       
        skillBox.appendChild(skillBoxBg);
         */

          skillContainer.appendChild(skillBoxIcon);


          for (let i=0; i<skill.length; i++) {
    
            let devIcon = document.createElement('div');
            devIcon.classList.add('dev-icon');
            devIcon.innerHTML = '<i class="devicon-'+skill[i]+'-plain colored"></i>'; 
            // devIcon.innerHTML = 'item'; 
          
    
            skillBoxIcon.appendChild(devIcon); 
        }

       /*
        let skillBg = document.createElement('div');             
        skillBg.id = "skill-bg"; 
        skillBoxBg.appendChild(skillBg);
        */
        
        altezza = document.querySelector('#contact').offsetTop - window.innerHeight * dist;

   
          console.log('skills completato'); 
          break;  //CHIUDE SKILLS
    
    
          case 'contact': //APRE CONTACT ------------------------------------------------------
            console.log('contact loading'); 
    
            let campi = ['nome', 'cognome', 'tel', 'email', 'descrivi il lavoro', 'invia'];
            let tipo = ['text', 'text', 'tel', 'email', '', 'submit'];
            let textLen = [32, 32, 16, 32, 64];
    
            let contact = document.querySelector('#contact'); // <div class="form-group">
            contact.classList.add('visibileGray');

            let contactBoxTitle = document.createElement('div'); 
            contactBoxTitle.id = 'contact-title';
            let contactTitle = document.createElement('p'); 
            contactTitle.innerHTML = 'Contact';
            contactBoxTitle.appendChild(contactTitle); 
            contact.appendChild(contactBoxTitle); 

            let contactForm = document.createElement('form'); 
            contactForm.id = 'contact-form';
            contactForm.setAttribute('method', 'post');   
            contactForm.setAttribute('action', '/home/contact'); 
            contact.appendChild(contactForm);
                
            for (let i=0; i<campi.length; i++) {
            
                if ( i < 4) { // campi.length-1
                    let label = document.createElement('label');
                    label.setAttribute('for', campi[i]);
                    label.innerHTML = campi[i];
        
                    contactForm.appendChild(label); 
        
                    let input = document.createElement('input');
                    input.setAttribute('type', tipo[i] );  //   
                    input.setAttribute('name', campi[i]);    
                    input.setAttribute('placeholder', campi[i]); 
                    input.setAttribute('maxlength', textLen[i]); 
                    
                    contactForm.appendChild(input); 
                } else if ( i==4) { 

                let label = document.createElement('label');
                label.setAttribute('for', campi[i]);
                label.innerHTML = campi[i];
                contactForm.appendChild(label); 

                let textarea = document.createElement('textarea');
                textarea.setAttribute('rows', '3');  
                textarea.setAttribute('cols', '50');  
                textarea.setAttribute('name', 'testo');    
                textarea.setAttribute('placeholder', campi[i]); 
                textarea.setAttribute('maxlength', textLen[i]);
              
                contactForm.appendChild(textarea); 

                } else if ( i==5) {

                    let button = document.createElement('input');
                    button.setAttribute('type', tipo[i]);  
                   // button.setAttribute('name', tipo[i]);  
                    button.setAttribute('id', 'contact-btn');    
                    button.setAttribute('value', campi[i]); 
                    contactForm.appendChild(button); 

                }
            }
              altezza = document.querySelector('#footer').offsetTop - window.innerHeight * dist;
              console.log('contact completato');
          break; // CHIUDE CONTACT 
    
     
          case 'footer':   //APRE FOOTER ------------------------------------------------------
            console.log('footer loading');
    
            let siteAddress = ['github.com/redeluni', 'twitter.com/JQALP', 'www.linkedin.com/in/daniele-manzi-b57529110/', 'www.facebook.com/daniele.manzi.83'];  
            let siteIcon = ['github', 'twitter', 'linkedin', 'facebook']; 

            let footer = document.querySelector('footer');
            footer.classList.add('visibileBlue');    

            let footerBoxIcon = document.createElement('div'); 
            footerBoxIcon.id = 'footer-box-icon';    

            let footerBoxCopyright = document.createElement('div'); 
            footerBoxCopyright.id = 'footer-box-copyright';  

            let footerCopyright = document.createElement('p');
            footerCopyright.id = 'footer-copyright';  
            footerCopyright.innerHTML = '&copy;&nbsp;Daniele&nbsp;Manzi&nbsp;2018';

            footerBoxCopyright.appendChild(footerCopyright);

            footer.appendChild(footerBoxIcon);
            footer.appendChild(footerBoxCopyright);

            for (let i=0; i<siteIcon.length;  i++) {  
    
                let footerIcon = document.createElement('a');
                footerIcon.classList.add('footer-icon');
                footerIcon.href = 'https://'+siteAddress[i];   
                footerIcon.setAttribute('target', '_blank');
                footerIcon.innerHTML = '<i class="fab fa-'+siteIcon[i]+'"></i>'; 
                footerBoxIcon.appendChild(footerIcon); 
              }

            altezza = document.body.scrollHeight; // altezza Totale della pagina
           // document.removeEventListener('scroll', scrollLoad);
            console.log('footer completato');
          break; //CHIUDE FOOTER
        }
      } else { 
          //console.log('fine pagina');
         }
    }


    
    
    
    