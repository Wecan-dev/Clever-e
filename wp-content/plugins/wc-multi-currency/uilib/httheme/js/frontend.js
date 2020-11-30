(function ($) {
    "use strict";
    jQuery( document ).ready(function( $ ) {
       $(".apbd-currency-picker-dd").each(function(){
          var $maincontainer=$(this);
          var $button=$maincontainer.children('a.apbd-menu-icon');
          var $selectorContainer=$maincontainer.children('div.apbd-currency-dd-container');
          var $offsetTop=15;
           $selectorContainer.appendTo(document.body);
           function hideAPBDDDContainer(){
               $selectorContainer.removeClass('active');
               $button.removeClass('active');
           }
           function showAPBDDDContainer(){
               var $buttonPosition = $button.offset();
               var $containerHeight = $selectorContainer.height();
               var $windowWidth = $(window).width();
               var $windowHeight = $(window).height();
               var $rightPosition = $windowWidth - ($buttonPosition.left + $button.width());
               var $topPosition=($buttonPosition.top + $button.height() + $offsetTop);
               var $containerBottomPos=$topPosition+$containerHeight;
               if($rightPosition > $buttonPosition.left){
                   $selectorContainer.css("left",$buttonPosition.left);
               }else{
                   $selectorContainer.css("right",$rightPosition);
               }
               if($containerBottomPos>$windowHeight && ($topPosition-$containerHeight) > 10){
                   //display upper
                   console.log("Display Upper");
                   console.log($selectorContainer);
                   var $bottomPosition=($buttonPosition.top - ($containerHeight+$offsetTop));
                   $selectorContainer.css("top",$bottomPosition);
               }else{
                   //display lower
                   console.log("Display Lower");
                   console.log($selectorContainer);
                   $selectorContainer.css("top",$topPosition);
               }
               console.log($topPosition+$containerHeight);
               console.log($windowHeight);
               //console.log($rightPosition);
               //check height


               $selectorContainer.addClass("active");
               $button.addClass('active');
               //console.log($button.position());
           }
           $button.on("click",function (e) {
               e.preventDefault();
               e.stopPropagation();
               if($selectorContainer.is('.active')){
                   hideAPBDDDContainer();
               }else {
                   showAPBDDDContainer();
               }

           });

           $('body').on('click', function (e) {
               var $target = e.target;
               if (!$($target).is($button) && !$($target).is($button.children()) && $selectorContainer.is('.active')) {
                   hideAPBDDDContainer();
               }
           });

       });
/*
        // Hide dropdown after click on body
        var $body = $('body');
        $body.on('click', function (e) {
            var $target = e.target;
            var $dom = $('body').children();
            if (!$($target).is($currencyBtn) && !$($target).is($currencyBtn.children()) && !$($target).parents().is('.active')) {
                $dom.find('.active').removeClass('active');
            }
        });*/
    });


}(jQuery))