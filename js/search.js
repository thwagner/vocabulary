window.onload = init;

function init() {
    var boxes = document.getElementsByClassName('cat_box');
  
    for (i = 0; i < boxes.length; i++) {
        boxes[i].onchange = checkCatBoxes;
    }
}

function checkCatBoxes() {
    var boxes = document.getElementsByClassName('cat_box');
    var constrain = false;
    
    for (i = 0; i < boxes.length; i++) {
        alert(document.getElementsByClassName('cat_box')[i].getAttribute('checked'));
        if (document.getElementsByClassName('cat_box')[i].getAttribute('checked') == 'checked') {
            constrain = true;
        }
    }
    
    if (constrain == false) {
        alert('false');
    } else {
        alert('true');
    }
}


