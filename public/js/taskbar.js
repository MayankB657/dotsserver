$(document).ready(function () {
    const pinIcon = $('#pinned');
    const $taskbar = $('.navbar');

    // Initial setup
    $taskbar.addClass('show');

    $(document).on('click', '#pinned', function () {
        let $iframePopup = $('#alliframelist .popupiframe');

        if (pinIcon.hasClass('ri-pushpin-line')) {
            $(document).on('mousemove', handleMouseMove);
            if ($iframePopup.hasClass('maximized')) {
                $iframePopup.removeClass('reduced-height')
            }
            pinIcon.removeClass('ri-pushpin-line').addClass('ri-unpin-line');

        } else {
            $(document).off('mousemove', handleMouseMove);
            if ($iframePopup.hasClass('maximized')) {
                $iframePopup.addClass('reduced-height')
              
            }
            pinIcon.addClass('ri-pushpin-line').removeClass('ri-unpin-line')
               
            }
        
    });

    function handleMouseMove(event) {
        const taskbarHeight = $taskbar.outerHeight();
      
        // Show the taskbar when the cursor is at the very top of the screen (y = 0)
        if (event.clientY === 0 || event.clientY <= 1) { // Ensures it triggers at the top edge
            $taskbar.addClass('show');
            adjustIframeHeight();
        }

        // Hide the taskbar when the cursor moves out of the taskbar's height
        if (event.clientY > taskbarHeight && !pinIcon.hasClass('ri-pushpin-line')) {
            $taskbar.removeClass('show');
            adjustIframeHeight();
        }
    }
    
    $taskbar.on('mouseover', function () {
        $taskbar.addClass('show');
        adjustIframeHeight();
    });

    $taskbar.on('mouseout', function (event) {
        const taskbarHeight = $taskbar.outerHeight();

        if (event.clientY > taskbarHeight && !pinIcon.hasClass('ri-pushpin-line')) {
            $taskbar.removeClass('show');
            adjustIframeHeight();
        }
    });

    function adjustIframeHeight() {
        const $iframePopup = $('#alliframelist .popupiframe');
        if ($iframePopup.hasClass('maximized')) {
            if ($taskbar.hasClass('show')) {
                $iframePopup.addClass('reduced-height');
            } else {
                $iframePopup.removeClass('reduced-height');
            }
        }
    }

    // Maximize button functionality
    $(document).on('click', '#alliframelist .maximizeiframe-btn', function () {
        const iframeId = $(this).data('iframe-id');
        const iframePopup = $('#alliframelist #iframepopup' + iframeId);
        const $taskbar = $('.navbar');

        iframePopup.toggleClass('maximized');

        // Immediately adjust the taskbar and iframe height after state change
        setTimeout(() => {
            adjustIframeHeight();
            if (!iframePopup.hasClass('maximized')) {
                $taskbar.addClass('show'); // Ensure the taskbar remains visible
            }
        }, 0); // Call adjustIframeHeight immediately without delay
    });

     $('#alliframelist .popupiframe').each(function () {
        const $this = $(this);
        $this.addClass('minimized'); // Default state is minimized
        $this.removeClass('maximized reduced-height');
    });

    $(document).on('mousemove', function (event) {
        if (event.clientY <= 1 && !$taskbar.hasClass('show') && !pinIcon.hasClass('ri-pushpin-line')) {
            $taskbar.addClass('show');
            adjustIframeHeight();
        }
    });
});