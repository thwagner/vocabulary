window.onload = init

function init() {
    
    getRef('form_update').onsubmit = function() {
        var answer = confirm('Please confirm the execution of the update!');
        
        if (answer === true) {
            return true
        } else {
            alert('Update-Operation cancelled.');
            return false;
        }
    }
}

function getRef(id) {
    return document.getElementById(id);
}


