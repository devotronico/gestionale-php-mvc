function footer(data, div) {

    
 // FONTAWESOME --> https://fontawesome.com/how-to-use/on-the-web/setup/getting-started?using=web-fonts-with-css
let fontawesome = document.querySelector('.fontawesome');
//console.log(fontawesome);
if ( fontawesome == null ) { // se il link fontawesome non è stato ancora creato...
     
  let head = document.querySelector('head'); // il link deve essere inserito nel tag head del documento html
  let fontawesome = document.createElement('link');
  fontawesome.classList.add('fontawesome');   
  fontawesome.setAttribute('rel', 'stylesheet');   
  fontawesome.setAttribute('href', 'https://use.fontawesome.com/releases/v5.4.1/css/all.css');   // fontawesome.setAttribute('href', '/img/fontawesome/css/fontawesome-all.min.css');    
  fontawesome.setAttribute('integrity', 'sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz');   
  fontawesome.setAttribute('crossorigin', 'anonymous');   
  head.appendChild(fontawesome);
  //console.log(fontawesome);
}
// END FONTAWESOME
    

    div.id = "footer-box"; // aggiunge 'id' al contenitore senza canvas
    // FOOTER CONTENT (contiene il gli elementi del footer)
    let footerContent = document.createElement('div'); 
    footerContent.id = 'footer-content';
    footerContent.classList.add("content"); // aggiunge la classe 'content'
    div.appendChild(footerContent); // appende il contenitore del CONTENUTO

    // FOOTER TITOLO
    let footerTitle = document.createElement("div"); // crea contenitore del titolo
    footerTitle.id = "footer-title"; // aggiunge 'id' al contenitore del titolo
    footerTitle.classList.add("section-title"); // aggiunge 'id' al contenitore del titolo
    // footerTitle.innerHTML = "<p id='footer-copyright'>&copy;&nbsp;Daniele</span></p>"; // aggiunge il testo al contenitore del titolo
    footerTitle.innerHTML = "<p id='footer-copyright'>&copy;&nbsp;Daniele Manzi <span id='footer-year'>2018</span></p>"; // aggiunge il testo al contenitore del titolo
    
    div.appendChild(footerTitle); // appende il contenitore del TITOLO
    
    
    for (let i=0; i<data.length; i++) {
        let element = document.createElement('a'); // CREA TAG INPUT PER OGNI ELEMENTO DEL FORM
        element.classList.add('footer-icon');
        element.setAttribute('href', 'https://'+data[i].socialAddress);
        element.setAttribute('target', '_blank');
        element.innerHTML = data[i].icon; 
        footerContent.appendChild(element); 
    }
}
export {footer}




/*


  <div id="footer-box-copyright">
    <div id="footer__box__canvas"></div>
        <!-- <p id="footer-copyright">&copy;&nbsp;Daniele Manzi 2018</p> -->
    </div>

    
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

         
          
          
      
*/

