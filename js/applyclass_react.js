$(document).ready(function(){
	//main_slider_applyclass
	var bnrWrap = $('.slider-applyclass')
	var bnr_slider = bnrWrap.find('.bxslider');

	slider = bnr_slider.bxSlider({
		auto: true,
		mode : 'fade',
		cutLimit: 4,
		speed: 500,
		autoStart:true,
		pagerCustom: '#bx-pager-apply',
		onSliderLoad: function(selector){
			bnrWrap.css("overflow","visible");
		}
	});
	$('.page-applyclass').mouseover(function(){
		slider.startAuto();
	});
});