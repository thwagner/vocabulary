$(function() {
    
    $("#overview_table").tablesorter({sortList: [[0,0], [1,0]]});
    
    last_state = 'up';
    
    $('.overview').click(function() {
       
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
