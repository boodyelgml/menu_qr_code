{{-- layout --}}

@extends('layouts.layout')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item"><a href="{{ route('items') }}"> Items list </a></li>
<li class="breadcrumb-item شؤفهرث"><a href="{{ route('editItem' , $items[0]->id) }}"> Edit @if($items[0]->restaurant->language == 2) {{ $items[0]->name_ar }} @else {{ $items[0]->name }} @endif </a></li>
@endsection

{{-- content --}}
@section('content')
<div class="col-12">
   <div class="card">
      <div class="card-header font-bold">
         <h5>Edit Item information</h5>
      </div>
      <div class="card-body">
         @foreach($items as $item)
         <div class="row">
            <form class="form-horizontal" id="editItemForm" method="POST" enctype="multipart/form-data">
               @csrf
               @method('PUT')

               {{-- hidden language input --}}
               <input type="text" id="restaurantLanguageInput" value="{{ $item->restaurant->language }}" name="language" hidden>
               <input type="text" id="restaurantLanguageInput" value="{{ $item->restaurant->id }}" name="restaurant_id" hidden>

               {{-- add menu --}}
               <section id="addMenuAfterChooseRestaurant" class="col-12">
                  <div class="row">
                     <div class="col-2 ">

                        {{-- photo --}}
                        <div class="form-group mt-3">

                           {{-- placeholder --}}
                           @if(strlen($item->photo) >= 2)
                           <img data-toggle="modal" data-target=".bd-example-modal-lg"class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/itemPhoto/') . '/' . $item->photo}}" />
                           @else
                           <img data-toggle="modal" data-target=".bd-example-modal-lg"class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/itemPhoto/placeholder.png')}}" />
                           @endif

                           {{-- photo preview --}}
                           <img data-toggle="modal" data-target=".bd-example-modal-lg"id="blah" src="#" alt="" class="img-fluid" />
                        </div>
                     </div>
                     <div class="col-10 ">
                        <div class="row">
                           <div class="col-12">

                              {{-- general item  info --}}
                              <fieldset class="scheduler-border">
                                 <legend class="scheduler-border ">General info</legend>
                                 <div class="row">

                                    {{-- photo --}}
                                    <div class="form-group col-4">
                                       <label for="">Upload item photo</label>
                                       <div class="custom-file ">
                                          <input type="file" class="custom-file-input" id="customFile" name="photo">
                                          <label class="custom-file-label" for="photo">Upload item
                                          photo</label>
                                          <small id="photo_error"></small>
                                       </div>
                                    </div>

                                    {{-- is visible --}}
                                    <div class="form-group col-4">
                                       <label for="">item visibility</label>
                                       <select class="form-control" name="is_visible">
                                       <option value="1" @if($item->is_visible == 1) selected
                                       @endif>visible</option>
                                       <option value="0" @if($item->is_visible == 0) selected
                                       @endif>Not visible</option>
                                       </select>
                                       <small id="is_visible_error"></small>
                                    </div>

                                    {{-- sort number --}}
                                    <div class="form-group col-4">
                                       <label for="">Sort Number</label>
                                       <input class="form-control" type="number" id="sort_no" required value="{{ $item->sort_no }}" name="sort_no">
                                       <small id="sort_no_error"></small>
                                    </div>

                                    {{-- Price --}}
                                    <div class="form-group col-4">
                                       <label for="">Price</label>
                                       <input class="form-control" type="number" id="sort_no" required value="{{ $item->price }}" name="price">
                                       <small id="price_error"></small>
                                    </div>
                                 </div>
                              </fieldset>
                           </div>

                           {{-- english item info --}}
                           @if ( $item->restaurant->language == 0 || $item->restaurant->language == 1)
                           <div class="col-12 englishLanguage mt-4">
                              <fieldset class="scheduler-border englishLanguage">
                                 <legend class="scheduler-border ">English info</legend>
                                 <div class="row">

                                    {{-- name --}}
                                    <div class="form-group col-6 englishLanguage">
                                       <input class="form-control" required type="text" required="" name="name" value="{{ $item->name }}" placeholder="item name">
                                       <small id="name_error"></small>
                                    </div>

                                    {{-- description --}}
                                    <div class="form-group col-6 englishLanguage">
                                       <input class="form-control" type="text" required name="description" value="{{ $item->description }}" placeholder="item description">
                                       <small id="description_error"></small>
                                    </div>
                                 </div>
                              </fieldset>
                           </div>
                           @endif

                           {{-- arabic item info --}}
                           @if ( $item->restaurant->language == 0 || $item->restaurant->language == 2)
                           <div class="col-12 arabicLanguage mt-4">
                              <fieldset class="scheduler-border arabicLanguage">
                                 <legend class="scheduler-border ">Arabic info</legend>
                                 <div class="row">

                                    {{-- وصف المنيو --}}
                                    <div class="form-group col-6 arabicLanguage">
                                    <input class="form-control" type="text" required value="{{ $item->description_ar }}" placeholder="وصف الوجبة" name="description_ar" style="direction: rtl">
                                    <small id="description_ar_error"></small>
                                    </div>

                                    {{-- اسم المنيو --}}
                                    <div class="form-group col-6 arabicLanguage">
                                       <input class="form-control" required type="text" value="{{ $item->name_ar }}" placeholder="أسم الوجبة" name="name_ar" style="direction: rtl">
                                       <small id="name_ar_error"></small>
                                    </div>
                                 </div>
                              </fieldset>
                           </div>
                           @endif
                        </div>
                     </div>
                  </div>

                  {{-- add button --}}
                  <div class="col-12 text-right mt-3">
                     <button id="updateItemButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Update Item</button>
                  </div>
               </section>
            </form>
         </div>
         @endforeach
      </div>
   </div>
</div>
@endsection




{{-- start script section  --}}
@section("scripts")
<script>

     //================  update items    ===================//

    $('#updateItemButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();
        // Reset all errors
        $('#name_error').text('');
        $('#name_ar_error').text('');
        $('#description_error').text('');
        $('#description_ar_error').text('');
        $('#photo_error').text('');
        $('#sort_no_error').text('');
        $('#is_visible_error').text('');
        $('#price_error').text('');
        $('#restaurant_id_error').text('');

        var formData = new FormData($('#editItemForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateItem" , $item->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Item updated successfully!", "", "success")
                    .then(() => {
                        window.location = "{{ url('/item') }}";
                    });
            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to update Item", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });

</script>

@endsection
