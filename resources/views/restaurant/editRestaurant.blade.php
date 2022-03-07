@extends('layouts.layout')
{{-- title --}}
@section('title') Edit Restaurants @endsection
@if(count($restaurants) > 0)
@foreach($restaurants as $restaurant)

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item"><a href="{{ route('restaurants') }}"> Restaurants list </a></li>
<li class="breadcrumb-item active"><a href="{{ route('editRestaurant' , $restaurant->id) }}">
   Edit @if($restaurant->language == 2) {{ $restaurant->name_ar }} @else {{ $restaurant->name }} @endif </a>
</li>
@endsection

{{-- content --}}
@if (Auth::user()->id === $restaurant->user_id || Auth::user()->role === 1)
@section('content')
<div class="col-12">
   <div class="card">

      {{-- CARD HEADER --}}
      <div class="card-header font-bold">
         <h5>Edit @if($restaurant->language == 2) {{ $restaurant->name_ar }} @else {{ $restaurant->name }} @endif Information</h5>
      </div>

      {{-- CARD BODY --}}
      <div class="card-body">
         <div class="row">
            <form class="form-horizontal" id="updateRestaurantForm" method="POST" enctype="multipart/form-data">
               @csrf
               @method('PUT')

               {{-- language hidden input --}}
               <input name="language" value="{{ $restaurant->language }}" type="hidden" />
               <div id="restaurantForm" class="col-12">
                  <div class="row">

                     {{--============= English section =============--}}
                     @if($restaurant->language == 0 || $restaurant->language == 1)
                     <div class="col-12">
                        <fieldset class="scheduler-border englishLanguage">
                           <legend class="scheduler-border ">English info</legend>
                           <div class="row">

                              {{-- name --}}
                              <div class="form-group col-3">
                                 <input class="form-control" placeholder="Name" type="text" value="{{ $restaurant->name }}" name="name">
                                 <small id="name_error"></small>
                              </div>

                              {{-- type --}}
                              <div class="form-group col-3">
                                 <input class="form-control" placeholder="Type" type="text" value="{{ $restaurant->type }}" name="type">
                                 <small id="type_error"></small>
                              </div>

                              {{-- address --}}
                              <div class="form-group col-3">
                                 <input class="form-control" type="text" value="{{ $restaurant->address }}" placeholder="Address" name="address">
                                 <small id="address_error"></small>
                              </div>

                              {{-- description --}}
                              <div class="form-group col-3">
                                 <input class="form-control" type="text" value="{{ $restaurant->description }}" placeholder="Description" name="description">
                                 <small id="description_error"></small>
                              </div>
                           </div>
                        </fieldset>
                     </div>
                     @endif

                     {{--============= arabic section =============--}}
                     @if($restaurant->language == 0 || $restaurant->language == 2)
                     <div class="col-12 my-4" style="direction: rtl">
                        <fieldset class="scheduler-border arabicLanguage">
                           <legend class="scheduler-border">Arabic info</legend>
                           <div class="row">

                              {{-- الاسم --}}
                              <div class="form-group col-3">
                                 <input class="form-control" type="text" placeholder="أسم المطعم" value="{{ $restaurant->name_ar }}" name="name_ar">
                                 <small id="name_ar_error"></small>
                              </div>

                              {{-- تخصص المطعم --}}
                              <div class="form-group col-3">
                                 <input class="form-control" placeholder="تخصص المطعم" type="text" value="{{ $restaurant->type_ar }}" name="type_ar">
                                 <small id="type_ar_error"></small>
                              </div>

                              {{-- العنوان --}}
                              <div class="form-group col-3">
                                 <input class="form-control" placeholder="عنوان المطعم" type="text" value="{{ $restaurant->address_ar }}" name="address_ar">
                                 <small id="address_ar_error"></small>
                              </div>

                              {{-- الوصف --}}
                              <div class="form-group col-3">
                                 <input class="form-control" placeholder="وصف المطعم" type="text" value="{{ $restaurant->description_ar }}" name="description_ar">
                                 <small id="description_ar_error"></small>
                              </div>
                           </div>
                        </fieldset>
                     </div>
                     @endif

                     {{-- General info --}}
                     <div class="col-12">
                        <fieldset class="scheduler-border">
                           <legend class="scheduler-border ">General info</legend>
                           <div class="row">
                              <div class="col-2 text-center">
                                 <div class="form-group ">

                                    {{-- image view --}}
                                    @if (strlen($restaurant->logo) > 2 )
                                    <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/restauranLogo').'/'.$restaurant->logo}}" height="150" class="hvr-grow placeholder_image img-fluid">
                                    @else
                                    <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/restauranLogo/food-placeholder.png')}}" height="150" class="hvr-grow img-fluid">
                                    @endif

                                    {{-- photo preview --}}
                                    <img data-toggle="modal" data-target=".bd-example-modal-lg" id="blah" src="#" alt="" height="150" class="img-fluid"/>
                                 </div>
                              </div>
                              <div class="col-10">
                                 <div class="row">

                                    {{-- Logo --}}
                                    <div class="form-group col-4">
                                       <div class="custom-file ">
                                          <input type="file" class="custom-file-input" id="customFile" name="logo">
                                          <label class="custom-file-label" for="customFile">Upload
                                          Restaurant
                                          Logo</label>
                                       </div>
                                       <small id="logo_error"></small>
                                    </div>

                                    {{-- website --}}
                                    <div class="form-group col-4">
                                       <input class="form-control" type="text" value="{{ $restaurant->website }}" name="website" placeholder="Restaurant website">
                                       <small id="website_error"></small>
                                    </div>

                                    {{-- phone --}}
                                    <div class="form-group col-4">
                                       <input class="form-control" type="text" value="{{ $restaurant->phone_number }}" name="phone_number" placeholder="phone number">
                                       <small id="phone_number_error"></small>
                                    </div>

                                    {{-- user_id --}}
                                    @if(Auth::user()->role == 1)
                                    <div class="form-group col-4">
                                       <label for="">Choose Restaurant moderator *</label>
                                       <select name="user_id" class="form-control">
                                       @foreach ($users as $user)
                                       <option @if($user->id == $restaurant->user->id) selected @endif
                                       value="{{$user->id}}">{{$user->name}}</option>
                                       @endforeach
                                       </select>
                                       <small id="user_id_error"></small>
                                    </div>
                                    @else
                                    <input type="text" name="user_id" hidden value="{{Auth::user()->id}}">
                                    @endif

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
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </fieldset>

                        {{-- themes --}}
                        <fieldset class="scheduler-border mt-4">
                           <legend class="scheduler-border ">Choose theme</legend>
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

               {{-- add button --}}
               <div class="text-right col-12 mt-3">
                  <button id="updateRestaurantButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Update Restaurant</button>
               </div>
            </form>
         </div>
      </div>
   </div>
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
@endsection

{{-- if not auth --}}
@elseif(Auth::user()->id !== $restaurant->user_id)
@section('content')
<div class="col-12">
   <div class="alert alert-danger">
      Sorry .. you are not authorized to view this restaurant information
   </div>
</div>
@endsection
@endif
@endforeach

{{-- no restaurant found --}}
@else
@section('content')
<div class="col-12">
   <div class="alert alert-danger">
      Sorry .. This restaurant dosn't exist
   </div>
</div>
@endsection
@endif

{{-- start script section  --}}
@if(count($restaurants) > 0)
@if (Auth::user()->id === $restaurant->user_id || Auth::user()->role === 1)
@section("scripts")

<script>
    // ============================================== //
    // ==== updating restaurant information ========= //
    // ============================================== //

    $('#updateRestaurantButton').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
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
        $('#phone_number_error').text('');
        $('#logo_error').text('');
        $('#user_id_error').text('');

        var formData = new FormData($('#updateRestaurantForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateRestaurant" , $restaurant->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Restaurant Successfully updated", "", "success")
                    .then(() => {
                        window.location = "{{ url('/restaurant') }}";
                    });


            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to update Restaurant", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });
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
