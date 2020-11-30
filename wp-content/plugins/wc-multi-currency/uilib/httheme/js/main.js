(function($) {
	"use strict";

	function htMcsTab() {
		var	$htMcsTabNav = $('.ht-mcs-tab-nav');
		$htMcsTabNav.on('click', 'a', function(e){
			e.preventDefault();
			var $this = $(this);
			htMcsTabClick($this);
		});
	}
	function htMcsTabClick(a){
		var $this = a,
			$target = $this.attr('href');
		$this.addClass('active').closest('li').siblings().find('a').removeClass('active');
		$('.ht-mcs-tab-pane'+$target).addClass('active').siblings().removeClass('active');
	}
	$( document ).ready(function() {
		'use strict';
		htMcsTab();
		try{
			var hash = window.location.hash;
			if(hash=="#tb-APBDWMC_license"){
				htMcsTabClick($(hash));
			}
		}catch (e) {
			console.log(e);
		}
		try{
			$(".ht-apd-notice-tab-link:not(.added-htc)").on("click",function (e) {
				e.preventDefault();
				var elm=$($(this).attr("href"));
				htMcsTabClick(elm);
			}).addClass("added-htc");
		}catch (e) {

		}
		try {
			$("#gn_currency_list").sortable({
				handle: ".btn-handle"
			});
		}catch (e) {

		}
	});

})(jQuery);
