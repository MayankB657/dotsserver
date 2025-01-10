$(document).ready(function () {
    $(document).on('click', '.rightArrowClick', function (e) {
      e.preventDefault();
      e.stopPropagation();
      rightpath = $(this).data('path'); 
      if(rightpath!=''){
        $.ajax({
          url: rightArrowClick,
          method: 'GET',
          data: {path:rightpath},
          success: function (response) {
            window.location.href= rightpath;
          },
          error: function (xhr, status, error) {
              console.error(xhr.responseText);
          }
      });
    }
      
    });
    $(document).on('click', '.leftArrowClick', function (e) {
      e.preventDefault();
      e.stopPropagation();
      let rightpath = $(this).data('path'); 
      let leftpath = $(this).data('leftpath'); 
      $.ajax({
          url: leftArrowClick,
          method: 'GET',
          data: {path:rightpath},
          success: function (response) {
            window.location.href= leftpath;
          },
          error: function (xhr, status, error) {
              console.error(xhr.responseText);
          }
       });
    });
});

