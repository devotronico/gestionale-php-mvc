window.onbeforeunload = function () {  window.scrollTo(0, 0);}
console.log('CREATE');
 /*
 * ESEMPIO di questo script sta a questo indirizzo https://developer.mozilla.org/en-US/docs/Web/HTML/Element/input/file
 */   
var input = document.querySelector('#image');
var preview = document.querySelector('.preview');

//input.style.opacity = 0;
//input.style.display = 'none';
input.addEventListener('change', updateImageDisplay);

function updateImageDisplay() {

  // fintanto preview.firstChild = true 
  while(preview.firstChild) {
    preview.removeChild(preview.firstChild);
  }

  var curFiles = input.files;

  /*
  if(curFiles.length === 0) { // se non ci sono file caricati
    var para = document.createElement('p');
    para.textContent = 'Nessun file caricato';
    preview.appendChild(para);
  } else {
      */
    var list = document.createElement('ul');
    list.style.listStyleType = 'none';
    preview.appendChild(list); 
  //  for(var i = 0; i < curFiles.length; i++) { // verificare se si può eliminare il ciclo //console.log( curFiles.length);
      var listItem = document.createElement('li');
      var para = document.createElement('p');

     // console.log(  (curFiles[0].size * 0,000001)  ); // number * 0,000001 + 'MBX';
    //  console.log(  (curFiles[0].size * 0.000001)  ); // number * 0,000001 + 'MBX';
     // console.log(  parseFloat(curFiles[0].size * 0.000001) ); // number * 0,000001 + 'MBX';
      console.log(  parseFloat(curFiles[0].size * 0.000001).toFixed(2) );
    //  console.log(  (curFiles[0].size * 0,000001).toFixed(1)  ); // number * 0,000001 + 'MBX';
     // console.log(  (curFiles[0].size * 0.000001).toFixed(1)  ); // number * 0,000001 + 'MBX';
      if(validFileType(curFiles[0])) {
        para.textContent = 'File name ' + curFiles[0].name + ' - file size ' + returnFileSize(curFiles[0].size) + '.';
        var image = document.createElement('img');
        image.src = window.URL.createObjectURL(curFiles[0]);
        image.width = 600;

        listItem.appendChild(image);
        listItem.appendChild(para);

      } else {
        para.textContent = 'File name ' + curFiles[0].name + ': Il tipo di file non è valido.';
        listItem.appendChild(para);
      }


      list.appendChild(listItem);
  //  } // loop 
  //}
}


// CONTROLLO SUI TIPI DI FILE SUPPORTATI
var fileTypes = [
  'image/jpeg',
  'image/pjpeg',
  'image/png'
]

function validFileType(file) {
  for(var i = 0; i < fileTypes.length; i++) {
    if(file.type === fileTypes[i]) {
      return true;
    }
  }
  return false;
}

/*
function returnFileSize(number) {
  if(number < 1024) {
    return number + 'bytes';
  } else if(number >= 1024 && number < 1048576) {
    return (number/1024).toFixed(1) + 'KB';
  } else if(number >= 1048576) {
    return (number/1048576).toFixed(1) + 'MB';
  }
}
*/

function returnFileSize(number) {
  if(number < 1000000) {
    //return (number/1048576).toFixed(1) + 'MB';
    //return number * 0.000001 + ' MB'; // parseFloat("123.456").toFixed(2);
   // return parseFloat(number * 0.000001) + ' MB';
    return parseFloat(number * 0.000001).toFixed(2) + ' MB';
  } 
  else {
   // return (number * 0.000001) + ' MB Le dimensioni del file superano il limite massimo di 1MB';
    return parseFloat(number * 0.000001).toFixed(2) + ' MB Le dimensioni del file superano il limite massimo di 1MB';
  }
}




/*


window.URL = window.URL || window.webkitURL;

var fileSelect = document.getElementById("fileSelect"),
    fileElem = document.getElementById("fileElem"),
    fileList = document.getElementById("fileList");

fileSelect.addEventListener("click", function (e) {
  if (fileElem) {
    fileElem.click();
  }
  e.preventDefault(); // prevent navigation to "#"
}, false);

function handleFiles(files) {
  if (!files.length) {
    fileList.innerHTML = "<p>No files selected!</p>";
  } else {
    fileList.innerHTML = "";
    var list = document.createElement("ul");
    fileList.appendChild(list);
    for (var i = 0; i < files.length; i++) {
      var li = document.createElement("li");
      list.appendChild(li);
      
      var img = document.createElement("img");
      img.src = window.URL.createObjectURL(files[i]);
      img.height = 60;
      img.onload = function() {
        window.URL.revokeObjectURL(this.src);
      }
      li.appendChild(img);
      var info = document.createElement("span");
      info.innerHTML = files[i].name + ": " + files[i].size + " bytes";
      li.appendChild(info);
    }
  }
}
*/


