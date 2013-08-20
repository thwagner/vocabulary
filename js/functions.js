
function getId(id) {
    return document.getElementById(id);
}

function askConfirmBeforeDelete() {
    return confirm('Do you really want to delete this word?');
}

function validateFormAdd() {
    var english = getId('english').value;
    var german = getId('german').value;
    var error_report = '';
    
    if (english.length < 2 || isNaN(english) == false) {
        getId('report').setAttribute('class', 'report_fail');
        error_report += 'Please fill the box <i>English</i> \n\
            with at least two characters.';
    }
    
    if (german.length < 2 || isNaN(german) == false) {
        getId('report').setAttribute('class', 'report_fail');
        if (error_report.length > 0) {
            error_report = 'Please fill the boxes <i>Englisch</i> \n\
                and <i>German</i> with at least two characters.';
        } else {
            error_report += 'Please fill the box <i>German</i> \n\
                with at least two characters.';
        }
    }
    
    if (error_report != '') {
        getId('report').innerHTML = error_report;
        return false;
    } else {       
        return true;
    }
}


