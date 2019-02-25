jQuery(document).ready(function() {

    var length = $('.lijs').length;

    if(length == 7){
        $('li').css('width','14%');
    }
    else if(length == 8){
        $('li').css('width','12.5%');
    }
    else if(length == 9){
        $('li').css('width','11%');
    }
    else if(length == 6){
        $('li').css('width','16.5%');
    }
    else if(length == 5){
        $('li').css('width','20%');
    }
    else if(length == 4){
        $('li').css('width','25%');
    }
    else if(length == 3){
        $('li').css('width','33%');
    }
    else if(length == 2){
        $('li').css('width','50%');
    }

    if($(window).width() < 600){

    }

})