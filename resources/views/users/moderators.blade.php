{{-- extend layout --}}
@extends('layouts.layout')

{{-- title --}}
@section('title') Moderators @endsection

{{-- content --}}
@section('content')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('moderators') }}"> Moderators list </a></li>
@endsection

{{-- add new moderator --}}
<div class="col-12 ">
   <p class="text-right">
      <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
      <i class="mdi mdi-account-plus"></i> Add New Moderator
      </button>
   </p>
   <div class="collapse" id="collapseExample">
      <div class="card">
         <div class="card-header font-bold">
            <h5>Add new moderator</h5>
         </div>
         <div class="card-body">
            <form class="form-horizontal" id="addNewModeratorForm" action="{{route("createModerators")}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
               <div class="col-2">
                  <div class="form-group ">
                     <img data-toggle="modal" data-target=".bd-example-modal-lg"data-toggle="lightbox" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/moderators/profile-placeholder.jpg')}}" alt="" width="180px" height="180px" />
                     <img data-toggle="modal" data-target=".bd-example-modal-lg"id="blah" class="img-fluid" />
                  </div>
               </div>
               <div class="col-10">
                  <div class="row">

                     {{-- photo --}}
                     <div class="form-group col-4">
                        <label>Upload Moderator photo</label>
                        <div class="custom-file ">
                           <input type="file" class="custom-file-input" id="customFile" name="photo">
                           <label class="custom-file-label" for="customFile">Choose moderator photo</label>
                        </div>
                        <small id="photo_error"></small>
                     </div>

                     {{-- name --}}
                     <div class="form-group col-4">
                        <label>Moderator name</label>
                        <input class="form-control" type="text" id="username" required placeholder="Name" name="name">
                        <small id="name_error"></small>
                     </div>

                     {{-- email --}}
                     <div class="form-group col-4">
                        <label>Moderator email</label>
                        <input class="form-control" type="email" id="email" required placeholder="E-mail Address" name="email">
                        <small id="email_error"></small>
                     </div>

                     {{-- phone --}}
                     <div class="form-group col-4">
                        <label>Moderator phone number</label>
                        <input class="form-control" type="number" required id="phone" placeholder="phone number" name="phone">
                        <small id="phone_error"></small>
                     </div>

                     {{-- Password --}}
                     <div class="form-group col-4">
                        <label>Moderator password</label>
                        <input class="form-control" type="password" required id="password" placeholder="password" name="password">
                        <small id="password_error"></small>
                     </div>

                     {{-- Role --}}
                     <div class="form-group col-4 d-none">
                        <label>Moderator role</label>
                        <select name="role" class="form-control" required>
                           <option value="2" selected>Restaurant moderator</option>
                        </select>
                        <small id="role_error"></small>
                     </div>
                  </div>
               </div>
            </div>

            {{-- add moderator button --}}
            <div class="text-right">
               <button id="addNewModeratorButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Add moderator</button>
            </div>
            </form>
         </div>
      </div>
   </div>

   {{-- add margin div --}}
   <div style="color: #f1f1f1; margin-top:-10px;">.</div>
</div>

{{--========= moderators list ===========--}}
<div class="col-12">
   <div class="card" id="moderatorsList">

      {{-- card header --}}
      <div class="card-header font-bold">
         <h5>Moderators List</h5>
      </div>

      {{-- card body --}}
      <div class="card-body">
         <table id="moderatorsTable" class="table text-center table-bordered table-sm" style="width:100%">
            <thead>
               <tr>
                  <th>Photo</th>
                  <th>Moderator Name</th>
                  <th style="width: 150px">Email</th>
                  <th style="width: 180px">Restaurant</th>
                  <th>Phone Number</th>
                  <th>created at</th>
                  <th width="150px">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($users as $user)
               <tr>
                  <th scope="row" style="vertical-align: middle">

                     {{-- image --}}
                     @if (strlen($user->photo) > 2 )
                     <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/moderators').'/'.$user->photo}}" alt="profile" class="hvr-grow" height="50px">
                     @else
                     <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/moderators/profile-placeholder.jpg')}}" alt="profile" class="hvr-grow" height="50px">
                     @endif
                  </th>

                  {{-- Name --}}
                  <td>
                     {{$user->name}}
                  </td>

                  {{-- email --}}
                  <td>{{$user->email}}</td>

                  {{-- restaurant --}}
                  <td>
                     @if (count($user->restaurants) >= 1)
                     @foreach ($user->restaurants as $restaurant)
                     @if($restaurant->language == 2)
                     <a href="{{route('showRestaurant' , $restaurant->id)}}"> {{$restaurant->name_ar}}</a>
                     @else
                     <a href="{{route('showRestaurant' , $restaurant->id)}}"> {{$restaurant->name}}</a>
                     @endif
                     <br>
                     @endforeach
                     @else
                     <span class="badge badge-pill badge-secondary">no restaurant</span>
                     @endif
                  </td>

                  {{-- phone number --}}
                  <td>0{{$user->phone_number}}</td>

                  {{-- created at--}}
                  <td>{{$user->created_at->format('d F Y, h:i A')}}</td>
                  <td>
                      <a href="{{route("moderators")}}/{{$user->id}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="show moderator" class="btn btn-icon waves-effect waves-light btn-success"><i class="dripicons-enter"></i></a>
                      <a href="{{route("editModerators" , $user->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="edit moderator" class="btn btn-icon waves-effect waves-light btn-primary "><i class="dripicons-gear"></i></a>
                      @if ($user->role !== 1)
                     <button id="deleteModeratorButton" moderator_id="{{route('deleteModerator', $user->id)}}" data-toggle="tooltip" data-placement="top" title="remove moderator" class="btn btn-icon waves-effect waves-light btn-danger " type="submit"><i class="dripicons-trash"></i></button>
                     @endif
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
                  <th>Created at</th>
                  <th>Actions</th>
               </tr>
            </tfoot>
         </table>
      </div>
   </div>
</div>
@endsection
{{-- script section  --}}
@section("scripts")
<script>
    // ============================================= //
    // ==== start adding new moderator by ajax  ==== //
    // ============================================= //

    $('#addNewModeratorButton').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#name_error').text('');
        $('#image_error').text('');
        $('#email_error').text('');
        $('#phone_number_error').text('');
        $('#password_error').text('');
        $('#role_error').text('');

        var formData = new FormData($('#addNewModeratorForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("createModerators")}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Moderator Added successfully!", "", "success")
                    .then(() => {

                        $("#moderatorsList").load(location.href + " #moderatorsList", function() {
                            DatatableReInitial();
                        });


                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add Moderator", "please check ereors and try again", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });



    // ========================================== //
    // ====  start remove moderator by ajax  ==== //
    // ========================================== //

    $(document).on('click', "#deleteModeratorButton", function(e) {


        e.preventDefault();
        swal({
                title: 'Are you sure?'
                , text: "delete moderator will delete all related restaurants , menus , items and You won't be able to revert this!"
                , type: 'warning'
                , showCancelButton: true
                , confirmButtonColor: '#3085d6'
                , cancelButtonColor: '#d33'
                , confirmButtonText: 'Yes, delete it!'

            })
            .then((willDelete) => {
                $('.loaderContainer').fadeIn(200);
                if (willDelete) {
                    var moderatorID = $(this).attr('moderator_id');
                    $.ajax({
                        type: 'delete'
                        , url: moderatorID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("User Deleted successfully!", "", "success")
                                .then(() => {

                                    $("#moderatorsList").load(location.href + " #moderatorsList", function() {
                                        DatatableReInitial();
                                    });

                                });

                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove moerator", "please check ereors and try again", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("modereator still exists!");
                }

            });

    });

    // ====================================================== //
    // ========== datatable initialization function ==========//
    // ====================================================== //

    function DatatableReInitial() {
        $('#moderatorsTable').DataTable({
            "order": [
                [5, "desc"]
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
        $('tfoot tr th:nth-of-type(7) select').addClass('d-none')

        $('tfoot').each(function() {
            $(this).insertAfter($(this).siblings('thead'));
        });
    }


    // ====================================================== //
    // ========== when document ready function ===============//
    // ====================================================== //

    $(document).ready(function() {
        DatatableReInitial();
    });

</script>
@endsection
