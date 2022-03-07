{{-- extend layout --}}
@extends('layouts.layout')
@section('styles')
<style>
   .profile_info div {
   margin: 10px 0px;
   }
</style>
@endsection
@if(count($users) > 0)
@if (Auth::user()->id === $users[0]->id || Auth::user()->role === 1)
@foreach($users as $user)

{{-- title --}}
@section('title') {{$user->name}} info @endsection
@section('breadcrumps')
<li class="breadcrumb-item "><a href="{{ route('moderators') }}">Moderators</a></li>
<li class="breadcrumb-item active"><a href="{{ route('editModerators' , $users[0]->id) }}"> show {{ $users[0]->name }}
   information </a>
</li>
@endsection
@section('content')

{{-- add new restaurant form --}}
<div class="col-12 ">
   <div class="text-right mb-2">
      @if(Auth::user()->role == 1)
      <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
      Add New Restaurant
      </button>
      @endif

      {{-- super admin --}}
      @if(Auth::user()->role == 1)
      <a href="{{route("editModerators" , $user->id)}}" type="button" name="button" class="btn btn-primary waves-light waves-effect w-md">Edit moderator</a>
      @endif
   </div>
   @if(Auth::user()->role == 1)
   <div class="collapse " id="collapseExample" style="">
      <div class="card">
         <div class="card-header font-bold">
            <h5>Add new Restaurant to {{ $user->name }}</h5>
         </div>
         <div class="card-body ">
            <form class="form-horizontal" id="addNewRestaurantForm" action="{{route('createRestaurant')}}" method="POST" enctype="multipart/form-data">
               @csrf
               <div class="row">

                  {{-- choose language --}}
                  <div class="col-4 mb-4">
                     <select name="language" id="languageSelect" class="form-control">
                        <option value="" disabled selected>Choose restaurant language</option>
                        <option value="0">English & Arabic</option>
                        <option value="1">English only</option>
                        <option value="2">Arabic only</option>
                     </select>
                  </div>
                  <div id="restaurantForm" class="col-12 d-none">
                     <div class="row">

                        {{--============= English section =============--}}
                        <div class="col-12">
                           <fieldset class="scheduler-border englishLanguage">
                              <legend class="scheduler-border">English info</legend>
                              <div class="row">

                                 {{-- name --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" placeholder="Restaurant name" type="text" name="name">
                                    <small id="name_error"></small>
                                 </div>

                                 {{-- type --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" placeholder="Restaurant type" type="text" name="type">
                                    <small id="type_error"></small>
                                 </div>

                                 {{-- address --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" type="text" placeholder="Restaurant Address" name="address">
                                    <small id="address_error"></small>
                                 </div>

                                 {{-- description --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" type="text" placeholder="Restaurant description" name="description">
                                    <small id="description_error"></small>
                                 </div>
                              </div>
                           </fieldset>
                        </div>

                        {{--============= arabic section =============--}}
                        <div class="col-12 my-4" style="direction: rtl">
                           <fieldset class="scheduler-border arabicLanguage">
                              <legend class="scheduler-border">Arabic info</legend>
                              <div class="row">

                                 {{-- الاسم --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" type="text" placeholder="أسم المطعم" name="name_ar">
                                    <small id="name_ar_error"></small>
                                 </div>

                                 {{-- تخصص المطعم --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" placeholder="تخصص المطعم" type="text" name="type_ar">
                                    <small id="type_ar_error"></small>
                                 </div>

                                 {{-- العنوان --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" placeholder="عنوان المطعم" type="text" name="address_ar">
                                    <small id="address_ar_error"></small>
                                 </div>

                                 {{-- الوصف --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" placeholder="وصف المطعم" type="text" name="description_ar">
                                    <small id="description_ar_error"></small>
                                 </div>
                              </div>
                           </fieldset>
                        </div>

                        {{-- general info --}}
                        <div class="col-12">
                           <fieldset class="scheduler-border">
                              <legend class="scheduler-border ">General info</legend>
                              <div class="row">

                                 {{-- logo placeholder --}}
                                 <div class="col-2 text-center">
                                    <div class="form-group ">

                                       {{-- logo placeholder --}}
                                       <img data-toggle="modal" data-target=".bd-example-modal-lg"data-toggle="lightbox" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/restauranLogo/food-placeholder.png')}}" height="150" />

                                       {{-- logo preview after select --}}
                                       <img data-toggle="modal" data-target=".bd-example-modal-lg"id="blah" src="" class="img-fluid" />
                                    </div>
                                 </div>
                                 <div class="col-10">
                                    <div class="row">

                                       {{-- select Logo input--}}
                                       <div class="form-group col-4">
                                          <div class="custom-file ">
                                             <input type="file" class="custom-file-input" id="customFile" name="logo">
                                             <label class="custom-file-label" for="customFile">Upload
                                             Restaurant Logo</label>
                                          </div>
                                          <small id="logo_error"></small>
                                       </div>

                                       {{-- website --}}
                                       <div class="form-group col-4">
                                          <input class="form-control" type="text" name="website" placeholder="Restaurant website">
                                          <small id="website_error"></small>
                                       </div>

                                       {{-- phone number --}}
                                       <div class="form-group col-4">
                                          <input class="form-control" type="number" name="phone_number" placeholder="Restaurant phone">
                                          <small id="phone_number_error"></small>
                                       </div>

                                       {{-- user_id --}}
                                       <div class="form-group col-4 ">
                                          @if(Auth::user()->role == 1)
                                          <label for=""> Restaurant moderator </label>
                                          <select name="user_id" class="form-control">
                                             <option value="{{$user->id}}">{{$user->name}}</option>
                                          </select>
                                          <small id="user_id_error"></small>
                                          @else
                                          <input type="text" name="user_id" hidden value="{{Auth::user()->id}}">
                                          @endif
                                       </div>

                                       {{-- add branch input --}}
                                       <div class="form-group col-8">
                                          <div class="form-group fieldGroup">
                                             <label for="">branches</label>
                                             <div class="input-group">
                                                <input type="text" name="branch_address[]" class="form-control englishLanguage" placeholder="branch address" />
                                                <input type="text" name="branch_address_ar[]" class="form-control arabicLanguage" style="direction: rtl" placeholder="عنوان الفرع" />
                                                <div class="input-group-addon">
                                                   <a href="javascript:void(0)" class="btn btn-success addMore"><span class="glyphicon glyphicon glyphicon-plus" aria-hidden="true"></span> Add branch</a>
                                                </div>
                                                <small id="branch_address_error"></small>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </fieldset>

                           {{-- themes --}}

                           {{--============= THEMES =============--}}
                           <fieldset class="scheduler-border mt-4">
                              <legend class="scheduler-border ">Choose restaurant menus theme</legend>
                              <div class="mb-2">* you can change theme anytime</div>
                              <div class="row text-center">

                                 {{--============= theme1 =============--}}
                                 <div class="col-2 ">

                                    {{-- theme photo --}}
                                    <img data-toggle="modal" data-target=".bd-example-modal-lg"data-toggle="lightbox" class="hvr hvr-grow mb-3 img-fluid" src="{{asset('assets/images/themes/1.jpg')}}" alt="" style="border-radius:5px" /> <br>
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="theme" id="inlineRadio1" value="1" checked>
                                       <label class="form-check-label" for="inlineRadio1">
                                       theme 1
                                       </label> &nbsp;

                                       {{-- <a href="#"> preview</a> --}}
                                    </div>
                                 </div>

                                 {{--============= theme 2 =============--}}
                                 <div class="col-2">

                                    {{-- theme photo --}}
                                    <img data-toggle="modal" data-target=".bd-example-modal-lg"data-toggle="lightbox" class="hvr hvr-grow mb-3 img-fluid" src="{{asset('assets/images/themes/2.jpg')}}" alt="" style="border-radius:5px" /> <br>
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="theme" id="inlineRadio2" value="2" disabled>
                                       <label class="form-check-label" for="inlineRadio2">
                                       theme 2
                                       </label>&nbsp;

                                       {{-- <a href="#">preview</a> --}}
                                    </div>
                                 </div>

                                 {{--============= theme 3 =============--}}
                                 <div class="col-2">
                                    {{-- theme photo --}}
                                    <img data-toggle="modal" data-target=".bd-example-modal-lg"data-toggle="lightbox" class="hvr hvr-grow mb-3 img-fluid" src="{{asset('assets/images/themes/3.jpg')}}" alt="" style="border-radius:5px" /> <br>
                                    <div class="form-check form-check-inline">
                                       <input class="form-check-input" type="radio" name="theme" id="inlineRadio3" value="3" disabled>
                                       <label class="form-check-label" for="inlineRadio3">
                                       theme 3
                                       </label>&nbsp;

                                       {{-- <a href="#">preview</a> --}}
                                    </div>
                                 </div>
                              </div>
                              <small id="theme_error"></small>
                           </fieldset>
                        </div>
                     </div>
                  </div>
               </div>

               {{-- add button --}}
               <div class="text-right">
                  <button id="addNewRestaurantButton" class="btn btn-primary waves-light waves-effect w-md mt-3" type="submit">Add
                  </button>
               </div>
            </form>
         </div>
      </div>
      <div style="color: #f1f1f1; margin-top:-10px;">.</div>
   </div>
   @endif
</div>

<!-- copy of input branch fields group -->
<div class="form-group fieldGroupCopy" style="display: none;">
   <div class="input-group">
      <input type="text" name="branch_address[]" class="form-control englishLanguage" placeholder="branch address" />
      <input type="text" name="branch_address_ar[]" class="form-control arabicLanguage" style="direction: rtl" placeholder="عنوان الفرع" />
      <div class="input-group-addon">
         <a href="javascript:void(0)" class="btn btn-danger remove"><span class="glyphicon glyphicon glyphicon-remove" aria-hidden="true"></span> Remove</a>
      </div>
   </div>
</div>

{{-- info card --}}
<div class="col-12" id="restaurantsDiv">
   <div class="card">
      <div class="card-header font-bold">
         <h5> {{ $user->name }} information</h5>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-4">
               <div class="row">

                  {{-- photo view --}}
                  <div class="col-4">
                     @if (strlen($user->photo) > 2 )
                     <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/moderators').'/'.$user->photo}}" alt="profile" height="150px" class="hvr-grow img-fluid">
                     @else
                     <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/moderators/profile-placeholder.jpg')}}" alt="profile" class="hvr-grow img-fluid" height="150px">
                     @endif
                  </div>

                  {{-- moderator information --}}
                  <div class="col-8 profile_info" style="vertical-align: middle">
                     <div><span class="font-bold">Moderator name :</span> {{$user->name}}</div>
                     <div><span class="font-bold">Email :</span> {{$user->email}}</div>
                     <div><span class="font-bold">Phone number :</span> 0{{$user->phone_number}}</div>
                     <div><span class="font-bold">Created at :</span>
                        {{$user->created_at->format('d F Y, h:i A')}}
                     </div>
                  </div>
               </div>
            </div>

            {{-- start moderator restaurants --}}
            <div class="col-8" style="border-left: #f1f1f1 1px solid">
               @if (count($user->restaurants) >= 1)
               <h6 class="mb-3">
                  {{ $user->name }} is {{ count($user->restaurants) }} Restaurants Moderator
               </h6>
               <table class="table table-bordered table-sm text-center">
                  <thead>
                     <tr>
                        <th>Logo</th>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Address</th>
                        <th>description</th>
                        <th style="width: 130px">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($user->restaurants as $restaurant)
                     <tr>
                        <td>
                           @if (strlen($restaurant->logo) > 2 )
                           <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/restauranLogo').'/'.$restaurant->logo}}" height="50px" class="hvr-grow">
                           @else
                           <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/restauranLogo/food-placeholder.png')}}" height="50px" class="hvr-grow">
                           @endif
                        </td>
                        <td> <a href="{{route('showRestaurant' , $restaurant->id)}}">
                           @if ($restaurant->language == 2)
                           {{$restaurant->name_ar}}
                           @else
                           {{$restaurant->name}}
                           @endif
                           </a>
                        </td>
                        <td>
                           @if ($restaurant->language == 2)
                           {{$restaurant->type_ar}}
                           @else
                           {{$restaurant->type}}
                           @endif
                        </td>
                        <td>
                           @if ($restaurant->language == 2)
                           {{$restaurant->address_ar}}
                           @else
                           {{$restaurant->address}}
                           @endif
                        </td>
                        <td>
                           @if ($restaurant->language == 2)
                           {{$restaurant->description_ar}}
                           @else
                           {{$restaurant->description}}
                           @endif
                        </td>
                        <td>

                           {{-- edit restaurant --}}
                           <a href="{{route("editRestaurant" , $restaurant->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Edit restaurant" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>

                           @if(Auth::user()->role == 1)
                           {{-- delete Restaurant button --}}
                           <button id="deleteRestaurant" restaurant_id="{{route('deleteRestaurant', $restaurant->id)}}" data-toggle="tooltip" data-placement="top" title="Remove restaurant" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                           @endif
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               @else
               <div>
                  <div class="alert alert-danger font-bold font-16">Oops , it seems there is no Restaurant
                     assigned to
                     {{$user->name}}
                     yet ..
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
</div>
@endif
@endforeach
@endsection

{{-- if not auth --}}
@elseif(Auth::user()->id !==$users[0]->id)
@section('content')
<div class="col-12">
   <div class="alert alert-danger">
      Sorry .. you are not authorized to view this user information
   </div>
</div>
@endsection
@endif

{{-- no restaurant found --}}
@else
@section('content')
<div class="col-12">
   <div class="alert alert-danger">
      Sorry .. This user dosn't exist
   </div>
</div>
@endsection
@endif

{{-- start script section  --}}
@if(count($users) > 0)
@if (Auth::user()->id === $users[0]->id || Auth::user()->role === 1)

@section('scripts')
<script>
    // ====================================================== //
    // ========== Choose language to add restaurant ==========//
    // ====================================================== //


    $('#languageSelect').on('change', function() {
        var language = $("#languageSelect").val()
            , englishArabic = 0
            , english = 1
            , arabic = 2

        if (language == englishArabic) {
            if ($('#restaurantForm').hasClass('d-none')) {
                $('#restaurantForm').removeClass('d-none');
            }
            if ($('.arabicLanguage').hasClass('d-none')) {
                $('.arabicLanguage').removeClass('d-none');
            }
            if ($('.englishLanguage').hasClass('d-none')) {
                $('.englishLanguage').removeClass('d-none');
            }
        } else if (language == english) {
            if ($('#restaurantForm').hasClass('d-none')) {
                $('#restaurantForm').removeClass('d-none');
            }
            if (!($('.arabicLanguage').hasClass('d-none'))) {
                $('.arabicLanguage').addClass('d-none');
            }
            if ($('.englishLanguage').hasClass('d-none')) {
                $('.englishLanguage').removeClass('d-none');
            }
        } else if (language == arabic) {
            if ($('#restaurantForm').hasClass('d-none')) {
                $('#restaurantForm').removeClass('d-none');
            }
            if ($('.arabicLanguage').hasClass('d-none')) {
                $('.arabicLanguage').removeClass('d-none');
            }
            if (!($('.englishLanguage').hasClass('d-none'))) {
                $('.englishLanguage').addClass('d-none');
            }
        }

    })


    // ====================================================== //
    // ========== Add new Restaurant to moderator   ==========//
    // ====================================================== //

    $('#addNewRestaurantButton').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();
        // Reset all errors

        $('#name_error').text('');
        $('#name_error').text('');
        $('#name_ar_error').text('');
        $('#type_error').text('');
        $('#type_ar_error').text('');
        $('#address_error').text('');
        $('#address_ar_error').text('');
        $('#description_error').text('');
        $('#description_ar_error').text('');
        $('#website_error').text('');
        $('#theme_error').text('');
        $('#branch_address_error').text('');
        $('#phone_number_error').text('');
        $('#logo_error').text('');
        $('#user_id_error').text('');

        var formData = new FormData($('#addNewRestaurantForm')[0]);
        console.log(formData)
        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("createRestaurant")}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Restaurant Added successfully!", "", "success")
                    .then(() => {
                        $("#restaurantsDiv").load(location.href + " #restaurantsDiv");
                    });
            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add restaurant", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });


    // ====================================================== //
    // ========== delete restaurant from moderator ===========//
    // ====================================================== //

    $(document).on('click', "#deleteRestaurant", function(e) {


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

                            swal("Restaurant Deleted successfully!", "", "success")
                                .then(() => {
                                    $("#restaurantsDiv").load(location.href + " #restaurantsDiv");
                                })
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove restaurant", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Restaurant still exists!");
                }

            });

    })
    // ====================================================== //
    // ============== Add New Branch Input func ================//
    // ====================================================== //
    $(document).ready(function() {
        //group add limit
        var maxGroup = 10;

        //add more fields group
        $(".addMore").click(function() {
            if ($('body').find('.fieldGroup').length < maxGroup) {
                var fieldHTML = '<div class="form-group fieldGroup">' + $(".fieldGroupCopy").html() + '</div>';
                $('body').find('.fieldGroup:last').after(fieldHTML);
            } else {
                alert('Maximum ' + maxGroup + ' branches are allowed.');
            }
        });

        //remove fields group
        $("body").on("click", ".remove", function() {
            $(this).parents(".fieldGroup").remove();
        });
    });

</script>

@endsection
@endif
@endif
