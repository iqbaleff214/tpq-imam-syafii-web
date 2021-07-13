
(function() {

	
	//======== tiny slider
	var slider = new tns({
		container: '.related-service-slider',
		slideBy: 'page',
		autoplay: false,
		mouseDrag: true,
        gutter: 0,
        items: 1,
		nav: false,
        controls: true,
        controlsText: [
            '<i class="lni lni-arrow-left prev"></i>',
            '<i class="lni lni-arrow-right next"></i>'
        ],
        responsive: {
            1200: {
                items: 2,
            },
            992: {
                items: 1,
            },
            0: {
                items: 1,
            }

        }
    });

	
	
	
	

})();