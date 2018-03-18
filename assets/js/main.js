(function ($) {
	$(document).ready(function () {
        
        console.log(popupContentParams);

        // Vars
        var body = $('body'),
            popupContentResult,
            popupContentAjaxData,
            popupContentWrap,
            popupContentMain,
            popupContentLink,
            popupContentCloseLink;
            popupContentWrapClass = {
                active: 'popup-wrapper--active',
                close: 'popup-wrapper--close'
            },
            popupContentStateClass = {
                open: 'popup-content-state-open',
                close: 'popup-content-state-close'
            };

            if( popupContentParams.linkClass ) {
                popupContentLink = $(popupContentParams.linkClass);
            } else {
                popupContentLink = $('.popup-content-link');
            }
    
            if( popupContentParams.closeLinkClass ) {
                popupContentCloseLink = $(popupContentParams.closeLinkClass);
            } else {
                popupContentCloseLink = $('.popup-content-close');
            }

            if( popupContentParams.wrapClass ) {
                popupContentWrap = $(popupContentParams.wrapClass);
            } else {
                popupContentWrap = $('.popup-wrapper');
            }

            if( popupContentParams.mainClass ) {
                popupContentMain = $(popupContentParams.mainClass);
            } else {
                popupContentMain = $('.popup');
            }
            

        // Main funcs
        // Close popup
        function popupContentClose() {
			popupContentWrap
                .empty()
                .removeClass(popupContentWrapClass.active)
                .hide();

            body
                .addClass(popupContentStateClass.close)
                .removeClass(popupContentStateClass.open);
        }

        // Open popup
        function popupContentOpen( popupContentLink ) {
            
            var popupContentPostId = popupContentLink.data('post-id');
        
            popupContentAjaxData = {
				action: 'popup_content',
				postId: popupContentPostId
			};

			jQuery.post( popupContentParams.ajaxUrl, popupContentAjaxData, function(popupContentResponse) {

				popupContentResult = popupContentResponse;

				popupContentWrap
					.html(popupContentResult)
					.show();
            });

            popupContentWrap.addClass(popupContentWrapClass.active);
            
            body
                .addClass(popupContentStateClass.open)
                .removeClass(popupContentStateClass.close);
        }
        
        // Ajax query and open popup on button click
        popupContentLink.click(function(e){
            e.preventDefault();
            popupContentOpen( $(this) );
		});

        // Close popup on button click
		popupContentCloseLink.click(function(e){
            e.preventDefault();
			popupContentClose();
        });

        $(document).mouseup(function (e){
                
            if (!popupContentMain.is(e.target) &&
                !popupContentLink.is(e.target) &&
                popupContentMain.has(e.target).length === 0 &&
                popupContentWrap.has(e.target).length === 0) {
                popupContentClose();
            }

        });


	});
})(jQuery);