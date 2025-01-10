
    $(document).ready(function() {
        $('#login-form').on('submit', function(e) {
            e.preventDefault();

            var name = $('#name').val();
            var password = $('#password').val();
            var token = $('input[name="_token"]').val();

            $.ajax({
                url: "{{ route('login') }}",
                type: 'POST',
                data: {
                    _token: token,
                    name: name,
                    password: password
                },
                success: function(response) {
                    if (response.success) {
                        window.location.href = "{{ route('dashboard') }}";
                    } else {
                        alert('Login failed.');
                    }
                },
                error: function(xhr) {
                    var errors = xhr.responseJSON.errors;
                    if (errors.name) {
                        alert(errors.name[0]);
                    } else if (errors.password) {
                        alert(errors.password[0]);
                    }
                }
            });
        });
    });
