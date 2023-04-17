(function($){
  $.fn.extend({

    sideNav : function(){
      if( $('.pageslideBg').length == 0 ) {
            $('<div />').attr( 'class', 'pageslideBg' ).appendTo( $('body') );      
        }
        var $btn = $(this),
          $pageslide = $($btn.attr("href")),
        $pageslideBg = $('.pageslideBg'),
        _width = $pageslide.width();
      $btn.click(function(){
        $pageslideBg.show();
        $pageslide.css({ 'display':'block'}).animate({'left':0 });
        return false;
      });
      $pageslideBg.click(function() {
        $(this).hide();
        $pageslide.animate({'left': _width*-1 + 'px' },function(){
          $(this).hide();
        });
        return false;
      });

      return this;
    }

  });
})(jQuery);