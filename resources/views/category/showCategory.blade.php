{{-- layout --}}
@extends('layouts.layout')
@section('styles')
<style>
   fieldset h6 {
   margin-top: 10px;
   }
</style>
@endsection

{{-- content --}}
@section('content')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item"><a href="{{ route('categories') }}"> Categories list </a></li>
<li class="breadcrumb-item active"><a href="{{ route('showCategory' , $categories[0]->id) }}">
   @if($categories[0]->restaurant->language == 2)
   {{ $categories[0]->name_ar }}
   @else
   {{ $categories[0]->name }}
   @endif
   </a>
</li>
@endsection
@foreach ($categories as $category)

{{-- start add new restaurant --}}
<div class="col-12 ">
   <p class="text-right">
      <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
      Add New Item
      </button>
      <a href="{{route("editCategory" , $category->id)}}" type="button" name="button" class="btn btn-primary waves-light waves-effect w-md">Edit Category</a>
   </p>
   <div class="collapse" id="collapseExample">
      <div class="card">
         <div class="card-header font-bold">
            <h5>Add new Item</h5>
         </div>
         <div class="card-body ">
            <form class="form-horizontal" id="addNewItemInsideCategoryForm" action="{{route('createItem')}}" method="POST" enctype="multipart/form-data">
               @csrf
               <div class="row">

                  {{-- hidden language and restaurant id input --}}
                  <input type="text" id="restaurantLanguageInput" value="{{ $category->restaurant->language }}" name="language" hidden>
                  <input type="text" id="" value="{{ $category->id }}" name="category_id" hidden>
                  <input type="text" id="" value="{{ $category->restaurant->id }}" name="restaurant_id" hidden>

                  {{-- add menu --}}
                  <section id="addMenuAfterChooseRestaurant" class="col-12">
                     <div class="row">
                        <div class="col-2 ">

                           {{-- photo --}}
                           <div class="form-group mt-3">

                              {{-- placeholder --}}
                              <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/itemPhoto/placeholder.png')}}" />

                              {{-- photo preview --}}
                              <img data-toggle="modal" data-target=".bd-example-modal-lg" id="blah" src="#" alt="" class="img-fluid" />
                           </div>
                        </div>
                        <div class="col-10 ">
                           <div class="row">
                              <div class="col-12">

                                 {{-- general info --}}
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
                                          <label for="">Item Visibility</label>
                                          <select class="form-control" name="is_visible">
                                             <option value="1" selected>visible</option>
                                             <option value="0">Not visible</option>
                                          </select>
                                          <small id="is_visible_error"></small>
                                       </div>

                                       {{-- sort number --}}
                                       <div class="form-group col-4">
                                          <label for="">item Sort Number</label>
                                          <input class="form-control" type="number" name="sort_no">
                                          <small id="sort_no_error"></small>
                                       </div>

                                       {{-- Price --}}
                                       <div class="form-group col-4">
                                          <label for="">Price</label>
                                          <input class="form-control" type="number" name="price">
                                          <small id="price_error"></small>
                                       </div>
                                    </div>
                                 </fieldset>
                              </div>

                              {{-- english info --}}
                              @if ($category->restaurant->language == 0 || $category->restaurant->language == 1)
                              <div class="col-12 englishLanguage mt-4">
                                 <fieldset class="scheduler-border englishLanguage">
                                    <legend class="scheduler-border ">English info</legend>
                                    <div class="row">

                                       {{-- name --}}
                                       <div class="form-group col-6 englishLanguage">
                                          <input class="form-control" type="text" name="name" placeholder="item name">
                                          <small id="name_error"></small>
                                       </div>

                                       {{-- description --}}
                                       <div class="form-group col-6 englishLanguage">
                                          <input class="form-control" type="text" name="description" placeholder="item description">
                                          <small id="description_error"></small>
                                       </div>
                                    </div>
                                 </fieldset>
                              </div>
                              @endif

                              {{-- arabic info --}}
                              @if ($category->restaurant->language == 0 || $category->restaurant->language == 2)
                              <div class="col-12 arabicLanguage mt-4">
                                 <fieldset class="scheduler-border arabicLanguage">
                                    <legend class="scheduler-border ">Arabic info</legend>
                                    <div class="row">

                                       {{-- وصف المنيو --}}
                                       <div class="form-group col-6 arabicLanguage">
                                          <input class="form-control" type="text" required placeholder="وصف الوجبة" name="description_ar" style="direction: rtl">
                                          <small id="description_ar_error"></small>
                                       </div>

                                       {{-- اسم المنيو --}}
                                       <div class="form-group col-6 arabicLanguage">
                                          <input class="form-control" required type="text" placeholder="أسم الوجبة" name="name_ar" style="direction: rtl">
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
               <div class="text-right">
                  <button id="addNewItemInsideCategoryButton" class="btn btn-primary waves-light waves-effect w-md mt-3" type="submit">Add
                  Item</button>
               </div>
            </form>
         </div>
      </div>
      <div style="color: #f1f1f1; margin-top:-10px;">.</div>
   </div>
</div>

{{-- show categories info --}}
<div class="col-12" id="categoriesDiv">
   <div class="card">

      <div class="card-header">
         <h5>   {{$category->name}} Information </h5>
      </div>

      <div class="card-body">
         <div class="menuInfo">
            <div class="row">

                {{-- photo --}}
               <div class="col-2">
                   <img data-toggle="modal" data-target=".bd-example-modal-lg" class="mr-3 img-fluid" src="{{asset('assets/images/categoryPhoto/') . '/' . $category->photo}}" alt="Generic placeholder image">
               </div>

               {{-- general info --}}
               <div class="col-4">
                <fieldset>
                   <legend>General info</legend>
                   <h6><span class="font-bold"> Sort Number :</span> {{$category->sort_no}}</h6>
                   <h6> <span class="font-bold">category visibility : @if($category->is_visible == 1)
                    <div class="badge badge-success"> visible</div>
                      @else
                      <div class="badge badge-danger"> Not visible</div>
                      @endif
                   </h6>
                   <h6><span class="font-bold">restaurant : </span>
                      <a href="{{ route('showRestaurant' , $category->restaurant->id) }}">
                      @if($category->restaurant->language == 2)
                      {{$category->restaurant->name_ar}}
                      @else
                      {{$category->restaurant->name}}
                      @endif
                      </a>
                   </h6>
                </fieldset>
             </div>

               {{-- english info --}}
               @if($category->restaurant->language== 0 || $category->restaurant->language== 1)
               <div class="col-3">
                  <fieldset>
                     <legend>English info</legend>
                     <h6><span class="font-bold">category name :</span> {{$category->name}}</h6>
                     <h6><span class="font-bold">category description :</span> {{$category->description}}
                     </h6>
                  </fieldset>
               </div>
               @endif

               {{-- arabic info --}}
               @if($category->restaurant->language== 0 || $category->restaurant->language== 2)
               <div class="col-3">
                  <fieldset>
                     <legend>Arabic info</legend>
                     <h6><span class="font-bold"> category name :</span> {{$category->name_ar}}
                     </h6>
                     <h6><span class="font-bold"> category description :</span>
                        {{$category->description_ar}}
                     </h6>
                  </fieldset>
               </div>
               @endif

            </div>
         </div>
      </div>
   </div>
</div>

{{-- =============== all restaurant menus ================= --}}
<div class="col-12 mt-3">
   <div class="card">
      <div class="card-header">
         <h5>Menus</h5>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-5" style="border-right: 1px solid #f1f1f1">
               <h6>Available menus</h6>
               <form action="post" id="attachMenuInsideCategoryForm">
                  @method('put')
                  <select name="menu_id[]" class="form-control" multiple>
                     @if(count($category->restaurant->menus) >= 1)

                     @foreach ($category->restaurant->menus as $menu)
                     <option value="{{ $menu->id }}">   {{ $menu->name }} </option>
                     @endforeach

                     @else
                     <option disabled style="background: red; color:white">no menus available</option>
                     @endif
                  </select>
                  <button type="button" name="button" id="attachMenuInsideCategoryButton" class="btn btn-primary waves-light waves-effect  float-right mt-2"><i class="fa-plus-circle fa py-1"></i></button>
               </form>
            </div>
            <div class="col-7">

               {{-- category menus table --}}
               <h6> Menus that have this menu</h6>
               @if(count($category->menus) >= 1)
               <table class="table table-bordered table-sm text-center">
                  <thead>
                     <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Sort Number</th>
                        <th>visibility</th>
                        <th style="width: 130px">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($category->menus as $menu)
                     <tr>
                          {{-- image --}}
                        <td> <img data-toggle="modal" data-target=".bd-example-modal-lg" class="mr-3" src="{{asset('assets/images/menuPhoto/') . '/' . $menu->photo}}" alt="Generic placeholder image" height="60px"> </td>


                        {{-- menu name --}}
                        <td>  {{ $menu->name }} </td>

                        {{-- menu description --}}
                        <td> {{ $menu->description }} </td>

                        {{-- menu  Sort Number --}}
                        <td> {{ $menu->sort_no }} </td>

                        {{-- menu visibility --}}
                        <td>@if ($menu->is_visible == 1)
                            <div class="badge badge-success">visible</div>
                            @else
                            <div class="badge badge-danger">not visible</div>
                        @endif
                        </td>

                        {{-- Actions --}}
                        <td>
                            <a href="{{ route('editMenu' , $menu->id) }}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Edit restaurant" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                           <button id="disattachMenuInsideCategoryButton" menu_id="{{ route('disattachMenuInsideCategory' , [$menu->id , $category->id])}}" data-toggle="tooltip" data-placement="top" title="remove restaurant" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="fa-minus-circle fa py-1"></i></button>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               @else
               <div class="alert-danger alert">This category not added to any menu</div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>

{{-- items list --}}
<div class="col-12 mt-3" id="ItemsDiv">
   <div class="card">

      <div class="card-header">
         <h5>Items</h5>
      </div>

      <div class="card-body">
         <div class="row">
            <div class="col-5" style="border-right: 1px solid #f1f1f1">

               <h6>Available items </h6>

               <form action="post" id="attachItemForm">
                  @method('put')
                  <select name="item_id[]" id="" class="form-control" multiple>
                     @if(count($category->restaurant->items) >= 1)

                     @foreach ($category->restaurant->items as $item)
                     <option value="{{ $item->id }}">{{ $item->name }}</option>
                     @endforeach

                     @else
                     <option disabled style="background: red; color:white">no items available</option>
                     @endif

                  </select>
                  <button type="button" name="button" id="attachItemButton" data-toggle="tooltip" data-placement="top" title=" add items to this category" class="btn btn-primary waves-light waves-effect py-2 float-right mt-2"><i class="fa-plus-circle fa py-1"></i></button>
               </form>

            </div>

            <div class="col-7">
               <h6>Items at this category:</h6>
               @if(count($category->items) >= 1)
               <table class="table table-bordered table-sm text-center">
                  <thead>
                     <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Price</th>
                        <th>Sort Number</th>
                        <th>visibility</th>
                        <th style="width: 130px">Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($category->items as $item)
                     <tr>

                        {{-- image --}}
                        <td> <img data-toggle="modal" data-target=".bd-example-modal-lg" class="mr-3" src="{{asset('assets/images/itemPhoto/') . '/' . $item->photo}}" alt="Generic placeholder image" height="60px"> </td>

                        {{-- item name --}}
                        <td>  {{ $item->name }}  </td>

                        {{-- description --}}
                        <td> {{ $item->description }} </td>

                        {{-- price --}}
                        <td> {{ $item->price }} </td>

                        {{-- sort no --}}
                        <td> {{ $item->sort_no }} </td>

                        {{-- vsibility --}}
                        <td>@if ($item->is_visible == 1)
                            <div class="badge badge-success">visible</div>
                            @else
                            <div class="badge badge-danger">not visible</div>
                        @endif
                        </td>


                        {{-- Actions --}}
                        <td>
                            <a href="{{ route('editItem' , $item->id) }}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="edit restaurant" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                           <button id="disattachItemInsideCategory" item_id="{{ route('disattachItemInsideCategory' , [$item->id , $category->id])}}" data-toggle="tooltip" data-placement="top" title="remove item" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="fa-minus-circle fa py-1"></i></button>
                        </td>

                     </tr>
                     @endforeach
                  </tbody>
               </table>
               @else
               <div class="alert alert-danger">no items added to this category</div>
               @endif
            </div>
         </div>
      </div>
   </div>
</div>
@endforeach
@endsection



@section("scripts")
<script>
//======= add new item inside category =========//


    $('#addNewItemInsideCategoryButton').on('click', function(e) {

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
        var formData = new FormData($('#addNewItemInsideCategoryForm')[0]);


        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route('createItem')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Item Added successfully!", "", "success")
                    .then(() => {
                        $("#ItemsDiv").load(location.href + " #ItemsDiv", function() {});
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add Item", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });


     //======= attach item inside category =========//

    $('#attachItemButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        var formData = new FormData($('#attachItemForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: "{{route('attachItemInsideCategory' , $category->id)}}"
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Item Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add Item", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });


     //======= disattach item inside category =========//

    $(document).on('click', "#disattachItemInsideCategory", function(e) {


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
                    var itemID = $(this).attr('item_id');
                    $.ajax({
                        type: 'delete'
                        , url: itemID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Item removed successfully!", "", "success")
                                .then(() => {
                                    location.reload();
                                });
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove Item", "please check errors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Item still exists!");
                }

            });

    });


     //======= attach menu inside category ==========//

    $('#attachMenuInsideCategoryButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        var formData = new FormData($('#attachMenuInsideCategoryForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: "{{route('attachMenuInsideCategory' , $category->id)}}"
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Category added successfully to the menu!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add category to this menu", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });



    //==== disattach menu inside category ==========//

    $(document).on('click', "#disattachMenuInsideCategoryButton", function(e) {


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
                    var itemID = $(this).attr('menu_id');
                    $.ajax({
                        type: 'delete'
                        , url: itemID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("category added to this Menu successfully!", "", "success")
                                .then(() => {
                                    location.reload();
                                });
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove category from this menu", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("category still exists inside this menu!");
                }

            });

    });

</script>
@endsection
