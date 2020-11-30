(function ($) {
    jQuery( document ).ready(function( $ ) {
        var $currencyBtn = $('.ht-currency-btn');
        var $currencyPicker = $('.ht-currency-picker');
        var $dropdown = $('.ht-currency-dropdown');
        var $window = $(window);

        function getElementHeight(el) {
            return el.height()
        }

        function getClientPosition(el) {
            return el[0].getBoundingClientRect().bottom
        }

        function getSpaceInBottom(elPosition) {
            return $window.height() - elPosition
        }

        $currencyBtn.on('click', function (e) {
            var $this = $(this);
            var $parent = $this.parent();
            var $dropdown = $this.siblings('.ht-currency-dropdown');
            var $position = getClientPosition($parent);
            var $dropdownHeight = getElementHeight($dropdown);
            var $spaceInBottom = getSpaceInBottom($position);
            if ($spaceInBottom < ($dropdownHeight + 20)) {
                $dropdown.css({
                    "top": "auto",
                    "bottom": "100%",
                    "margin-top": "0px",
                    "margin-bottom": "10px"
                })
            }
            $parent.toggleClass('active');
        })

        // Hide dropdown after click on body
        var $body = $('body');
        $body.on('click', function (e) {
            var $target = e.target;
            var $dom = $('body').children();
            if (!$($target).is($currencyBtn) && !$($target).is($currencyBtn.children()) && !$($target).parents().is('.active')) {
                $dom.find('.active').removeClass('active');
            }
        });
    });


}(jQuery))