//==VARIABILI PER IL DEBUG/TEST==    
let lineScrollBot = document.querySelector(".debug__line-scroll-bot");
let listOffSetUp = document.querySelector(".debug__line-scroll-up");
let containerOffsetTop = document.querySelectorAll(".debug__wrapper-offsetTop");
//==END VARIABILI PER IL DEBUG/TEST==      

//=====DEBUG/TEST=====
function debug(listOffSetTop, heightTrigger, num=0){
    
    containerOffsetTop[num].innerHTML = '<span class="debug__black">offsetTop: '+listOffSetTop[num]+'</span>'; // DEBUG/TEST
    listOffSetUp.style.top = listOffSetTop[num-1] + heightTrigger+'px';  // DEBUG/TEST
    listOffSetUp.innerHTML = '<span class="debug__blue">offsetTop: '+ listOffSetTop[num] + '  scrolla in BASSO attiva il prossimo canvas a ' + (listOffSetTop[num] - heightTrigger) + '</span>'  // DEBUG/TEST
    lineScrollBot.style.top = listOffSetTop[num] - heightTrigger+'px';
    lineScrollBot.innerHTML = '<span class="debug__red">offsetTop: '+ listOffSetTop[num] + '  scrolla in ALTO attiva il prossimo canvas a ' + (listOffSetTop[num] - heightTrigger) + '</span>'   // DEBUG/TEST
}
//=====END DEBUG/TEST=====   

export {debug}