@extends('layouts.layout')
{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('items') }}">Edit PDF </a></li>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        {{-- CARD HEADER --}}
        <div class="card-header font-bold">
            <h5>Edit PDF Info</h5>
        </div>

        <div class="card-body ">

            {{-- START File feeback FORM --}}
            <form class="form-horizontal" id="UpadteFileForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('put')
                <div class="row">
                    <div class="col-2 text-center">
                        <div class="QrDiv" id="Url{{$links[0]->id}}"></div>

                    </div>
                    <div class="col-10">
                        <div class="row">
                            {{-- photo --}}
                            <div class="form-group col-4">
                                <label for="">Upload optional qr logo</label>
                                <div class="custom-file ">
                                    <input type="file" class="custom-file-input" id="customFile" name="photo">
                                    <label class="custom-file-label" for="photo">Upload optional qr logo</label>
                                    <small id="photo_error"></small>
                                </div>
                            </div>

                            {{-- file --}}
                            <div class="form-group col-4">
                                <label for="">Default file input</label>
                                <input type="file" class="form-control" name="file" >
                                <small id="file_error"></small>
                            </div>


                            {{-- file name --}}
                            <div class="form-group col-4">
                                <label for="">file name</label>
                                <input class="form-control" type="text" required id="name" name="name" value="{{ $links[0]->name }}">
                                <small id="name_error"></small>
                            </div>

                            {{-- file description --}}
                            <div class="form-group col-4">
                                <label for="">file description</label>
                                <input class="form-control" type="text" required id="description" name="description" value="{{ $links[0]->description }}"/>
                                <small id="description_error"></small>
                            </div>
                        </div>
                    </div>

                </div>


                {{-- update button --}}
                <div class="text-right">
                    <button id="updateNewFileButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Edit Url</button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    var qrcode = new QRCode(document.getElementById("Url{{$links[0]->id}}"), {
        text: "helssssssssssssssssssssssssssssssssslo"
        , logo: "{{asset('assets/images/FilesQrLogo').'/'.$links[0]->photo}}"
        , logoWidth: 100
        , logoHeight: 100
        , logoBackgroundTransparent: true
    , });


    $(document).ready(function() {
        $('.QrDiv img').addClass('img-fluid')

    })


    //================  update items    ===================//

    $('#updateNewFileButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();
        // Reset all errors
        $('#file_error').text('');
        $('#name_error').text('');
        $('#description_error').text('');
        $('#photo_error').text('');

        var formData = new FormData($('#UpadteFileForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateFile" , $links[0]->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Item updated successfully!", "", "success")
                    .then(() => {
                        window.location = "{{ url('/links') }}";
                    });
            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to update File", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });
</script>
@endsection
