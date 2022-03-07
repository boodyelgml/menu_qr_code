{{-- extend layout --}}
@extends('layouts.layout')

{{-- title --}}
@section('title') Edit Moderator @endsection
@if(count($users) > 0)
@if (Auth::user()->id === $users[0]->id || Auth::user()->role === 1)

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item "><a href="{{ route('moderators') }}">Moderators</a></li>
<li class="breadcrumb-item active"><a href="{{ route('editModerators' , $users[0]->id) }}"> Edit {{ $users[0]->name }}
   information </a>
</li>
@endsection

{{-- content --}}
@section('content')
@foreach($users as $user)

{{-- edit moderator form --}}
<div class="col-12">
   <div class="card">

      {{-- form header --}}
      <div class="card-header font-bold">
         <h5>Edit {{$user->name}} information</h5>
      </div>

      {{-- edit form --}}
      <div class="card-body">
         <form class="form-horizontal" id="updateModeratorInformationForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")
            <div class="row">
               <div class="col-2 text-center">

                  {{-- photo preview --}}
                  <img data-toggle="modal" data-target=".bd-example-modal-lg" src="#" id="blah" alt="" class="img-fluid"/>
                  @if (strlen($user->photo) > 2 )
                  <img data-toggle="modal" data-target=".bd-example-modal-lg"src="{{asset('assets/images/moderators').'/'.$user->photo}}" alt="profile"  class="hvr-grow img-fluid placeholder_image">
                  @else

                  {{-- placeholder --}}
                  <img data-toggle="modal" data-target=".bd-example-modal-lg"class="img-fluid placeholder_image" class="hvr hvr-grow img-fluid" src="{{asset('assets/images/moderators/profile-placeholder.jpg')}}" alt=""/>
                  @endif
               </div>
               <div class="col-10">
                  <div class="row">

                     <!-- image -->
                     <div class="form-group col-4">
                        <label class="col-form-label">Upload Moderator photo</label>
                        <div class="custom-file ">
                           <input type="file" class="custom-file-input " id="customFile" name="photo">
                           <label class="custom-file-label" for="customFile">photo</label>
                        </div>
                        <small id="image_error"></small>
                     </div>

                     {{-- name --}}
                     <div class="form-group col-4">
                        <label class="col-form-label">Moderator name</label>
                        <input name="name" type="text" class="form-control" value="{{$user->name}}" required>
                        <small id="name_error"></small>
                     </div>

                     {{-- email --}}
                     <div class="form-group col-4">
                        <label class="  col-form-label">Moderator email</label>
                        <input name="email" type="text" class="form-control" value="{{$user->email}}" required>
                        <small id="email_error"></small>
                     </div>

                     {{-- phone number --}}
                     <div class="form-group col-4">
                        <label class="  col-form-label">Moderator phone number</label>
                        <input name="phone" type="number" class="form-control" value="0{{$user->phone_number}}" required>
                        <small id="phone_error"></small>
                     </div>

                     {{-- password --}}
                     <div class="form-group col-4">
                        <label class="  col-form-label">Moderator password</label>
                        <input name="password" type="text" class="form-control" value="">
                        <small id="password_error"></small>
                     </div>

                     {{-- Role --}}
                     @if(Auth::user()->role == 1)
                     <div class="form-group col-4 d-none">
                        <label class="  col-form-label">role</label>
                        <select name="role" class="form-control Role" required>
                        <option value="1" @if ($user->role == 1) selected @endif>Super Admin</option>
                        <option value="2" @if ($user->role == 2) selected @endif>restaurant moderator
                        </option>
                        </select>
                        <small id="role_error"></small>
                     </div>
                     @endif
                  </div>
               </div>

               {{-- submit button --}}
               <div class="col-12 text-right mt-3">
                  <button type="submit" id="updateModeratorInformationButton" class="btn btn-primary waves-light waves-effect w-md">Update information</button>
               </div>
            </div>
         </form>
      </div>
   </div>
</div>
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
@section("scripts")

<script>
    // ====================================================== //
    // ========== Edit Moderator information =================//
    // ====================================================== //

    $('#updateModeratorInformationButton').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#name_error').text('');
        $('#image_error').text('');
        $('#email_error').text('');
        $('#phone_number_error').text('');
        $('#password_error').text('');
        $('#role_error').text('');

        var formData = new FormData($('#updateModeratorInformationForm')[0]);


        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateModerators" , $user->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Moderator Successfully updated", "", "success")
                    .then(() => {
                        window.location = "{{ url('/moderators') }}";
                    });
            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to update moderator", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });

</script>

@endsection
@endif
@endif
