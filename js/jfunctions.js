$(function() {
    
    $("#overview_table").tablesorter({sortList: [[0,0], [1,0]]});    
    last_state = 'up';
    markRows();
    
    $('.overview').click(function() {
        
        markRows();
       
        $('.th_img').each(function() {                          
                $(this).attr('src', '');        
        });  
 
        if (last_state == 'up') {
            $(this).find('img').attr('src', './images/up.png'); 
            last_state = 'down';
        } else if (last_state == 'down') {
            $(this).find('img').attr('src', './images/down.png'); 
            last_state = 'up';
        }                
    })
})

function markRows() {
    var rows = getId('overview_table')
            .getElementsByTagName('tr');
    
    console.log(' ############# ############## ');
    
    for (var i = 1; i < rows.length; i++) {
        rows[i].setAttribute('class', '');
        console.log(i + ": " + rows[i].getAttribute('class'));
    }
    
    console.log(' ############## ################# ');
    
    for (i = 1; i < rows.length; i++) {              
        if (i % 2 == 0) { 
            rows[i].setAttribute('class', 'even');
            console.log(i + ": " + rows[i].getAttribute('class'));
        } else {
            rows[i].setAttribute('class', 'overview');
            console.log(i + ": " + rows[i].getAttribute('class'));
        }
    }
    
    console.log(' ------------ ---------------- ');
}
