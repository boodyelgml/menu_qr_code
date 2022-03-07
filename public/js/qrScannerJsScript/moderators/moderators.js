



$('#addBtn').on('click', function (e) {
    e.preventDefault();
    // Reset all errors
    $('#name_error').text('');
    $('#image_error').text('');
    $('#email_error').text('');
    $('#phone_number_error').text('');
    $('#password_error').text('');
    $('#role_error').text('');

    var formData = new FormData($('#addForm')[0]);


    $.ajax({
        type: 'post',
        enctype: 'multipart/form-data',
        url: '{{route("createModerators")}}',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        success: function (data) {
            swal("User Added successfully!", "", "success")
                .then(() => {

                    $("#usersDiv").load(location.href + " #usersDiv", function () {
                        $('#usersTable').DataTable({
                            "order": [[6, "desc"]]
                        });
                    });


                });

        }, error: function (reject) {
            swal("failed to add user", "please check ereors", "error");
            var response = $.parseJSON(reject.responseText);
            $.each(response.errors, function (key, val) {
                $("#" + key + "_error").text(val[0]);
            });
        }
    });

});




// {{-- start remove user ajax --}}

$(document).on('click', "#removeBtn", function (e) {

    e.preventDefault();
    swal({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'

    })
        .then((willDelete) => {
            if (willDelete) {
                var userID = $(this).attr('offer_id');
                $.ajax({
                    type: 'delete',
                    url: userID,
                    data: "",
                    success: function (data) {

                        swal("User Deleted successfully!", "", "success")
                            .then(() => {

                                $("#usersDiv").load(location.href + " #usersDiv", function () {
                                    $('#usersTable').DataTable({
                                        "order": [[6, "desc"]]
                                    });
                                });

                            });

                    },
                    error: function (reject) {
                        swal("failed to remove user", "please check ereors", "error");
                    }
                });
            } else {
                swal("modereator still exists!");
            }

        });

});



$(document).ready(function () {
    $('#usersTable').DataTable({
        "order": [[6, "desc"]]
    });
});
