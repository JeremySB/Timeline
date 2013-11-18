$(document).ready(function(){
    
//     $("body").mousewheel(function(event, delta) {
//         
//         this.scrollLeft -= (delta * 50);
//         
//         event.preventDefault();
//         
//     });
    
    
    // Don't load OverScroll if on a mobile device. Touchscreens don't work well with it.
    if ( !(/iPhone|iPod|iPad|Android|BlackBerry/).test(navigator.userAgent) )
    {
        $("#wrap").overscroll( { direction: "horizontal", wheelDelta: 40, showThumbs: false } );
    }

}); 