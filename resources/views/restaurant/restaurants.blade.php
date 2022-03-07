@extends('layouts.layout')
{{-- TITLE SECTION --}}
@section('title') Restaurants list @endsection

{{-- CONTENT SECTION --}}
@section('content')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('restaurants') }}"> Restaurants list </a></li>
@endsection

@if(Auth::user()->role == 1)

{{-- start add new restaurant --}}
<div class="col-12 ">

   {{-- collapse add restaurant button --}}
   <p class="text-right">
      <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
      Add New Restaurant
      </button>
   </p>

   {{-- collabsed div --}}
   <div class="collapse " id="collapseExample">
      <div class="card">

          <div class="card-header font-bold">
            <h5>Add new Restaurant</h5>
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
                              <legend class="scheduler-border ">English info</legend>
                              <div class="row">

                                 {{-- name --}}
                                 <div class="form-group col-3">
                                    <input class="form-control" placeholder="Restaurant Name" type="text" name="name">
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
                                    <input class="form-control" type="text" placeholder="Restaurant Description" name="description">
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

                        {{--============= General section =============--}}
                        <div class="col-12">
                           <fieldset class="scheduler-border">


                              <legend class="scheduler-border ">General info</legend>
                              <div class="row">

                                 {{-- photo preview --}}
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

                                       {{-- Logo --}}
                                       <div class="form-group col-4">
                                          <div class="custom-file ">
                                             <input type="file" class="custom-file-input" id="customFile" name="logo">
                                             <label class="custom-file-label" for="customFile">Upload Restaurant Logo</label>
                                          </div>
                                          <small id="logo_error"></small>
                                       </div>

                                       {{-- website --}}
                                       <div class="form-group col-4">
                                          <input class="form-control" type="text" name="website" placeholder="Restaurant website">
                                          <small id="website_error"></small>
                                       </div>

                                       {{-- phone --}}
                                       <div class="form-group col-4">
                                          <input class="form-control" type="number" name="phone_number" placeholder="Restaurant phone">
                                          <small id="phone_number_error"></small>
                                       </div>

                                       {{-- user_id --}}
                                       <div class="form-group col-4">

                                          <label for="">Choose Restaurant moderator *</label>
                                          <select name="user_id" class="form-control">
                                          @foreach ($users as $user)
                                          <option @if($user->role == 1) selected @endif
                                          value="{{$user->id}}">{{$user->name}}</option>
                                          @endforeach
                                          </select>
                                          <small id="user_id_error"></small>

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

                           {{--============= THEMES =============--}}
                           <fieldset class="scheduler-border mt-4">
                              <legend class="scheduler-border ">Choose Restaurant menus theme</legend>
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
   </div>
</div>
@endif

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
</div>
<div style="color: #f1f1f1; margin-top:-10px;">.</div>
</div>

{{-- restaurants list --}}
<div class="col-12">
   <div class="card" id="restaurantsDiv">

       <div class="card-header font-bold">
         <h5>Restaurants List</h5>
      </div>

       <div class="card-body">
         @if(count($restaurants) > 0)

          <table id="RestaurantsTable" class="table text-center table-bordered table-sm" style="width:100%">
            <thead>
               <tr>
                  <th style="width:100px">Logo</th>
                  <th>Restaurant Name</th>
                  <th style="width:120px">Type</th>
                  <th>Address</th>
                  <th>Moderator</th>
                  <th style="width:160px">Menus</th>
                  <th>Phone</th>
                  <th style="width: 180px">Created at</th>
                  <th style="width: 150px">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($restaurants as $restaurant)
               <tr>

                  {{-- logo --}}
                  <td> <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/restauranLogo').'/'.$restaurant->logo}}" alt="profile" height="50px" class="hvr-grow"  data-toggle="modal" data-target=".bd-example-modal-lg"></td>

                  {{-- Name --}}
                  <td> {{$restaurant->name}}  </td>

                  {{-- type --}}
                  <td> {{$restaurant->type_ar}} </td>

                  {{-- address --}}
                  <td> {{$restaurant->address_ar}} </td>

                  {{-- moderator --}}
                  <td>{{$restaurant->user->name}}</td>

                  {{-- restaurant->menu --}}
                  <td>
                     @if (count($restaurant->menus) >= 1)
                     @foreach ($restaurant->menus as $menu)
                      <a href="{{route("showMenu" , $menu->id)}}"> {{$menu->name}} </a> <br>
                      @endforeach
                     @else
                     <span class="badge badge-pill badge-secondary">no menus found</span>
                     @endif
                  </td>

                  {{-- phone --}}
                  <td>{{$restaurant->phone_number}}</td>

                  {{-- created at --}}
                  <td>{{$restaurant->created_at->format('d F Y, h:i A')}}</td>

                  {{-- Actions --}}
                  <td>
                      <a href="{{route("showRestaurant" , $restaurant->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Show restaurant" class="btn btn-icon waves-effect waves-light btn-success"><i class="dripicons-enter"></i></a>
                      <a href="{{route("editRestaurant" , $restaurant->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Edit restaurant" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                     {{-- <button id="deleteRestaurant" restaurant_id="{{route('deleteRestaurant', $restaurant->id)}}" data-toggle="tooltip" data-placement="top" title="Delete restaurant" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button> --}}
                    </td>
               </tr>


               @endforeach
            </tbody>
            <tfoot>
               <tr>
                  <th>Photo</th>
                  <th>Moderator Name</th>
                  <th>Email</th>
                  <th>Restaurant</th>
                  <th>Phone Number</th>
                  <th>Phone Number</th>
                  <th>Phone Number</th>
                  <th>Phone Number</th>
                  <th>created at</th>
               </tr>
            </tfoot>
         </table>
         @else
         <div class="alert alert-danger">
            No restaurant found
         </div>
         @endif
      </div>
   </div>
</div>
</div>
@endsection

{{--== start script section ==--}}
@section("scripts")

<script>
    // ====================================================== //
    // ========== choose language for restaurant   ===========//
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
    // ========== add new restaurant by ajax  ================//
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

                        $("#restaurantsDiv").load(location.href + " #restaurantsDiv", function() {
                            datatableReInitial()
                        });
                    });
            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("Failed to add Restaurant", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });



    // ====================================================== //
    // ========== delete  restaurant by ajax  ================//
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
                                    $("#restaurantsDiv").load(location.href + " #restaurantsDiv", function() {
                                        datatableReInitial()
                                    });
                                })
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Failed to Delete Restaurant", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("modereator still exists!");
                }

            });

    })

    // ====================================================== //
    // ========== Re initial datatables func  ================//
    // ====================================================== //

    function datatableReInitial() {

        // datatable init
        $('#RestaurantsTable').DataTable({
            "order": [
                [7, "desc"]
            ]
            , initComplete: function() {
                this.api().columns().every(function() {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function() {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function(d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });


        $('tfoot tr th select').addClass('form-control')
        $('tfoot tr th:first-of-type select').addClass('d-none')
        $('tfoot tr th:nth-of-type(4) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(6) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(7) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(9) select').addClass('d-none')

        $('tfoot').each(function() {
            $(this).insertAfter($(this).siblings('thead'));
        });
    }
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

    // ====================================================== //
    // ============== when document is ready  ================//
    // ====================================================== //

    $(document).ready(function() {
        datatableReInitial()
     });

</script>
@endsection
