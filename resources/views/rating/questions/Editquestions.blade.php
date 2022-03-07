@extends('layouts.layout')
{{-- TITLE SECTION --}}
@section('title')
feedback questions list
@endsection
@foreach ($questions as $question)


{{-- CONTENT SECTION --}}
@section('content')

{{-- start add new AD --}}
<div class="col-12 ">
   <div class="card">

      {{-- CARD HEADER --}}
      <div class="card-header font-bold">
         <h5>Edit feedback question</h5>
      </div>
      <div class="card-body ">

         {{-- START question feeback FORM --}}
         <form class="form-horizontal" id="EditQuestionForm" action="{{route('updateQuestion', $question->id)}}"
            method="POST" enctype="multipart/form-data">
            @csrf
            @method('put')
            <div class="row">

               {{-- Question --}}
               <div class="form-group col-4">
                  <label for="">Question</label>
                  <input class="form-control" type="text" required id="question" name="question"
                     value="{{ $question->question }}" placeholder="Example : how is our service ?">
                  <small id="question_error"></small>
               </div>

               {{-- Question ar --}}
               <div class="form-group col-4">
                  <label for="">arabic Question</label>
                  <input class="form-control" type="text" required id="question_ar" name="question_ar"
                     value="{{ $question->question_ar }}" style="direction: rtl"
                     placeholder="مثال : ما رأيك فى خدماتنا ؟">
                  <small id="question_ar_error"></small>
               </div>

               {{-- is visible --}}
               <div class="form-group col-4">
                  <label for="">visibility</label>
                  <select class="form-control" name="is_visible">
                  <option value="1" @if($question->is_visible == 1) selected @endif>visible</option>
                  <option value="0" @if($question->is_visible == 0) selected @endif>Not visible</option>
                  </select>
                  <small id="is_visible_error"></small>
               </div>

               {{-- restaurants --}}
               <div class="form-group  col-4">
                  <label for="">choos restaurants</label>
                  <select multiple class="form-control" id="exampleFormControlSelect2" name="restaurant_id[]">

                     {{-- super admin --}}
                     @if(Auth::user()->role == 1)
                     @foreach ($restaurants as $restaurant)
                     <option value="{{ $restaurant->id }}" selected>{{ $restaurant->name }}</option>
                     @endforeach
                     @elseif(Auth::user()->role == 2)
                     @foreach ($restaurants as $restaurant)
                     @if($restaurant->user_id == Auth::user()->id)
                     <option value="{{ $restaurant->id }}" selected>{{ $restaurant->name }}</option>
                     @endif
                     @endforeach
                     @endif
                  </select>
                  <small id="restaurant_id_error"></small>
               </div>
            </div>

            {{-- add button --}}
            <div class="text-right">
               <button id="EditQuestionButton" class="btn btn-primary waves-light waves-effect w-md"
                  type="submit">Add question</button>
            </div>
         </form>
      </div>
   </div>
   <div style="color: #f1f1f1; margin-top:-10px;">.</div>
</div>
@endsection
@endforeach


{{-- start script section  --}}
@section("scripts")
<script>
    $('#EditQuestionButton').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();
         // Reset all errors
         $('#question_error').text('');
        $('#question_ar_error').text('');
        $('#is_visible_error').text('');
        $('#restaurant_id_error').text('');

        var formData = new FormData($('#EditQuestionForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateQuestion" , $question->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("question updated successfully!", "", "success")
                    .then(() => {
                        window.location = "{{ url('/question') }}";
                    });
            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to update question", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });


</script>
@endsection
