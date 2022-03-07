{{-- layout --}}

@extends('layouts.layout')

{{-- content --}}
@section('content')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item"><a href="{{ route('menus') }}"> Menus list </a></li>
<li class="breadcrumb-item active"><a href="{{ route('editMenu' , $menus[0]->id) }}">
   Edit @if($menus[0]->restaurant->language == 2) {{ $menus[0]->name_ar }} @else {{ $menus[0]->name }} @endif </a>
</li>
@endsection
<div class="col-12">
   <div class="card">
      <div class="card-header font-bold">
         <h5>Edit Menu information</h5>
      </div>
      <div class="card-body">
         @foreach($menus as $menu)
         <div class="row">
            <div class="col-12">

               {{-- ADD Menu FORM --}}
               <form class="form-horizontal" id="editMenuForm" method="POST" enctype="multipart/form-data">
                  @csrf
                  @method('PUT')
                  <div class="row">

                     {{-- hidden language input --}}
                     <input type="text" value="{{ $menu->restaurant->language }}" name="language" hidden>

                     {{-- add menu --}}
                     <section id="addMenuAfterChooseRestaurant" class="col-12">
                        <div class="row">
                           <div class="col-2 ">

                              {{-- photo --}}
                              <div class="form-group mt-3">

                                 {{-- if photo exist --}}
                                 @if($menu->photo > 2)
                                 <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/menuPhoto/').'/'.$menu->photo}} " />
                                 @else

                                 {{-- if photo not exist placeholder --}}
                                 <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/menuPhoto/placeholder.png')}} " />
                                 @endif

                                 {{-- photo preview after select--}}
                                 <img data-toggle="modal" data-target=".bd-example-modal-lg" id="blah" src="#" alt="" class="img-fluid" />
                              </div>
                           </div>
                           <div class="col-10 ">
                              <div class="row">
                                 <div class="col-12">
                                    <fieldset class="scheduler-border englishLanguage">
                                       <legend class="scheduler-border ">General info</legend>
                                       <div class="row">

                                          {{-- photo --}}
                                          <div class="form-group col-4">
                                             <label for="">Upload Menu photo</label>
                                             <div class="custom-file ">
                                                <input type="file" class="custom-file-input" id="customFile" name="photo">
                                                <label class="custom-file-label" for="photo">Upload
                                                Menu
                                                photo</label>
                                                <small id="photo_error"></small>
                                             </div>
                                          </div>

                                          {{-- is visible --}}
                                          <div class="form-group col-4">
                                             <label for="">menu visibility</label>
                                             <select class="form-control" name="is_visible">
                                             <option value="1" @if($menu->is_visible == 1)
                                             selected @endif>visible</option>
                                             <option value="0" @if($menu->is_visible == 0)
                                             selected @endif>Not visible</option>
                                             </select>
                                             <small id="is_visible_error"></small>
                                          </div>

                                          {{-- sort number --}}
                                          <div class="form-group col-4">
                                             <label for="">Menu Sort Number</label>
                                             <input class="form-control" type="number" id="sort_no" name="sort_no" value="{{ $menu->sort_no }}">
                                             <small id="sort_no_error"></small>
                                          </div>

                                          {{-- restaurant id--}}
                                          <div class="form-group col-4">
                                             <label for="">Restaurant</label>
                                             <input class="form-control" name="sort_no" value="@if($menu->restaurant->language == 2) {{ $menu->restaurant->name_ar }} @else {{ $menu->restaurant->name }} @endif" disabled>
                                             <select class="form-control" name="restaurant_id" hidden>
                                                <option value="{{ $menu->restaurant->id }}" selected>
                                                   {{ $menu->restaurant->name }}
                                                </option>
                                             </select>
                                             <small id="is_visible_error"></small>
                                          </div>
                                       </div>
                                    </fieldset>
                                 </div>

                                 {{-- english info --}}
                                 @if ( $menu->restaurant->language == 0 || $menu->restaurant->language == 1)
                                 <div class="col-12 englishLanguage mt-4">
                                    <fieldset class="scheduler-border englishLanguage">
                                       <legend class="scheduler-border ">English info</legend>
                                       <div class="row">

                                          {{-- name --}}
                                          <div class="form-group col-6 englishLanguage">
                                             <input class="form-control" type="text" value="{{ $menu->name }}" name="name" placeholder="menu name">
                                             <small id="name_error"></small>
                                          </div>

                                          {{-- description --}}
                                          <div class="form-group col-6 englishLanguage">
                                             <input class="form-control" type="text" value="{{ $menu->description }}" name="description" placeholder="menu description">
                                             <small id="description_error"></small>
                                          </div>
                                       </div>
                                    </fieldset>
                                 </div>
                                 @endif

                                 {{-- arabic  info --}}
                                 @if ( $menu->restaurant->language == 0 || $menu->restaurant->language == 2)
                                 <div class="col-12 arabicLanguage mt-4">
                                    <fieldset class="scheduler-border arabicLanguage">
                                       <legend class="scheduler-border ">Arabic info</legend>
                                       <div class="row">

                                          {{-- وصف المنيو --}}
                                          <div class="form-group col-6 arabicLanguage">
                                             <input class="form-control" type="text" required value="{{ $menu->description_ar }}" placeholder="وصف القائمة" name="description_ar" style="direction: rtl">
                                             <small id="description_ar_error"></small>
                                          </div>

                                          {{-- اسم المنيو --}}
                                          <div class="form-group col-6 arabicLanguage">
                                             <input class="form-control" required type="text" value="{{ $menu->name_ar }}" placeholder="أسم القائمة" name="name_ar" style="direction: rtl">
                                             <small id="name_ar_error"></small>
                                          </div>
                                       </div>
                                    </fieldset>
                                 </div>
                                 @endif
                              </div>
                           </div>
                        </div>
                     </section>
                  </div>

                  {{-- add button --}}
                  <div class="col-12 text-right mt-4">
                     <button id="updateMenuButton" class="btn btn-primary waves-light waves-effect w-md  " type="submit">Update Menu</button>
                  </div>

               </form>
            </div>
         </div>
      </div>
      @endforeach
   </div>
</div>
</div>
@endsection





@section("scripts")
<script>

// ======== updating menu information =========== //


    $('#updateMenuButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#name_error').text('');
        $('#name_ar_error').text('');
        $('#description_error').text('');
        $('#description_ar_error').text('');
        $('#photo_error').text('');
        $('#is_visible_error').text('');
        $('#sort_no_error').text('');
        $('#restaurant_id_error').text('');

        var formData = new FormData($('#editMenuForm')[0]);


        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateMenu" , $menu->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Menu edited Successfully", "", "success")
                    .then(() => {
                        window.location = "{{ url('/menu') }}";
                    });


            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to edit Menu", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });

</script>

@endsection

