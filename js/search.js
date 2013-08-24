window.onload = init;

function init() {
   var business = getId('business');
   business.onchange = function() {
        checkCatBoxes(business);
   }
   
   var general = getId('general');
   general.onchange = function() {
        checkCatBoxes(general);
   }
   
   var informal = getId('informal');
   informal.onchange = function() {
        checkCatBoxes(informal);
   }
   
   var technology = getId('technology');
   technology.onchange = function() {
        checkCatBoxes(technology);
   }
}

function checkCatBoxes(id) {
   var boxes = document.getElementsByClassName('cat_box');
   var ok = false;
   
   for (var i = 0; i < boxes.length; i++) {
       if (boxes[i].checked == true) {
           ok = true
       }      
   } 
   
   if (ok == false) {
       id.checked = true;
       id.focus();
       alert('At least one category-box must be checked.');
   }
}


