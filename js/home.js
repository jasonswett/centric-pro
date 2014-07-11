jQuery(function( $ ){
	
    $('.home-featured .wrap') .css({'height': (($(window).height()))+'px'});
    $(window).resize(function(){
        $('.home-featured .wrap') .css({'height': (($(window).height()))+'px'});
    });
    
    $(".home-featured .home-widgets-1 .widget:last-child").after('<p class="arrow"><a href="#home-widgets"></a></p>');
    
    $.localScroll({
    	duration: 750
    });
	
});