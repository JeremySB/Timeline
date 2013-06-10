$(document).ready(function(){
     
     // Change to grab cursor
     $('#wrap')
     .mousedown(function() {
          $(this).addClass("closedhand").removeClass("openhand");
     })
     .mouseup(function() {
          $(this).addClass("openhand").removeClass("closedhand");
     })
     
// Scrolling things:
     var  animateTime = 1,
          offsetStep = 15;
    
     scrollWrapper = $('#wrap');
    
     //event handling for buttons "left", "right"
     $('.bttR, .bttL')
     .mousedown(function() {
          scrollWrapper.data('loop', true).loopingAnimation($(this), $(this).is('.bttR') );
     })
     .bind("mouseup mouseout", function(){
          scrollWrapper.data('loop', false).stop();
     });
     
     //controls clicking, dragging, and scrolling
     scrollWrapper
          .mousedown(function(event) {
               $(this)
                     .data('down', true)
                     .data('x', event.clientX) //clientX gets pointer position
                     .data('scrollLeft', this.scrollLeft);
               return false;
          })
          .mouseup(function (event) {
               $(this).data('down', false);
          })
          .mousemove(function (event) {
               if ($(this).data('down') == true) {
                    this.scrollLeft = $(this).data('scrollLeft') + $(this).data('x') - event.clientX;
               }
          })
          .mousewheel(function (event, delta) {
               this.scrollLeft -= (delta * 40); // change this to control mousewheel scrolling speed
          })
          .css({
               'overflow' : 'hidden',
          });
     
     
     $.fn.loopingAnimation = function(el, dir){
          if(this.data('loop')){
               var sign = (dir) ? '+=' : '-=';
               this.animate({ scrollLeft: sign + offsetStep + 'px' }, animateTime, function(){ $(this).loopingAnimation(el,dir) });
          }
          return false;
     }; 
})

/* $(function(){
     $("body").mousewheel(function(event, delta) {
          this.scrollLeft -= (delta * 40);
          event.preventDefault();
          console.log(this);
          // alert(delta);
     });   
}); */