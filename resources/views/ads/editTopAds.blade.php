@extends('layouts.layout')


{{-- content --}}

@if(count($ads) > 0)
@if (Auth::user()->id === $ads[0]->restaurant->user_id || Auth::user()->role === 1)

@section('content')

<div class="col-12">
   <div class="card">

      <div class="card-header font-bold">
         Edit Ad
      </div>

      <div class="card-body">

         <form class="form-horizontal" id="editForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="row">
               @foreach ($ads as $ad)

               {{-- Ad photo --}}
               <div class="form-group col-4">
                  <label for="">Upload Ad photo</label>
                  <div class="custom-file ">
                     <input type="file" class="custom-file-input" id="customFile" name="photo">
                     <label class="custom-file-label" for="customFile">Upload Ads photo</label>
                  </div>
                  <small id="photo_error"></small>
               </div>

               {{-- Ad description --}}
               <div class="form-group col-4">
                  <label for="">Ad description</label>
                  <input class="form-control" type="text" required id="description" name="description" value="{{ $ad->description }}">
                  <small id="description_error"></small>
               </div>

                 {{-- ad link --}}
                 <div class="form-group col-4">
                    <label for="">Ad link</label>
                    <input class="form-control" type="text" required id="description" name="ad_link" value="{{ $ad->ad_link }}">
                    <small id="ad_link"></small>
                 </div>

               {{-- Video url --}}
               <div class="form-group col-4">
                  <label for="">Video url</label>
                  <input class="form-control" type="text" required id="description" name="video_url" value="{{ $ad->video_url }}">
                  <small id="description_error"></small>
               </div>

               {{-- view Ad as --}}
               <div class="form-group col-4">
                  <label for="">view Ad as :</label>
                  <select class="form-control" name="main">
                  <option value="1" @if($ad->main == 1) selected @endif>Photo</option>
                  <option value="0" @if($ad->main == 0) selected @endif>Video</option>
                  </select>
                  <small id="main_error"></small>
               </div>

               {{-- visibility --}}
               <div class="form-group col-4">
                  <label for="">visibility</label>
                  <select class="form-control" name="is_visible">
                  <option value="1" @if($ad->is_visible == 1) selected @endif>visible</option>
                  <option value="0" @if($ad->is_visible == 0) selected @endif>Not visible</option>
                  </select>
                  <small id="is_visible_error"></small>
               </div>

               {{-- restaurant --}}
               <div class="form-group col-4">
                  <label for="">Ads Restaurant</label>

                  {{-- super Admin --}}
                  <select class="form-control" name="restaurant_id" id="" >
                     @if(Auth::user()->role == 1)
                     @foreach ($restaurants as $restaurant)
                     <option value="{{$restaurant->id}}" @if ($restaurant->id == $ad->restaurant_id) selected @endif>{{$restaurant->name}}</option>
                     @endforeach
                     @else

                     {{-- any moderator --}}
                     @foreach ($restaurants as $restaurant)
                     @if($restaurant->user_id == Auth::user()->id)
                     <option value="{{$restaurant->id}}">{{$restaurant->name}}</option>
                     @endif
                     @endforeach
                     @endif
                  </select>
                  <small id="restaurant_id"></small>
               </div>

               @endforeach
            </div>
         </form>
         <div class="text-right">
            <button id="updateBtn" class="btn btn-primary waves-light waves-effect w-md">Update Ad</button>
         </div>
      </div>
   </div>
</div>
@endsection

{{-- unothorized --}}
@elseif(Auth::user()->id !== $ads[0]->$restaurant->user_id)
@section('content')
<div class="col-12">
   <div class="alert alert-danger">
      Sorry .. you are not authorized to view this Ad information
   </div>
</div>
@endsection
@endif

{{-- no restaurant found --}}
@else
@section('content')
<div class="col-12">
   <div class="alert alert-danger">
      Sorry .. This Ad dosn't exist
   </div>
</div>
@endsection
@endif

{{-- start script section  --}}
@if(count($ads) > 0)
@if (Auth::user()->id === $ads[0]->restaurant->user_id || Auth::user()->role === 1)
@section("scripts")

{{-- start edit script --}}

<script>
   $('#updateBtn').on('click', function (e) {
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
   	var formData = new FormData($('#editForm')[0]);
   	$.ajax({
   		type: 'post',
   		enctype: 'multipart/form-data',
   		url: '{{route("updateTopAds" , $ad->id)}}',
   		data: formData,
   		processData: false,
   		contentType: false,
   		cache: false,
   		success: function (data) {
   			$('.loaderContainer').fadeOut(200);
   			swal("Ad updated successfully!", "", "success").then(() => {
   				window.location = "{{ url('/vertise') }}";
   			});
   		},
   		error: function (reject) {
   			$('.loaderContainer').fadeOut(200);
   			swal("failed to Edit Ad", "please check ereors", "error");
   			var response = $.parseJSON(reject.responseText);
   			$.each(response.errors, function (key, val) {
   				$("#" + key + "_error").text(val[0]);
   			});
   		}
   	});
   });

</script>
@endsection
@endif
@endif
