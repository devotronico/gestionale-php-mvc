import { addEventToButton } from "../app.js";
import { removeAlerts, activateButton } from "./handlerCommon.js";

function singleErrorTest(obj) { console.log('OK-1');
    removeAlerts();
    activateButton('signin');

    const alert = document.querySelector(`.alert-${obj.body.dom}`);
    if ( alert === null ) { return; } // [!]
    alert.hidden = false;
    alert.innerHTML = obj.body.message;
}


function singleError(obj) {
    removeAlerts();
    activateButton('signin');
    const alert = document.querySelector(`.alert-${obj.body.dom}`);
    if ( alert === null ) { return; } // [!]
    alert.hidden = false;
    alert.innerHTML = obj.body.message;
}


function multiError(obj) {
    removeAlerts();
    activateButton('signin');

    for (let i = 0; i < obj.body.length; i++) {
        const alert = document.querySelector(`.alert-${obj.body[i].dom}`);
        alert.hidden = false;
        alert.innerHTML = obj.body[i].message;
    }
}


// const errorTemplate = (obj) => {
//     const body = document.querySelector('BODY');
//     const wrapper = document.createElement('DIV');
//     wrapper.classList.add('error__wrapper');
//     body.appendChild(wrapper);

//     const table = document.createElement('TABLE');
//     table.classList.add('error__table');
//     wrapper.appendChild(table);

//     // <THEAD>
//     const thead = document.createElement('THEAD');
//     thead.classList.add('error__thead');
//     table.appendChild(thead);

//     const tr = document.createElement('TR');
//     tr.classList.add('error__tr');
//     thead.appendChild(tr);

//     const th = document.createElement('TH');
//     th.classList.add('error__th');
//     th.setAttribute('colspan', 2);
//     thead.appendChild(th);

//     const close = document.createElement('A');
//     close.id = 'error__close';
//     close.classList.add('btn', 'btn-close');
//     close.setAttribute('href', '#');
//     close.innerHTML = '&times;';
//     th.appendChild(close);
//     // </THEAD>

//     const tbody = document.createElement('TBODY');
//     tbody.classList.add('error__tbody');
//     table.appendChild(tbody);

//     for (const item in obj) {
//       console.log(item);
//       const tr = document.createElement('TR');
//       tr.classList.add('error__tr');
//       tbody.appendChild(tr);

//       const th = document.createElement('TH');
//       th.classList.add('error__th');
//       th.setAttribute('colspan', 2);
//       th.innerText = item;
//       tr.appendChild(th);

//         for (const key in obj[item]) {
//         console.log(key);
//         const tr = document.createElement('TR');
//         tr.classList.add('error__tr');
//         tbody.appendChild(tr);

//         const th = document.createElement('TH');
//         // th.setAttribute('colspan', '2');
//         th.classList.add('error__th');

//         th.innerText = key;
//         tr.appendChild(th);

//         const td = document.createElement('TD');
//         td.classList.add('error__td');
//         td.innerText = obj[item][key];
//         tr.appendChild(td);
//         }
//     }
//     addEventToButton();
// }




const errorTemplate = (obj) => {
    const body = document.querySelector('BODY');
    const wrapper = document.createElement('DIV');
    wrapper.classList.add('error__wrapper');
    body.appendChild(wrapper);

    const box = document.createElement('DIV');
    box.classList.add('error__box');
    wrapper.appendChild(box);

    const table = document.createElement('TABLE');
    table.classList.add('error__table');
    box.appendChild(table);

    const buttonClose = document.createElement('BUTTON');
    buttonClose.id = 'error__close'
    buttonClose.classList.add('btn', 'error__btn');
    buttonClose.innerHTML = '&times;';
    box.appendChild(buttonClose);

    // <THEAD>
    const thead = document.createElement('THEAD');
    thead.classList.add('error__thead');
    table.appendChild(thead);

    const tr = document.createElement('TR');
    tr.classList.add('error__tr');
    thead.appendChild(tr);

    const th = document.createElement('TH');
    th.classList.add('error__th');
    th.setAttribute('colspan', 2);
    thead.appendChild(th);
    // </THEAD>

    const tbody = document.createElement('TBODY');
    tbody.classList.add('error__tbody');
    table.appendChild(tbody);

    for (const item in obj) {
      console.log(item);
      const tr = document.createElement('TR');
      tr.classList.add('error__tr');
      tbody.appendChild(tr);

      const th1 = document.createElement('TH');
      th1.classList.add('error__th');
      tr.appendChild(th1);

      const th2 = document.createElement('TH');
      th2.classList.add('error__th');
      th2.innerText = item;
      tr.appendChild(th2);

        for (const key in obj[item]) {
        console.log(key);
        const tr = document.createElement('TR');
        tr.classList.add('error__tr');
        tbody.appendChild(tr);

        const th = document.createElement('TH');
        th.classList.add('error__th');

        th.innerText = key;
        tr.appendChild(th);

        const td = document.createElement('TD');
        td.classList.add('error__td');
        td.innerText = obj[item][key];
        tr.appendChild(td);
        }
    }
    addEventToButton();
}

export { singleError, singleErrorTest, multiError, errorTemplate };