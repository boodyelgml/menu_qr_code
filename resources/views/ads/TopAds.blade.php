@extends('layouts.layout')
@section('content')

{{-- add AD --}}
<div class="col-12 ">
    <p class="text-right">
        <button class="btn btn-primary waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            <i class="mdi mdi-food-fork-drink"></i> Add Top add
        </button>
    </p>
    <div class="collapse " id="collapseExample">
        <div class="card">

            {{-- CARD HEADER --}}
            <div class="card-header font-bold">
                <h5>Add New Top Ads</h5>
            </div>
            <div class="card-body ">
                <form class="form-horizontal" id="addTopAdForm" action="{{route('createTopAds')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-2">
                            <div class="form-group mt-3">
                                <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" height="250px" src="{{asset('assets/images/adsPhoto/placeholder.png')}}" />
                                <img data-toggle="modal" data-target=".bd-example-modal-lg" id="blah" src="#" alt="" class="img-fluid" height="100px" />
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="row">

                                {{-- Ad photo --}}
                                <div class="form-group col-4">
                                    <label for="">Upload Ad photo</label>
                                    <div class="custom-file ">
                                        <input type="file" class="custom-file-input" id="customFile" name="photo">
                                        <label class="custom-file-label" for="customFile">Upload Ads photo</label>
                                    </div>
                                    <small id="photo_error"></small>
                                </div>

                                {{-- description --}}
                                <div class="form-group col-4">
                                    <label for="">Ad description</label>
                                    <input class="form-control" type="text" required id="description" name="description">
                                    <small id="description_error"></small>
                                </div>

                                {{-- ad link --}}
                                <div class="form-group col-4">
                                    <label for="">Ad link</label>
                                    <input class="form-control" type="text" required id="description" name="ad_link" placeholder="https://www.example.com">
                                    <small id="ad_link_error"></small>
                                </div>


                                {{-- Video url --}}
                                <div class="form-group col-4">
                                    <label for="">Video url</label>
                                    <input class="form-control" type="text" required id="description" name="video_url">
                                    <small id="video_url_error"></small>
                                </div>

                                {{-- view Ad as : --}}
                                <div class="form-group col-4">
                                    <label for="">view Ad as :</label>
                                    <select class="form-control" name="main">
                                        <option value="1" selected>Photo</option>
                                        <option value="0">Video</option>
                                    </select>
                                    <small id="main_error"></small>
                                </div>

                                {{-- visibility --}}
                                <div class="form-group col-4">
                                    <label for="">visibility</label>
                                    <select class="form-control" name="is_visible">
                                        <option value="1" selected>visible</option>
                                        <option value="0">Not visible</option>
                                    </select>
                                    <small id="is_visible_error"></small>
                                </div>

                                {{-- restaurant --}}
                                <div class="form-group col-4">
                                    <label for="">Ads Restaurant</label>
                                    <select class="form-control" name="restaurant_id" id="">
                                        @foreach ($restaurants as $restaurant)
                                        <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                                        @endforeach
                                    </select>
                                    <small id="restaurant_id_error"></small>
                                </div>
                            </div>

                            {{-- add button --}}
                            <div class="text-right">
                                <button id="addTopAdButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Add
                                    Ad</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>
</div>

{{--START All ads list --}}
<div class="col-12">
    <div class="card" id="adsDiv">
        <div class="card-header font-bold">
            <h5>TopAds List</h5>
        </div>
        <div class="card-body">
            @if(count($TopAds) < 1 ) <div class="alert alert-danger font-bold font-16">Oops , it seems there is no ads
                at this restaurant yet ..
        </div>
        @else
        <table id="adsTable" class="table  text-center table-bordered  table-sm" style="width:100%">
            <thead>
                <tr>
                    <th>photo</th>
                    <th>Description</th>
                    <th>ad link</th>
                    <th>video url</th>
                    <th>view ad as</th>
                    <th>visibility</th>
                    <th>Restaurant</th>
                    <th>Created at</th>
                    <th style="width: 150px">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($TopAds as $TopAd)

                <tr>
                    <td>

                        {{-- Ad photo view --}}
                        @if (strlen($TopAd->photo) > 2 )

                        {{-- if photo exists --}}
                        <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/TopAdPhoto').'/'.$TopAd->photo}}" alt="Ad" height="60px" class="hvr-grow">
                        @else

                        {{-- photo placeholder --}}
                        <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/TopAdPhoto/placeholder.jpg')}}" class="hvr-grow" alt="..." height="60px">
                        @endif
                    </td>

                    {{-- ad description --}}
                    <td> {{$TopAd->description}} </td>

                    {{-- ad link --}}
                    <td> {{$TopAd->ad_link}} </td>

                    {{-- ad video url --}}
                    <td> {{$TopAd->video_url}} </td>

                    {{-- view ad as --}}
                    <td>
                        @if($TopAd->main == 1)
                        photo
                        @else
                        video
                        @endif
                    </td>

                    {{-- ad visibility --}}
                    <td>
                        @if ($TopAd->is_visible == 1)
                        <span class="badge badge-success"> visible</span>
                        @else
                        <span class="badge badge-danger">Not visible</span>
                        @endif
                    </td>

                    {{-- restaurant --}}
                    <td> <a href="{{ route('showRestaurant' , $TopAd->restaurant->id) }}"> {{$TopAd->restaurant->name}}</a></td>

                    {{-- created at --}}
                    <td>{{$TopAd->created_at->format('d F Y, h:i A')}} </td>
                    <td>
                        <a href="{{route('editTopAds' , $TopAd->id)}}" class="btn btn-primary"><i class="dripicons-gear"></i></a>
                        <button id="deleteTopAdButton" restaurant_id="{{route('deleteTopAds' , $TopAd->id)}}" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                    </td>
                </tr>


                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
</div>
@endsection


{{-- start script section  --}}
@section("scripts")

<script>
    // add top ad
    $('#addTopAdButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#photo_error').text('');
        $('#description_error').text('');
        $('#ad_link_error').text('');
        $('#video_url_error').text('');
        $('#main_error').text('');
        $('#is_visible_error').text('');
        $('#restaurant_id_error').text('');

        var formData = new FormData($('#addTopAdForm')[0]);
        console.log(formData);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route('createTopAds')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);
                swal("Ad Added successfully!", "", "success")
                    .then(() => {
                        $("#adsDiv").load(location.href + " #adsDiv", function() {
                            $('#adsTable').DataTable({
                                "order": [
                                    [5, "desc"]
                                ]
                            });
                        });
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add ad", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });


    // delete top ad
    $(document).on('click', "#deleteTopAdButton", function(e) {

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
                    var restaurantID = $(this).attr('restaurant_id');
                    $.ajax({
                        type: 'delete'
                        , url: restaurantID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Ad Deleted successfully!", "", "success")
                                .then(() => {
                                    $("#adsDiv").load(location.href + " #adsDiv", function() {
                                        $('#adsTable').DataTable({
                                            "order": [
                                                [5, "desc"]
                                            ]
                                        });
                                    });
                                });
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove Ad", "please check ereors", "error");
                        }
                    });
                } else {
                    swal("Ad still exists!");
                }

            });
    });

    // when document ready
    $(document).ready(function() {
        $('#adsTable').DataTable({
            "order": [
                [5, "desc"]
            ]
        });
    });

</script>
@endsection
