{{-- extend layout --}}
@extends('layouts.layout')
 @foreach($restaurants as $restaurant)
@section('styles')
<style>
    fieldset div {
        margin: 10px 0px;
    }

</style>
@endsection

{{-- title --}}
@section('title') {{$restaurant->name}} information @endsection

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item"><a href="{{ route('restaurants') }}"> Restaurants list </a></li>
<li class="breadcrumb-item active"><a href="{{ route('showRestaurant' , $restaurant->id) }}">
        @if($restaurant->language == 2) {{ $restaurant->name_ar }} @else {{ $restaurant->name }} @endif</a>
</li>
@endsection

{{-- CONTENT SECTION --}}
 @section('content')
<div class="col-12">
    <p class="text-right">
        <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            Add New Menu
        </button>
        <a href="{{route("editRestaurant" , $restaurant->id)}}" type="button" name="button" class="btn btn-primary waves-light waves-effect w-md">Edit restaurant</a>
    </p>

    {{-- add new menu div --}}
    <div class="collapse " id="collapseExample">
        <div class="card">
            <div class="card-header font-bold">
                <h5>Add new Menu</h5>
            </div>
            <div class="card-body ">
                <form class="form-horizontal" id="addNewMenuInsideRestaurantForm" action="{{route('createMenu')}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- hidden language and restaurant id input --}}
                    <input type="text" id=" " value="{{ $restaurant->language }}" name="language" hidden>
                    <input type="text" id=" " value="{{ $restaurant->id }}" name="restaurant_id" hidden>
                    <div class="row">
                        <div class="col-2 ">
                            <div class="form-group mt-3">
                                <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/menuPhoto/placeholder.png')}}" />
                                <img data-toggle="modal" data-target=".bd-example-modal-lg" id="blah" src="#" alt="" class="img-fluid" />
                            </div>
                        </div>
                        <div class="col-10 ">
                            <div class="row">

                                <div class="col-12">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border ">General info</legend>
                                        <div class="row">
                                            <div class="form-group col-4">
                                                <label>Upload Menu photo</label>
                                                <div class="custom-file ">
                                                    <input type="file" class="custom-file-input" id="customFile" name="photo">
                                                    <label class="custom-file-label" for="photo">Upload Menu
                                                        photo</label>
                                                    <small id="photo_error"></small>
                                                </div>
                                            </div>

                                            {{-- is visible --}}
                                            <div class="form-group col-4">
                                                <label class="mb-3">Menu visibility </label>
                                                <select class="form-control" name="is_visible">
                                                    <option value="1" selected>visible</option>
                                                    <option value="0">Not visible</option>
                                                </select>
                                                <small id="is_visible_error"></small>
                                            </div>

                                            {{-- sort number --}}
                                            <div class="form-group col-4">
                                                <label class="mb-3">Menu Sort Number</label>
                                                <input class="form-control" type="number" id="sort_no" required name="sort_no">
                                                <small id="sort_no_error"></small>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>

                                {{-- English info --}}
                                @if($restaurant->language == 0 || $restaurant->language == 1)
                                <div class="col-12 englishLanguage mt-4">
                                    <fieldset class="scheduler-border englishLanguage">
                                        <legend class="scheduler-border ">English info</legend>
                                        <div class="row">

                                            {{-- name --}}
                                            <div class="form-group col-6 englishLanguage">
                                                <input class="form-control" type="text" name="name" placeholder="Menu name">
                                                <small id="name_error"></small>
                                            </div>

                                            {{-- description --}}
                                            <div class="form-group col-6 englishLanguage">
                                                <input class="form-control" type="text" name="description" placeholder="Menu description">
                                                <small id="description_error"></small>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                @endif

                                {{-- arabic info --}}
                                @if($restaurant->language == 0 || $restaurant->language == 2)
                                <div class="col-12 arabicLanguage mt-4">
                                    <fieldset class="scheduler-border arabicLanguage">
                                        <legend class="scheduler-border ">Arabic info</legend>
                                        <div class="row">

                                            {{-- وصف المنيو --}}
                                            <div class="form-group col-6 arabicLanguage">
                                                <input class="form-control" type="text" required placeholder="وصف المنيو" name="description_ar" style="direction: rtl">
                                                <small id="description_ar_error"></small>
                                            </div>

                                            {{-- اسم المنيو --}}
                                            <div class="form-group col-6 arabicLanguage">
                                                <input class="form-control" type="text" placeholder="أسم المنيو" name="name_ar" style="direction: rtl">
                                                <small id="name_ar_error"></small>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                                @endif

                                {{-- restaurant categories --}}
                                <div class="col-6 mt-4 ">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border ">Add Categories to this menu</legend>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">optional *</label>
                                            <select multiple class="form-control" id="restaurantCategories" name="category_id[]">
                                                @if(count($restaurant->categories) > 0)
                                                @foreach ($restaurant->categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                                @else
                                                <option disabled style="background-color: red; color:white">no categories found</option>
                                                @endif
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>

                                {{-- restaurant brches --}}
                                <div class="col-6 mt-4">
                                    <fieldset class="scheduler-border">
                                        <legend class="scheduler-border ">Add branches to this menu</legend>
                                        <div class="form-group">
                                            <label for="exampleFormControlSelect2">optional *</label>
                                            <select multiple class="form-control" id="restaurantBranches" name="branch_id[]">
                                                @if(count($restaurant->branches) > 0)
                                                @foreach ($restaurant->branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->branch_address }}</option>
                                                @endforeach
                                                @else
                                                <option disabled style="background-color: red; color:white">no branches found</option>
                                                @endif
                                            </select>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- add new menu button --}}
                    <div class="text-right mt-3">
                        <button id="addNewMenuInsideRestaurant" class="btn btn-primary waves-light waves-effect w-md" type="submit">Add
                            Menu</button>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>

    {{-- RESTAURANT information --}}
    <div class="card">
        <div class="card-header">
            <h5>{{ $restaurant->name }} information</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-2">
                    @if (strlen($restaurant->logo) > 2 )
                    <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/restauranLogo').'/'.$restaurant->logo}}" alt="profile" class="hvr-grow img-fluid">
                    @else
                    <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/restauranLogo/food-placeholder.png')}}" alt="profile" class="hvr-grow mx-2 img-fluid">
                    @endif
                </div>
                <div class="col-4">

                    {{-- general info --}}
                    <fieldset>
                        <legend>General info</legend>
                        <div><span class="font-bold">Website :</span> {{$restaurant->website}}</div>
                        <div><span class="font-bold">Theme :</span> {{ $restaurant->theme  }} </div>
                        <div><span class="font-bold">Phone :</span> {{$restaurant->phone_number}}</div>
                        <div><span class="font-bold">Moderator :</span> <a href="{{route('showModerators' , $restaurant->user->id)}}">{{$restaurant->user->name}}</a>
                        </div>
                    </fieldset>
                </div>

                {{-- english info --}}
                @if($restaurant->language == 0 || $restaurant->language == 1)
                <div class="col-3">
                    <fieldset>
                        <legend>English info</legend>
                        <div><span class="font-bold">Restaurant name :</span> {{$restaurant->name}}</div>
                        <div><span class="font-bold">Type :</span> {{$restaurant->type}}</div>
                        <div><span class="font-bold">Address :</span> {{$restaurant->address}}</div>
                        <div><span class="font-bold">About :</span> {{$restaurant->description}}</div>
                    </fieldset>
                </div>
                @endif

                {{-- arabic info --}}
                @if($restaurant->language == 0 || $restaurant->language == 2)
                <div class="col-3">
                    <fieldset>
                        <legend>Arabic info</legend>
                        <div><span class="font-bold">Arabic name :</span> {{$restaurant->name_ar}}</div>
                        <div><span class="font-bold">Arabic type :</span> {{$restaurant->type_ar}}</div>
                        <div><span class="font-bold">Arabic address :</span> {{$restaurant->address_ar}}</div>
                        <div><span class="font-bold">Arabic about :</span> {{$restaurant->description_ar}}</div>
                    </fieldset>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
</div>

{{-- restaurant over view --}}
@if(count($restaurant->menus) > 0)
<div class="row mt-3">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5>Restaurat summary</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach (($restaurant->menus)->sortBy('sort_no') as $menu)
                    <div class="col-3">
                        <div class="card" style="max-height: 600px; overflow:auto">

                            {{-- menu --}}
                            <div class="card-header p-2">
                                <h6 class="mb-0">{{ $menu->sort_no }} : <a href="{{ route('showMenu' , $menu->id) }}">{{ $menu->name }}</a></h6>
                            </div>
                            <div class="card-body p-2">

                                {{-- categories --}}
                                @foreach(($menu->categories)->sortBy('sort_no') as $category)
                                <div class="alert alert-success p-1 mb-0">
                                    <span class="m-0 p-0 font-bold" style="color: black">
                                        {{ $category->sort_no }} : <a href="{{ route('showCategory' , $category->id) }}">{{ $category->name }}</a>
                                    </span>
                                </div>

                                {{-- items --}}
                                @foreach (($category->items)->sortBy('sort_no') as $item)
                                <span>{{ $item->sort_no }} : <a href="{{ route('showItem' , $item->id) }}"> {{ $item->name }} </a></span><br>
                                @endforeach
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif

{{-- menus --}}
<div class="row mt-3">
    <div class="col-6" style="border-left:1px solid #f1f1f1">
        <div class="card">
            <div class="card-header">
                <h5>{{ count($restaurant->menus) }} {{ $restaurant->name }} Menus </h5>
            </div>
            <div class="card-body">
                <div id="menusDiv">
                    @if(count($restaurant->menus) > 0)
                    <table class="table table-bordered table-sm text-center">
                        <thead>
                            <tr>
                                <th>photo</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Visibility</th>
                                <th style="width:120px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($restaurant->menus as $menu)
                            <tr>
                                <td>
                                     <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/menuPhoto').'/'.$menu->photo}}" alt="profile" height="50px" class="hvr-grow">
                                </td>
                                {{-- menu name --}}
                                <td>   <a href="{{route('showMenu' , $menu->id)}}"> {{ $menu->name }}</a>  </td>

                                {{-- description --}}
                                <td> {{ $menu->description }} </td>

                                {{-- menu vis --}}
                                @if ($menu->is_visible == 1)
                                <td> <div class="badge badge-success">visible</div> </td>
                                @else
                                <td><div class="badge badge-danger">Not visible</div></td>
                                @endif

                                <td>
                                    <a href="{{ route('editMenu' , $menu->id) }}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Edit menu" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                                     <button id="deleteMenuInsideRestaurant" menu_id="{{ route('deleteMenu' , $menu->id) }}" data-toggle="tooltip" data-placement="top" title="Delete menu" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else

                    {{-- if no menus --}}
                    <div>
                        <div class="alert alert-danger font-bold font-16">Oops , it seems there is no menus at
                            {{ $restaurant->name }} yet ..
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Branches --}}
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h5 class="">{{ count($restaurant->branches) }} {{ $restaurant->name }} Branches</h5>
            </div>
            <div class="card-body">
                @if(count($restaurant->branches) > 0)
                <table class="table table-bordered table-sm text-center">
                    <thead>
                        <tr>
                            <th>Branch address</th>
                            <th>Branch address in arabic</th>
                            <th>Delete branch</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($restaurant->branches as $branch)
                        <tr>
                            <td>{{ $branch->branch_address }}</td>
                            <td>{{ $branch->branch_address_ar }}</td>
                            <td>
                                <button id="deleteBranchInsideRestaurant" branch_id="{{ route('deleteBranch' , $branch->id)  }}" data-toggle="tooltip" data-placement="top" title="Delete branch" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-danger">
                    No branches for this restaurant yet
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
@endforeach




@section('scripts')
<script>
    // ============================================== //
    // ==== start adding new menu from restaurant==== //
    // ============================================== //

    $('#addNewMenuInsideRestaurant').on('click', function(e) {
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


        var formData = new FormData($('#addNewMenuInsideRestaurantForm')[0]);

        console.log(formData)
        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: "{{route('createMenu')}}"
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Menu Added successfully!", "", "success")
                    .then(() => {
                        $("#menusDiv").load(location.href + " #menusDiv");
                    });


            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add Menu", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });


    // ============================================== //
    // ==== deleting new menu from restaurant ======= //
    // ============================================== //

    $(document).on('click', "#deleteMenuInsideRestaurant", function(e) {


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
                    var menuID = $(this).attr('menu_id');
                    $.ajax({
                        type: 'delete'
                        , url: menuID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Menu Deleted successfully!", "", "success")
                                .then(() => {
                                    $("#menusDiv").load(location.href + " #menusDiv");

                                });
                            return
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to delete Menu", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Menu still exists!");
                }
            });
    });


    // ============================================== //
    // ==== deleting branch from restaurant ========= //
    // ============================================== //

    $(document).on('click', "#deleteBranchInsideRestaurant", function(e) {


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
                    var BranchID = $(this).attr('branch_id');
                    $.ajax({
                        type: 'delete'
                        , url: BranchID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Branch Deleted successfully!", "", "success")
                                .then(() => {

                                    location.reload()
                                });
                            return
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to delete Branch", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Branch still exists!");
                }
            });
    });

</script>

@endsection
