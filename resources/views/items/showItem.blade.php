{{-- layout --}}

@extends('layouts.layout')


{{-- content --}}
@section('content')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('menus') }}"> items list </a></li>
<li class="breadcrumb-item active"><a href="{{ route('showMenu' , $items[0]->id) }}"> @if($items[0]->restaurant->language == 2) {{ $items[0]->name_ar }} @else {{ $items[0]->name }} @endif </a></li>
@endsection

{{-- style --}}
@section('styles')
<style>
   .menuInfo h6 {
   margin-top: 20px
   }
</style>
@endsection
@foreach ($items as $item)
<div class="text-right col-12 mb-3">
   <a href="{{route("editItem" , $item->id)}}" type="button" name="button" class="btn btn-primary waves-light waves-effect w-md">Edit item</a>
</div>
<div class="col-12" id="categoriesDiv">
   <div class="card">

      <div class="card-header">
         <h5>
            {{$item->name}} Information
         </h5>
      </div>

      <div class="card-body">
         <div class="menuInfo" style="border-right:1px solid #f1f1f1">

            <div class="row">

               <div class="col-2">
                  <img data-toggle="modal" data-target=".bd-example-modal-lg"class="mr-3 img-fluid" src="{{asset('assets/images/itemPhoto/'). '/' . $item->photo}}" alt="Generic placeholder image">
               </div>

               <div class="col-4">

                  {{-- general info --}}
                  <fieldset>
                     <legend>General info</legend>
                     <h6> <span class="font-bold">Visibility : @if($item->is_visible == 1) <div class="badge badge-success"> visible </div>@else <div class="badge badge-danger">Not visible </div> @endif</h6>
                     <h6><span class="font-bold"> Price :</span> {{$item->price}} EGP</h6>
                     <h6><span class="font-bold"> Sort number :</span> {{$item->sort_no}} </h6>
                      <h6><span class="font-bold"> Restaurant :</span>
                        <a href="{{ route('showRestaurant' , $item->restaurant->id) }}"> {{$item->restaurant->name}}  </a>
                     </h6>
                  </fieldset>
                </div>

               {{-- english --}}
               @if($item->restaurant->language == 0 || $item->restaurant->language == 1)
               <div class="col-3">
                  <fieldset >
                     <legend>English info</legend>
                     <h6><span class="font-bold">English Name :</span> {{$item->name}}</h6>
                      <h6><span class="font-bold"> English Description :</span> {{$item->description}}</h6>
                  </fieldset>
                </div>
                @endif

               {{-- arabic --}}
               @if($item->restaurant->language == 0 || $item->restaurant->language == 2)
               <div class="col-3">
                  <fieldset >
                     <legend>Arabic info</legend>
                     <h6><span class="font-bold">Arabic Name :</span> {{$item->name}}</h6>
                     <h6><span class="font-bold"> Arabic Description :</span> {{$item->description}}</h6>
                  </fieldset>
                </div>
                @endif
            </div>

         </div>
      </div>
   </div>
</div>
</div>
<br>
<div class="card">
   <div class="card-header">
      <h5>
         Categories
      </h5>
   </div>
   <div class="card-body">
      <div class="row">
         <div class="col-4">

            {{-- available categories --}}
            <form id="addCat" name="addCat" method="POST" enctype="multipart/form-data">

               <input type="hidden" name="_method" value="put"> <input type="text" value="109" name="menu_id" hidden="">
               <h6>Available Categories</h6>

               <select class="form-control" multiple="" name="category_id[]" id="">

                  @if(count($item->restaurant->categories) >=1)

                  @foreach ($item->restaurant->categories as $category)
                  <option value="{{ $category->id }}"> {{ $category->name }} </option>
                  @endforeach

                  @else
                  <option disabled" style="background: red; color:white">No categories at this restaurant</option>
                  @endif

               </select>
               <div class="col-12 text-right mt-2 pr-0">
                  <button id="attachCategoryInsideItem" type="button" name="button" class="btn btn-primary waves-light waves-effect "><i class="fa-plus-circle fa py-1"></i></button>
               </div>
            </form>
         </div>

         {{-- category section --}}
         <div class="col-8">
            <h6>Categories that have this item</h6>
            <ul class="list-unstyled">
               @if(count($item->categories) > 0)
               @foreach($item->categories as $category)

               <li class="media pb-2" style="border-bottom: 1px solid #f1f1f1 ">
                  <img data-toggle="modal" data-target=".bd-example-modal-lg"class="hvr-grow  mr-3" src="{{asset('assets/images/categoryPhoto/'). '/' . $category->photo}}" height="60px" alt="Generic placeholder image">
                  <div class="media-body">

                     {{-- Name --}}
                     <h6 class="mt-0 mb-1"> <a href="{{route('showItem' , $item->id)}}">
                        <span class="d-block"> {{$category->name}} </span>
                         </a>
                     </h6>

                     {{-- Description --}}
                     <span class="d-block"> <b> Description : </b> {{$category->description}} </span>
                     <span class="d-block"> <b>  Sort Number : </b> {{$category->sort_no}} </span>
                  </div>

                  {{-- edit category button --}}
                  <a href="{{route('editCategory', $category->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="edit category" class="btn btn-icon waves-effect waves-light btn-primary mx-1"><i class="dripicons-gear"></i></a>

                  {{-- delete category button --}}
                  <button id="removeBtn" category_id="{{route('disattachCategoryInsideItem' , [$category->id , $item->id])}}" data-toggle="tooltip" data-placement="top" title="remove category" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="fa-minus-circle fa py-1"></i></button>
               </li>
               @endforeach
               @else
               <div class="alert alert-danger">
                  There is no Category this item assigned to.
               </div>
               @endif
            </ul>
         </div>
      </div>
   </div>
</div>
</div>
@endforeach
@endsection






@section("scripts")

<script>

    // {{-- start remove category_id ajax --}}

    $(document).on('click', "#removeBtn", function(e) {


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

                            swal("Category Deleted successfully!", "", "success")
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
                    swal("Category still exists!");
                }

            });

    });




    // {{-- start add categories ajax --}}

    $('#attachCategoryInsideItem').on('click', function(e) {

        e.preventDefault();
        // Reset all errors

        var formData = new FormData($('#addCat')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: ' {{route('attachCategoryInsideItem' , $item->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                swal("Category Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
                    });

            }
            , error: function(reject) {
                swal("failed to add category", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });

</script>
@endsection
