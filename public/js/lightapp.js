        
        showlightapp(0);
        $(document).on('click', '.selectcategory', function (e) {
            e.preventDefault();
            var categoryId = $(this).data('catid');
            showlightapp(categoryId);
            
        });
        
        function showlightapp(categoryId){
            $.ajax({
                url: showLightApp,
                method: 'GET',
                data: { category_id: categoryId },
                success: function (response) {
                    // Update the app list container with the updated list
                    $('#lightappcontent').html(response.html);
                },
                error: function (xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }
        
        $(document).on('click', '.editoption', function (e) {
            e.preventDefault();
            var categoryId = $(this).data('appid');
            $('#buttoncontainer'+categoryId).toggle('hidden');
            
        });
        
