showWallpaper(type);

function showWallpaper(type) {

    $.ajax({
        url: wallpaperlist,
        method: 'GET',
        data: {
            type: type
        },
        success: function (response) {
            $('#wallpaper-content').html(response.html);
            // console.log(response.html);
        },
        error: function (xhr, status, error) {
            console.error(xhr.responseText);
        }
    });

}
$(document).on('click', '.open-popup', function () {
    $('#imageUploadPopup').removeClass('hidden');

});

$(document).on('click', '.close-popup', function () {
    $('#imageUploadPopup').addClass('hidden');

    $('#imagePreview').addClass('hidden').attr('src', '');

    $('#fileInput').val('');
});

$(document).on('change', '#fileInput', function (event) {
    const input = event.target;
    const imagePreview = $('#imagePreview');
    $('.select-image').addClass('hidden');
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function (e) {
            imagePreview.attr('src', e.target.result).removeClass('hidden');
        };
        reader.readAsDataURL(input.files[0]);
    }
});

$(document).on('submit', '#uploadForm', function (e) {
    e.preventDefault();
    const formData = new FormData(this);
    $('#imageUploadPopup').addClass('hidden');
    $('#imagePreview').addClass('hidden').attr('src', '');
    $('#fileInput').val('');
    $.ajax({
        url: getWallpaperUploadRoute,
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        success: function (response) {
            if (response.success) {
                toastr.success(response.message);
                showWallpaper(type);
                $('.select-image').removeClass('hidden');
            } else {
                toastr.error(response.message || 'Failed to upload wallpaper.');
            }

        },
        error: function (xhr) {
            if (xhr.status === 422) {
                const errors = xhr.responseJSON.errors;
                if (errors && errors.image && errors.image[0]) {
                    toastr.error(errors.image[0]);
                } else {
                    toastr.error('An error occurred while uploading the wallpaper.');
                }
            } else {
                toastr.error('An error occurred while uploading the wallpaper.');
            }
            console.error(xhr.responseText);
        }
    });
});

$(document).on('change', '.c-checkbox', function () {
    const checkbox = $(this);
    const wallpaperId = checkbox.data('id');
    const type = checkbox.data('type');     
    const isChecked = checkbox.is(':checked'); 
    if (isChecked) {
        $('.c-checkbox[data-type="' + type + '"]').not(checkbox).prop('checked', false);
    }

    $.ajax({
        url: updateUserWallpaperData,
        method: 'POST',
        data: {
            wallpaper_id: isChecked ? wallpaperId : (type === 'theme' ? null : 0),
            type: type,
            is_checked: isChecked,
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        },
        success: function (response) {
            if (response.success) {
                const message = isChecked 
                    ? `${type.charAt(0).toUpperCase() + type.slice(1)} updated successfully.` 
                    : `Removed ${type} successfully.`;
                toastr.success(message); 
                fetchAndApplyTheme();
                applySavedTheme();
            } else {
                toastr.error(response.message || 'Failed to update wallpaper.');
            }
        },
        error: function (xhr) {
            toastr.error('An error occurred while updating the wallpaper.');
            console.error(xhr.responseText);
        },
    });
});






