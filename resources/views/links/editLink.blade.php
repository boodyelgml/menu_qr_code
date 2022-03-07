@extends('layouts.layout')
{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('items') }}">Edit Links </a></li>
@endsection

@section('content')
<div class="col-12">
    <div class="card">
        {{-- CARD HEADER --}}
        <div class="card-header font-bold">
            <h5>Add new Url</h5>
        </div>

        <div class="card-body ">

            <form class="form-horizontal" id="updateNewUrlForm" action="" method="POST" enctype="multipart/form-data">
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
                                <label for="">edit optional qr logo</label>
                                <div class="custom-file ">
                                    <input type="file" class="custom-file-input" id="customFile" name="photo">
                                    <label class="custom-file-label" for="photo">Upload optional qr logo</label>
                                    <small id="photo_error"></small>
                                </div>
                            </div>



                            {{-- Url --}}
                            <div class="form-group col-4">
                                <label for="">Url</label>
                                <input class="form-control" type="text" required id="url" name="url" value="{{ $links[0]->url }}">
                                <small id="url_error"></small>
                            </div>

                            {{-- Url name --}}
                            <div class="form-group col-4">
                                <label for="">Url name</label>
                                <input class="form-control" type="text" required id="name" name="name" value="{{ $links[0]->name }}">
                                <small id="name_error"></small>
                            </div>

                            {{-- Url description --}}
                            <div class="form-group col-4">
                                <label for="">Url description</label>
                                <input class="form-control" type="text" required id="description" name="description" value="{{ $links[0]->description }}">
                                <small id="description_error"></small>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- update button --}}
                <div class="text-right">
                    <button id="updateNewUrlButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Edit Url</button>
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
        , logo: "{{asset('assets/images/LinksQrLogo').'/'.$links[0]->photo}}"
        , logoWidth: 100
        , logoHeight: 100
        , logoBackgroundTransparent: true
    , });


    $(document).ready(function() {
        $('.QrDiv img').addClass('img-fluid')

    })


    //================  update items    ===================//

    $('#updateNewUrlButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();
        // Reset all errors
        $('#url_error').text('');
        $('#name_error').text('');
        $('#description_error').text('');
        $('#photo_error').text('');

        var formData = new FormData($('#updateNewUrlForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateLink" , $links[0]->id)}}'
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

                swal("failed to update Link", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });

</script>
@endsection
