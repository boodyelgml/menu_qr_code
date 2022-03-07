@extends('layouts.layout')
{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('items') }}"> Links </a></li>
@endsection



{{-- CONTENT SECTION --}}
@section('content')
<script src="{{asset('assets/js/jquery.min.js')}}"></script>

{{-- start add new AD --}}
<div class="col-12 ">

    <p class="text-right">
        <button class="btn btn-primary waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="true" aria-controls="collapseExample1">
            <i class="mdi mdi-food-fork-drink"></i> Add New PDF
        </button>

        <button class="btn btn-primary waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample2" aria-expanded="true" aria-controls="collapseExample2">
            <i class="mdi mdi-food-fork-drink"></i> Add New Url
        </button>
    </p>

    {{-- New Link --}}

    <div class="collapse" id="collapseExample2" style="">

        <div class="card">
            {{-- CARD HEADER --}}
            <div class="card-header font-bold">
                <h5>Add new Url</h5>
            </div>

            <div class="card-body ">

                <form class="form-horizontal" id="addNewUrlForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">


                        {{-- photo --}}
                        <div class="form-group col-4">
                            <label for="">Upload optional QR logo</label>
                            <div class="custom-file ">
                                <input type="file" class="custom-file-input" id="customFile" name="photo">
                                <label class="custom-file-label" for="photo">Upload optional QR logo</label>
                                <small id="photo_error"></small>
                            </div>
                        </div>



                        {{-- Url --}}
                        <div class="form-group col-4">
                            <label for="">Url</label>
                            <input class="form-control" type="text" required id="url" name="url" placeholder="Example : http//:www.google.com">
                            <small id="url_error"></small>
                        </div>


                        {{-- Url name --}}
                        <div class="form-group col-4">
                            <label for="">Url name</label>
                            <input class="form-control" type="text" required id="name" name="name" placeholder="maximum characters : 250">
                            <small id="name_error"></small>
                        </div>

                        {{-- Url description --}}
                        <div class="form-group col-4">
                            <label for="">Url description</label>
                            <input class="form-control" type="text" required id="description" name="description" placeholder="minimum characters : 20">
                            <small id="description_error"></small>
                        </div>


                    </div>

                    {{-- add button --}}
                    <div class="text-right">
                        <button id="addNewUrlButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Add Url</button>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>


    {{-- upload file --}}


    <div class="collapse" id="collapseExample1" style="">

        <div class="card">
            {{-- CARD HEADER --}}
            <div class="card-header font-bold">
                <h5>Add new PDF</h5>
            </div>

            <div class="card-body ">

                {{-- START File feeback FORM --}}
                <form class="form-horizontal" id="addNewFileForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        {{-- photo --}}
                        <div class="form-group col-4">
                            <label for="">Upload optional QR logo</label>
                            <div class="custom-file ">
                                <input type="file" class="custom-file-input" id="customFile" name="photo">
                                <label class="custom-file-label" for="photo">Upload optional QR logo</label>
                                <small id="photo_error"></small>
                            </div>
                        </div>

                        {{-- file --}}
                        <div class="form-group col-4">
                            <label for="">Default file input</label>
                            <input type="file" class="form-control" name="file">
                            <small id="file_error"></small>
                        </div>


                        {{-- file name --}}
                        <div class="form-group col-4">
                            <label for="">file name</label>
                            <input class="form-control" type="text" required id="name" name="name" placeholder="maximum characters : 250">
                            <small id="name_error"></small>
                        </div>

                        {{-- file description --}}
                        <div class="form-group col-4">
                            <label for="">file description</label>
                            <input class="form-control" type="text" required id="description" name="description" placeholder="minimum characters : 20">
                            <small id="description_error"></small>
                        </div>
                    </div>

                    {{-- add button --}}
                    <div class="text-right">
                        <button id="addNewFileButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Add file</button>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>
</div>
{{--=====================================================--}}
{{--======================== Url ========================--}}
{{--=====================================================--}}
<div class="col-12" id="linksDiv">
    <div class="card">
        <div class="card-header">
            <h5>Urls</h5>
        </div>
        <div class="card-body">

            @if(count($allLinks) > 0)
            <table id="LinksTable" class="table  text-center table-bordered  table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Url Name</th>
                        <th style="width: 150px">Url Qr image</th>
                        <th>Url Description</th>
                        <th>Url</th>
                        <th>Visits Count</th>
                        <th style="width: 150px">Url Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allLinks as $links)
                    @if(strlen($links->file) <= 0) <tr>

                        {{-- name --}}
                        <td>{{ $links->name }} </td>

                        {{-- qr --}}
                        <td>
                            <div class="QrDiv" id="Url{{$links->id}}"></div>
                        </td>


                        {{-- description --}}
                        <td>{{ $links->description }} </td>


                        {{-- url --}}
                        <td> <a href="{{route('redirectLink' , $links->id)}}" target="blank">Click here to open link</a> </td>

                        {{-- counter --}}
                        <td> <a href="{{ route('visitsCounter' , $links->id) }}" >{{ $links->visit_count }}</a> </td>


                        {{-- Actions --}}
                        <td>
                            <a href="{{route('editLink' , $links->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="edit Link" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                            <button id="deleteLinkButton" Link_id="{{route('deleteLink', $links->id)}}" data-toggle="tooltip" data-placement="top" title="Delete menu" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                        </td>
                        </tr>


                        <script>
                            var qrcode = new QRCode(document.getElementById("Url{{$links->id}}"), {
                                text: "{{route('redirectLink' , $links->id)}}"
                                , logo: "{{asset('assets/images/LinksQrLogo').'/'.$links->photo}}"
                                , logoWidth: 100
                                , logoHeight: 100
                                , logoBackgroundTransparent: true
                            , });

                        </script>
                        @endif
                        @endforeach
                </tbody>

            </table>
            @else
            <div class="alert alert-danger">
                No Links found
            </div>
            @endif

        </div>
    </div>
</div>
{{--=====================================================--}}
{{--======================== file ========================--}}
{{--=====================================================--}}
<div class="col-12" id="FilesDiv">
    <br>
    <div class="card">
        <div class="card-header">
            <h5>Files uoloaded</h5>
        </div>
        <div class="card-body">

            @if(count($allLinks) > 0)
            <table id="FilesTable" class="table  text-center table-bordered  table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>File Name</th>
                        <th style="width: 150px">File Qr image</th>
                        <th>File Description</th>
                        <th>File Url</th>
                        <th>Visits Count</th>
                        <th style="width: 150px">File Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($allLinks as $links)
                    @if(strlen($links->url) <= 0) <tr>

                        {{-- name --}}
                        <td>{{ $links->name }} </td>

                        {{-- qr --}}
                        <td>

                            <div class="QrDiv" id="Url{{$links->id}}"></div>

                        </td>


                        {{-- description --}}
                        <td>{{ $links->description }} </td>


                        {{-- url --}}
                        <td> <a href="{{route('redirectLink' , $links->id)}}" target="blank">Click here to open file</a> </td>

                        {{-- counter --}}
                        <td> <a href="{{ route('visitsCounter' , $links->id) }}" >{{ $links->visit_count }}</a> </td>

                        {{-- Actions --}}
                        <td>
                            <a href="{{route('editFile' , $links->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="edit Link" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                            <button id="deleteLinkButton" Link_id="{{route('deleteLink', $links->id)}}" data-toggle="tooltip" data-placement="top" title="Delete menu" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                        </td>
                        </tr>


                        <script>


                            var qrcode = new QRCode(document.getElementById("Url{{$links->id}}"), {
                                text: "{{route('redirectLink' , $links->id)}}"
                                , logo: "{{asset('assets/images/FilesQrLogo').'/'.$links->photo}}"
                                , logoWidth: 100
                                , logoHeight: 100
                                , logoBackgroundTransparent: true
                            , });



                                var attr = $('.QrDiv img').attr('src');
                                console.log(attr);


                        </script>
                        @endif
                        @endforeach
                </tbody>

            </table>
            @else
            <div class="alert alert-danger">
                No Files found
            </div>
            @endif

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#LinksTable').DataTable();
        $('#FilesTable').DataTable();

    })
    //======= add new url by ajax ==================//
    $('#addNewUrlButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#url_error').text('');
        $('#name_error').text('');
        $('#description_error').text('');
        $('#photo_error').text('');
        var formData = new FormData($('#addNewUrlForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route('createUrl')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Url Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add Url", "please check errors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });


    // ===================================================== //
    //================ delete  url by ajax ================ //
    // ===================================================== //

    $(document).on('click', "#deleteLinkButton", function(e) {

        e.preventDefault();
        swal({
                title: 'Are you sure?'
                , text: "You won't be able to revert this!"
                , type: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, delete it!'
            })
            .then((willDelete) => {
                $('.loaderContainer').fadeIn(200);
                if (willDelete) {
                    var Link_id = $(this).attr('Link_id');
                    $.ajax({
                        type: 'delete'
                        , url: Link_id
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);
                            swal("Menu Deleted successfully!", "", "success")
                                .then(() => {
                                    location.reload();
                                });
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);
                            swal("failed to delete Menu", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);
                    swal("Menu still exists!");
                }
            });
    });


    //===============================================//
    //======= add new file by ajax ==================//
    //===============================================//
    $('#addNewFileButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#file_error').text('');
        $('#name_error').text('');
        $('#description_error').text('');
        $('#photo_error').text('');
        var formData = new FormData($('#addNewFileForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route('createFile')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("File Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add File", "please check errors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });

</script>

@endsection
