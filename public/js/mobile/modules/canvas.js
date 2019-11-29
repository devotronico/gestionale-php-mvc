//======================================================================
// CANVAS [cerchio che cade e rimbalza]
//======================================================================
// let sectionName = ['portfolio', 'project', 'skill', 'contact', 'about', 'footer'];

let canvasList = {
    portfolio: undefined,
    project: undefined,
    skill: undefined,
    contact: undefined,
    about: undefined,
    footer: undefined,
};

let ctx = {
    portfolio: undefined,
    project: undefined,
    skill: undefined,
    contact: undefined,
    about: undefined,
    footer: undefined,
};

let ball = {
    portfolio: undefined,
    project: undefined,
    skill: undefined,
    contact: undefined,
    about: undefined,
    footer: undefined,
};


// CREA CANVAS E BALL----------------------------------------------------------------------

function initCanvas(section, canvasBox, bgcolor, ballColor) {
 
    let canvas = document.createElement("canvas");
    
    canvas.width = canvasBox.clientWidth 
    canvas.height = canvasBox.clientHeight; 
    canvas.style.backgroundColor = bgcolor;
    canvasBox.appendChild(canvas);
    
    if ( window.innerWidth < 320 ) { canvas.style.display = 'none';}
    canvasList[section] = canvas;
    ctx[section] = canvas.getContext("2d");  

    let y = 0; 
    let radius = 60;
    ball[section] = new Circle(canvasList[section].width*.5, y, radius, section, canvasList[section].height, ballColor);
}


/*
* Durante il resize della pagina
* Aggiorna le dimensioni del canvas rispetto al suo contenitore
* Aggiorna la posizione della palla rispetto alle nuove dimensioni del canvas
* Nasconde il canvas se la pagina è minore di 320 pixel altrimenti lo mostra
*/
let resizeTimer;

function canvasResize(){
    
    animate(false); 
   
    // clearTimeout resetta setTimeout quindi evita che viene richiamato più volte ma soltato una volta alla fine del riseze
    clearTimeout(resizeTimer);
    resizeTimer = setTimeout(function() {
        animate(false); 
        animate(true);
    }, 1000);

  

// CICLARE UN OGGETTO
Object.objsize = function(canvasList) {
    let size = 0, key;
    for (key in canvasList) {
        if (canvasList.hasOwnProperty(key)) {


            if (canvasList[key] != undefined ) {  
          
               // console.log('OK');
                canvasList[key].width = document.querySelector(".col-canvas-"+key).clientWidth;
                canvasList[key].height = document.querySelector(".col-canvas-"+key).clientHeight;

                ball[key].x = canvasList[key].width *.5; // la palla si riposiziona al centro del canvas
                ball[key].floor = canvasList[key].height; // la palla si riposiziona al centro del canvas

                if ( window.innerWidth < 320 ) {
                    canvasList[key].style.display = 'none';
                } else { 
                    canvasList[key].style.display = 'block';
                }

            } //else {  console.log('ERRORE');  }
         
        size++;
        }
    }
    return size;
};

Object.objsize(canvasList);
// var objsize = Object.objsize(canvasList);
//console.log('lunghezza del oggetto : '+canvasList);
}



// OGGETTO  ----------------------------------------------------------------------
function Circle(x, y, radius, i, floor, ballColor) {

    this.x = x;
    this.y = y;
    this.radius = radius;
    this.color = ballColor;
    this.vspd = 0;
    this.gravity = 1;
    this.floor = floor

  this.draw = function() {
    
    ctx[i].beginPath();
    ctx[i].arc(this.x, this.y, this.radius, 0, Math.PI * 2, false);
    ctx[i].fillStyle = this.color;
    ctx[i].fill(); // riempimento
    ctx[i].closePath();
  }

    this.update = function() {
 
        this.vspd += this.gravity;
        if ( this.y+this.radius >= this.floor ) { this.vspd = -30; }
        this.y += this.vspd;
        this.draw();
    }

} // chiude Classe Circle




let n;
function indexOfBall(index) {console.log(index); return n = index}


// ANIMAZIONE ----------------------------------------------------------------------
let animState;
function animate(play) {
  
    if ( play ) {
        if ( ctx[n] != undefined ) {
            animState = requestAnimationFrame(animate);
            ctx[n].clearRect(0, 0, canvasList[n].width, canvasList[n].height); // clear canvas
            ball[n].update();
        }
    } 
     else {
       // console.log('NOT PLAY');
        cancelAnimationFrame(animState);
     }
}
export {initCanvas, canvasResize, indexOfBall, animate}
//======================================================================
// CHIUDE CANVAS
//======================================================================