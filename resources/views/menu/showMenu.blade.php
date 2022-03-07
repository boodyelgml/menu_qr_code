{{-- layout --}}
@extends('layouts.layout')

{{-- style section --}}
@section('styles')
<style>
   .menuInfo h6 {
   margin-top: 12px
   }
   #png-container img {
   height: 200px;
   }
   svg {
   height: 100px;
   width: 100px;
   }
   .QrDiv img{
   width: 180px !important;
   }
</style>
@endsection

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item"><a href="{{ route('menus') }}"> Menus list </a></li>
<li class="breadcrumb-item active"><a href="{{ route('showMenu' , $menus[0]->id) }}">
   @if($menus[0]->restaurant->language == 2)
   {{ $menus[0]->name_ar }}
   @else
   {{ $menus[0]->name }}
   @endif
   </a>
</li>
@endsection

{{-- content --}}
@section('content')
@foreach ($menus as $menu)

{{-- edit and add button --}}
<div class="text-right col-12 mb-3">

   {{-- add category --}}
   <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
   Add New Category
   </button>

   {{-- edit menu button --}}
   <a href="{{route("editMenu" , $menu->id)}}" type="button" name="button" class="btn btn-primary waves-light waves-effect w-md">Edit menu</a>
</div>

{{-- start add new Category --}}
<div class="col-12 ">
   <div class="collapse " id="collapseExample">
      <div class="card">

         {{-- CARD HEADER --}}
         <div class="card-header font-bold">
            <h5>Add new Category</h5>
         </div>

         {{-- CARD BODY --}}
         <div class="card-body ">

            {{-- START ADD category form --}}
            <form class="form-horizontal" id="addCategoryInsideMenuForm" method="POST" enctype="multipart/form-data">
               @csrf

               {{-- restaurant id and language hidden inputs --}}
               <input type="text" name="restaurant_id" value="{{ $menu->restaurant->id }}" hidden>
               <input type="text" name="language" value="{{ $menu->restaurant->language }}" hidden>
               <input type="text" name="menu_id" value="{{ $menu->id}}" hidden>
               <div class="row">
                  <section id="addMenuAfterChooseRestaurant" class="col-12">
                     <div class="row">

                        {{-- category photo placholder --}}
                        <div class="col-2 ">
                           <div class="form-group mt-3">
                              {{-- placeholder --}}
                              <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/categoryPhoto/placeholder.png')}}" />
                              {{-- photo preview --}}
                              <img data-toggle="modal" data-target=".bd-example-modal-lg" id="blah" src="#" alt="" class="img-fluid" />
                           </div>
                        </div>
                        <div class="col-10 ">
                           <div class="row">
                              <div class="col-12">

                                 {{-- General info --}}
                                 <fieldset class="scheduler-border">
                                    <legend class="scheduler-border ">General info</legend>
                                    <div class="row">

                                       {{-- photo --}}
                                       <div class="form-group col-4">
                                          <label for="">Upload category photo</label>
                                          <div class="custom-file ">
                                             <input type="file" class="custom-file-input" id="customFile" name="photo">
                                             <label class="custom-file-label" for="photo">Upload category
                                             photo</label>
                                             <small id="photo_error"></small>
                                          </div>
                                       </div>

                                       {{-- is visible --}}
                                       <div class="form-group col-4">
                                          <label for="">category Visibility</label>
                                          <select class="form-control" name="is_visible">
                                             <option value="1" selected>visible</option>
                                             <option value="0">Not visible</option>
                                          </select>
                                          <small id="is_visible_error"></small>
                                       </div>

                                       {{-- sort number --}}
                                       <div class="form-group col-4">
                                          <label for="">category Sort Number</label>
                                          <input class="form-control" type="number" id="sort_no" placeholder=" Sort Number" name="sort_no">
                                          <small id="sort_no_error"></small>
                                       </div>
                                    </div>
                                 </fieldset>
                              </div>

                              {{-- english language --}}
                              @if($menu->restaurant->language == 0 || $menu->restaurant->language == 1)
                              <div class="col-12 englishLanguage mt-4">
                                 <fieldset class="scheduler-border englishLanguage">
                                    <legend class="scheduler-border ">English info</legend>
                                    <div class="row">

                                       {{-- name --}}
                                       <div class="form-group col-6 englishLanguage">
                                          <input class="form-control" required type="text" required="" name="name" placeholder="category name">
                                          <small id="name_error"></small>
                                       </div>

                                       {{-- description --}}
                                       <div class="form-group col-6 englishLanguage">
                                          <input class="form-control" type="text" required name="description" placeholder="category description">
                                          <small id="description_error"></small>
                                       </div>
                                    </div>
                                 </fieldset>
                              </div>
                              @endif

                              {{-- arabic language --}}
                              @if($menu->restaurant->language == 0 || $menu->restaurant->language == 2)
                              <div class="col-12 arabicLanguage mt-4">
                                 <fieldset class="scheduler-border arabicLanguage">
                                    <legend class="scheduler-border ">Arabic info</legend>
                                    <div class="row">

                                       {{-- وصف المنيو --}}
                                       <div class="form-group col-6 arabicLanguage">
                                          <input class="form-control" type="text" required placeholder="وصف  القسم" name="description_ar" style="direction: rtl">
                                          <small id="description_ar_error"></small>
                                       </div>

                                       {{-- اسم المنيو --}}
                                       <div class="form-group col-6 arabicLanguage">
                                          <input class="form-control" required type="text" placeholder="أسم القسم" name="name_ar" style="direction: rtl">
                                          <small id="name_ar_error"></small>
                                       </div>
                                    </div>
                                 </fieldset>
                              </div>
                              @endif

                              {{-- restaurant categories --}}
                              <div class="col-12 ">
                                 <fieldset class="scheduler-border mt-4">
                                    <legend class="scheduler-border ">Choose Items</legend>
                                    <div class="form-group">
                                       <label for="exampleFormControlSelect2">optional *</label>
                                       <select multiple class="form-control" id="restaurantCategories" name="item_id[]">
                                          @foreach ($menu->restaurant->items as $item)
                                          <option value="{{ $item->id }}">
                                             @if($item->restaurant->laguage == 2)
                                             {{ $item->name_ar }}
                                             @else
                                             {{ $item->name }}
                                             @endif
                                          </option>
                                          @endforeach
                                       </select>
                                    </div>
                                 </fieldset>
                              </div>
                           </div>
                        </div>
                     </div>
                  </section>
               </div>

               {{-- add button --}}
               <div class="text-right mt-2">
                  <button id="addCategoryInsideMenuButton" class="btn btn-primary waves-light waves-effect w-md mt-3" type="submit">Add
                  Category</button>
               </div>
            </form>
         </div>
      </div>
      <div style="color: #f1f1f1; margin-top:-10px;">.</div>
   </div>

   {{-- menu datail section --}}
   <div id="categoriesDiv">
      <div class="card">

         {{-- card header --}}
         <div class="card-header">
            <h5> {{$menu->name}} Information </h5>
         </div>

         {{-- card body --}}
         <div class="card-body p-4">
            <div class="menuInfo">
               <div class="row">

                  {{-- menu photo --}}
                  <div class="col-3">
                     {{-- if menu photo exist --}}
                      <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/menuPhoto').'/'.$menu->photo}}" alt="profile" height="60px" class="hvr-grow img-fluid">
                  </div>

                  {{-- menu information --}}
                  <div class="col-7">

                     {{-- english info --}}
                     @if($menu->restaurant->language == 0 || $menu->restaurant->language == 1)
                     <h6><span class="font-bold">Name :</span> {{$menu->name}}</h6>
                     <h6><span class="font-bold"> Description :</span> {{$menu->description}}</h6>
                     @endif

                     {{-- arabic info --}}
                     @if($menu->restaurant->language == 0 || $menu->restaurant->language == 2)
                     <h6><span class="font-bold">Arabic name :</span> {{$menu->name_ar}}</h6>
                     <h6><span class="font-bold">Arabic description :</span> {{$menu->description_ar}}</h6>
                     @endif

                     {{-- is visible --}}
                     <h6> <span class="font-bold">visibility :</span> @if($menu->is_visible == 1)
                        <div class="badge badge-success"> visible </div>
                        @else
                         <div class="badge badge-danger"> Not visible </div>@endif
                     </h6>

                     {{-- restaurant name --}}
                     <h6><span class="font-bold">Restaurant : </span><a href="{{route('showRestaurant' , $menu->restaurant->id)}}">
                        {{$menu->restaurant->name}}
                        </a>
                     </h6>
                  </div>

                  {{-- Qr --}}
                  <div class="col-2 text-center">
                     <a class="mr-3"  href="{{ route('menuView' , $menu->id )}}">Preview menu</a>
                      <div class="QrDiv"   id="Menu{{ $menu->id }}"></div>
                  </div>

               </div>

                <script>
                  var qrcode = new QRCode(document.getElementById("Menu{{ $menu->id }}"), {
                      text: "{{ route('menuView' , $menu->id  ) }}"
                      , logo: "{{asset('assets/images/restauranLogo').'/'.$menu->restaurant->logo}}"
                      , logoWidth: 100
                      , logoHeight: 100
                      , logoBackgroundTransparent: true
                  , });
               </script>
            </div>
         </div>
      </div>
   </div>
   <br>
</div>
@if(count($menu->categories) > 0)

{{-- restaurant over view --}}

<div class="col-12 mb-3">
   <div class="card">
      <div class="card-header">
         <h5>Menu summary</h5>
      </div>
      <div class="card-body">
         <div class="row">
            @foreach(($menu->categories)->sortBy('sort_no') as $category)
            <div class="col-3 mt-2">
               <div class="card" style="max-height: 600px; overflow:auto">

                  {{-- menu --}}
                  <div class="card-header p-2">
                     <h6 class="mb-0">{{ $category->sort_no }} : <a href="{{ route('showCategory' , $category->id) }}">{{ $category->name }}</a></h6>
                  </div>
                  <div class="card-body p-2">

                     {{-- items --}}
                     @foreach (($category->items)->sortBy('sort_no') as $item)
                     <span>{{ $item->sort_no }} : <a href="{{ route('showItem' , $item->id) }}"> {{ $item->name }} </a></span><br>
                     @endforeach

                  </div>
               </div>
            </div>
            @endforeach
         </div>
      </div>
   </div>
</div>
@endif
<div class="col-12 " >
   <div class="card">
      <div class="card-header">
         <h5>Available ctegories</h5>
      </div>
      <div class="card-body">
         <div class="row">
            <div class="col-5" style="border-right: #f1f1f1 1px solid">

               {{-- add exist categories to the menu form --}}
                   <form id="addCat" name="addCat" method="POST" enctype="multipart/form-data">
                     @method('put')
                     <input type="text" value="{{ $menu->id }}" name="menu_id" hidden>
                     @if(count($menu->restaurant->categories) >= 1)
                     <select class="form-control" multiple name="category_id[]" id="">

                        @foreach ($menu->restaurant->categories as $category)
                        <option value="{{ $category->id }}">
                           {{ $category->name }}
                        </option>
                        @endforeach

                     </select>

                     {{-- add exist category to menu --}}
                     <div class="col-12 text-right mt-2 pr-0">
                        <button id="attachCategoryInsideMenu" data-toggle="tooltip" data-placement="top" title="Add category to this menu" class="btn btn-primary waves-light waves-effect py-2 "><i class="fa-plus-circle fa py-1"></i>
                        </button>
                     </div>
                     @else

                     {{-- if there is no categories --}}
                     <div class="alert alert-danger">
                        There is no Categories related to the Restaurant
                     </div>
                     @endif
                  </form>
             </div>

            <div class="col-7">
               @if(count($menu->categories) > 0)
               <table class="table table-bordered table-sm text-center">
                  <thead>
                     <tr>
                        <th>Category photo</th>
                        <th>Category name</th>
                        <th>Category Description</th>
                        <th>Sort Number</th>
                        <th>Actions</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($menu->categories as $category)
                     <tr>

                        {{-- photo --}}
                        <td>
                            <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/categoryPhoto').'/'.$category->photo}}" alt="profile" height="50px" class="hvr-grow mr-3">
                        </td>

                        {{-- name --}}
                        <td>
                           <a href="{{route('showCategory' , $category->id)}}"> {{$category->name}}</a>
                        </td>

                        {{-- description --}}
                        <td> {{$category->description}} </td>

                        {{-- sort number --}}
                        <td> {{$category->sort_no}}</td>

                        {{-- actions --}}
                        <td>
                            <a href="{{route('editCategory', $category->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Edit category" class="btn btn-icon waves-effect waves-light btn-primary mx-1"><i class="dripicons-gear"></i></a>
                            <button id="disAttachCategoryInsideMenuButton" category_id="{{route('disattachCategoryInsideMenu' , [$category->id , $menu->id])}}" data-toggle="tooltip" data-placement="top" title="Remove category from this menu" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="fa-minus-circle fa py-1"></i></button>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               @endif
            </div>
         </div>
      </div>
   </div>
   <br>
</div>
<div class="col-12">
   <div class="card">

      <div class="card-header">
         <h5>Available Branches</h5>
      </div>

      <div class="card-body">
         <div class="row">
            <div class="col-5" style="border-right:#f1f1f1 1px solid ">
               <form id="addBranch" name="addBranch" method="POST" enctype="multipart/form-data">
                  @method('put')
                  <input type="text" value="{{ $menu->id }}" name="menu_id" hidden>
                  @if(count($menu->restaurant->branches) >= 1)
                  <select class="form-control" multiple name="branch_id[]" id="">
                     @foreach ($menu->restaurant->branches as $branch)
                     <option value="{{ $branch->id }}">
                        {{ $branch->branch_address }}
                     </option>
                     @endforeach
                  </select>

                  {{-- add exist category to menu --}}
                  <div class="col-12 text-right mt-2 pr-0">
                     <button id="attachBranchInsideMenu" data-toggle="tooltip" data-placement="top" title="Add this menu to branch" class="btn btn-primary waves-light waves-effect py-2 "><i class="fa-plus-circle fa py-1"></i>
                     </button>
                  </div>
                  @else

                  {{-- if there is no categories --}}
                  <div class="col-12">
                     <div class="alert alert-danger">
                        There is no Branches related to the Restaurant
                     </div>
                  </div>
                  @endif
               </form>
            </div>

            {{-- branches --}}
            <div class="col-7">
               @if(count($menu->branches) >= 1)
               <table class="table table-bordered table-sm text-center">
                  <thead>
                     <tr>
                        <th>branch address</th>
                        <th>branch address in arabic</th>
                        <th>delete branch</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach ($menu->branches as $branch)
                     <tr>
                        <td>{{ $branch->branch_address }}</td>
                        <td>{{ $branch->branch_address_ar }}</td>
                        <td>
                           <button id="disattachbranchInsideMenu" branch_id="{{route('disattachbranchInsideMenu' ,[ $branch->id , $menu->id ])}}" data-toggle="tooltip" data-placement="top" title="Remove branch" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="fa-minus-circle fa py-1"></i></button>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
               @else
               <div class="alert alert-danger">No branches include this menu</div>
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
    $(document).ready(function() {
        $("svg").attr("width", "500");
        $("svg").attr("height", "500");
    })
    // ================================================================== //
    // =============== add new category inside this menu ================ //
    // ================================================================== //

    $('#addCategoryInsideMenuButton').on('click', function(e) {
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

        var formData = new FormData($('#addCategoryInsideMenuForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: ' {{route('createCategory')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Category Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add category", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });



    // ================================================================== //
    // ============== disattach   category inside this menu ================ //
    // ================================================================== //

    $(document).on('click', "#disAttachCategoryInsideMenuButton", function(e) {


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
                    var categoryID = $(this).attr('category_id');
                    $.ajax({
                        type: 'delete'
                        , url: categoryID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Category removed successfully !", "", "success")
                                .then(() => {
                                    location.reload();
                                });
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove Category", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Category still exists!");
                }

            });

    });

    // ================================================================== //
    // ============== attach   category inside this menu ================ //
    // ================================================================== //

    $('#attachCategoryInsideMenu').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();
        // Reset all errors

        var formData = new FormData($('#addCat')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: ' {{route('attachCategoryInsideMenu')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Category Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add category", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });


    // ================================================================== //
    // ============== attach   Branch inside this menu ================ //
    // ================================================================== //

    $('#attachBranchInsideMenu').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();
        // Reset all errors

        var formData = new FormData($('#addBranch')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: ' {{route('attachBranchInsideMenu')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Branch Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add Branch", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });

    // ================================================================== //
    // ============== disattach   Branch inside this menu ================ //
    // ================================================================== //

    $(document).on('click', "#disattachbranchInsideMenu", function(e) {


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
                    var branchID = $(this).attr('branch_id');
                    $.ajax({
                        type: 'delete'
                        , url: branchID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Branch removed successfully !", "", "success")
                                .then(() => {
                                    location.reload();
                                });
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove Branch", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Branch still exists!");
                }

            });

    });


    // ======================================================== //
    // =============== convert svg to png function ============ //
    // ======================================================== //

    $(document).on("click", 'svg', function() {
        var svgString = new XMLSerializer().serializeToString(this);

        var canvas = document.getElementById("canvas");
        var ctx = canvas.getContext("2d");
        var DOMURL = self.URL || self.webkitURL || self;
        var img = new Image();
        var svg = new Blob([svgString], {
            type: "image/svg+xml;charset=utf-8"
        });
        var url = DOMURL.createObjectURL(svg);
        img.onload = function() {
            ctx.drawImage(img, 0, 0);
            var png = canvas.toDataURL("image/png");
            document.querySelector('#png-container').innerHTML = '<img src="' + png + '"/>';
            $('#pngLink').attr("href", png);
            DOMURL.revokeObjectURL(png);
        };
        img.src = url;
    })

</script>
@endsection

