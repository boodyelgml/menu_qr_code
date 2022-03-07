@extends('layouts.layout')
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('categories') }}"> Categories list </a></li>
@endsection
@section('content')

{{-- add new Category --}}
<div class="col-12 ">
    <p class="text-right">
        <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            <i class="mdi mdi-food-fork-drink"></i> Add New Category
        </button>
    </p>
    <div class="collapse " id="collapseExample" style="">
        <div class="card">
            <div class="card-header font-bold">
                <h5>Add new Category</h5>
            </div>
            <div class="card-body ">
                <form class="form-horizontal" id="addNewCategoryForm" action="" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        {{-- restaurant id --}}
                        <div class="form-group col-4">
                            <label for="">Choose Restaurant </label>
                            <select class="form-control" name="restaurant_id" id="RestaurantInsideAddCategory">
                                <option value="" disabled selected>Select restaurant </option>
                                @foreach($restaurants as $restaurant)

                                {{-- super admin --}}
                                @if(Auth::user()->role == 1)
                                <option language="{{$restaurant->language}}" value="{{$restaurant->id}}">
                                    @if($restaurant->language == 2)
                                    {{$restaurant->name_ar}}
                                    @else
                                    {{$restaurant->name}}
                                    @endif
                                </option>

                                {{-- moderator --}}
                                @elseif(Auth::user()->role == 2)
                                @if($restaurant->user_id == Auth::user()->id)
                                <option language="{{$restaurant->language}}" value="{{$restaurant->id}}">
                                    @if($restaurant->language == 2)
                                    {{$restaurant->name_ar}}
                                    @else
                                    {{$restaurant->name}}
                                    @endif
                                </option>
                                @endif
                                @endif
                                @endforeach
                            </select>
                            <small id="restaurant_id_error"></small>
                        </div>

                        {{-- hidden language input --}}
                        <input type="text" id="restaurantLanguage" value="" name="language" hidden>

                        {{-- add menu --}}
                        <section id="addMenuAfterChooseRestaurant" class="d-none col-12">
                            <div class="row">

                                {{-- menu photo --}}
                                <div class="col-2 ">

                                    {{-- photo --}}
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

                                            {{-- general info --}}
                                            <fieldset class="scheduler-border ">
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
                                                        <label for="">Is category visible !</label>
                                                        <select class="form-control" name="is_visible">
                                                            <option value="1" selected>visible</option>
                                                            <option value="0">Not visible</option>
                                                        </select>
                                                        <small id="is_visible_error"></small>
                                                    </div>

                                                    {{-- sort number --}}
                                                    <div class="form-group col-4">
                                                        <label for="">category Sort Number</label>
                                                        <input class="form-control" type="number" id="sort_no" name="sort_no">
                                                        <small id="sort_no_error"></small>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        {{-- english info --}}
                                        <div class="col-12 englishLanguage mt-4">
                                            <fieldset class="scheduler-border englishLanguage">
                                                <legend class="scheduler-border ">English info</legend>
                                                <div class="row">

                                                    {{-- name --}}
                                                    <div class="form-group col-6 englishLanguage">
                                                        <input class="form-control" type="text" name="name" placeholder="category name">
                                                        <small id="name_error"></small>
                                                    </div>

                                                    {{-- description --}}
                                                    <div class="form-group col-6 englishLanguage">
                                                        <input class="form-control" type="text" name="description" placeholder="Category description">
                                                        <small id="description_error"></small>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        {{-- arabic info --}}
                                        <div class="col-12 arabicLanguage mt-4">
                                            <fieldset class="scheduler-border arabicLanguage">
                                                <legend class="scheduler-border ">Arabic info</legend>
                                                <div class="row">

                                                    {{-- وصف القسم --}}
                                                    <div class="form-group col-6 arabicLanguage">
                                                        <input class="form-control" type="text" placeholder="وصف  القسم" name="description_ar" style="direction: rtl">
                                                        <small id="description_ar_error"></small>
                                                    </div>

                                                    {{-- اسم القسم --}}
                                                    <div class="form-group col-6 arabicLanguage">
                                                        <input class="form-control" type="text" placeholder="أسم القسم" name="name_ar" style="direction: rtl">
                                                        <small id="name_ar_error"></small>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        {{-- choose menu --}}
                                        <div class="col-6 mt-4">
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border ">Choose menus</legend>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">optional *</label>
                                                    <select multiple class="form-control" id="restaurantMenus" name="menu_id[]">
                                                    </select>
                                                </div>
                                            </fieldset>
                                        </div>

                                        {{-- choose items --}}
                                        <div class="col-6 mt-4">
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border ">Choose items</legend>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">optional *</label>
                                                    <select multiple class="form-control" id="restaurantItems" name="item_id[]">
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
                    <div class="text-right ">
                        <button id="addNewCategoryButton" class="btn btn-primary waves-light waves-effect w-md mt-3" type="submit">Add
                            Category</button>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>

    {{-- All Categories list --}}
    <div class="card" id="categoriesDiv">
        <div class="card-header font-bold">
            <h5>Categories List</h5>
        </div>
        <div class="card-body">
            @if(count($categories) > 0)
            <table id="categoriesTable" class="table  text-center table-bordered  table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th style="width: 100px">photo</th>
                        <th>Category name</th>
                        <th>Description</th>
                        <th>Visibility</th>
                        <th> Sort Number</th>
                        <th>Restaurant</th>
                        <th>Menus</th>
                        <th>Items</th>
                        <th>Created at</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)

                    {{-- super admin --}}
                    <tr>

                        {{-- photo --}}
                        <td>
                            <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/categoryPhoto').'/'.$category->photo}}" alt="profile" height="50px" class="hvr-grow">
                        </td>

                        {{-- Name --}}
                        <td> {{$category->name}} </td>

                        {{-- description --}}
                        <td> {{$category->description}} </td>

                        {{-- is visible --}}
                        <td>
                            @if ($category->is_visible == 1)
                            <span class="badge badge-success">Visible</span>
                            @else
                            <span class="badge badge-danger">Not visible</span>
                            @endif
                        </td>

                        {{-- sort id --}}
                        <td>{{$category->sort_no}}</td>

                        {{-- Restaurants --}}
                        <td> {{$category->restaurant->name}} </td>

                        {{-- category menu --}}
                        <td>
                            @if (count($category->menus) >= 1)
                            @foreach ($category->menus as $menu)
                            <a href="{{ route('showMenu', $menu->id)}} ">{{$menu->name}} </a><br>
                            @endforeach
                            @else
                            &nbsp; <span class="badge badge-pill badge-secondary">no menus added yet</span>
                            @endif
                        </td>

                        {{-- category items --}}
                        <td>
                            @if (count($category->items) >= 1)
                            @foreach ($category->items as $item)
                            <a href="  {{ route('showItem', $item->id)}}">{{$item->name}}</a> <br>
                            @endforeach
                            @else
                            &nbsp; <span class="badge badge-pill badge-secondary">no items added yet</span>
                            @endif
                        </td>

                        {{-- created at --}}
                        <td>{{$category->created_at->format('d F Y, h:i A')}}</td>

                        {{-- Action buttons --}}
                        <td>
                             <a href="{{route('showCategory', $category->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Show category" class="btn btn-icon waves-effect waves-light btn-success"><i class="dripicons-enter"></i></a>
                             <a href="{{route('editCategory', $category->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Edit category" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                            <button id="deleteCategoryButton" category_id="{{route('deleteCategory' , $category->id)}}" data-toggle="tooltip" data-placement="top" title="Delete category" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
                <tfoot>
                    <th style="width: 100px">photo</th>
                    <th>Category name</th>
                    <th>Description</th>
                    <th>Visibility</th>
                    <th> Sort Number</th>
                    <th>Restaurant</th>
                    <th>Menus</th>
                    <th>Items</th>
                    <th>Created at</th>
                    <th style="width: 150px">Actions</th>
                </tfoot>
            </table>
            @else
            <div class="alert alert-danger">
                No categories found
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


{{-- start script section  --}}
@section("scripts")
<script>
    // ===================================================== //
    // ==== get items and menus when choose restaurant ======//
    // ===================================================== //

    //get items

    function getItemsInsideCategories() {

        $('#restaurantItems').empty();

        var restaurantID = $('#RestaurantInsideAddCategory').val();

        $.ajax({
            url: '{{route("getItemsInsideCategories")}}'
            , method: 'get'
            , data: {
                restaurantID
            }
            , success: response => {

                if (response) {

                    var items = response.items;

                    // insert items to dom
                    items.forEach(item => {

                        var node = $(`<option style="border-bottom:1px solid #f1f1f1;" value="${item.id}">${item.name == null ? item.name_ar : item.name}</option>`);
                        $('#restaurantItems').append(node);
                    });

                }
                if ($('#restaurantItems > option').length == 0) {
                    var node = $(`<option disabled style="background:red; color:white">No Items at this restaurant</option>`);
                    $('#restaurantItems').append(node);
                }
            }
        });
    }

    // ================ get menus ================ //
    function GetMenusInsideCategories() {
        $('#restaurantMenus').empty();
        var restaurantID = $('#RestaurantInsideAddCategory').val();
        $.ajax({
            url: '{{route("GetMenusInsideCategories")}}'
            , method: 'get'
            , data: {
                restaurantID
            }
            , success: response => {
                if (response) {
                    var menus = response.menus;
                    // insert menus to dom
                    menus.forEach(menu => {
                        var node = $(`<option style="border-bottom:1px solid #f1f1f1;" value="${menu.id}">${menu.name == null ? menu.name_ar : menu.name}</option>`);
                        $('#restaurantMenus').append(node);
                    });
                }
                if ($('#restaurantMenus > option').length == 0) {
                    var node = $(`<option disabled style="background:red; color:white">No Menus at this restaurant</option>`);
                    $('#restaurantMenus').append(node);
                }
            }
        });
    }


    // =================================================================== //
    //================ change language and get items & menus ============= //
    // =================================================================== //
    $("#RestaurantInsideAddCategory").change(function() {
        getItemsInsideCategories()
        GetMenusInsideCategories()
        var element = $(this).find('option:selected');
        var language = element.attr("language");
        $('#restaurantLanguage').val(language);
        englishArabic = 0, english = 1, arabic = 2
        if (language == englishArabic) {
            if ($('#addMenuAfterChooseRestaurant').hasClass('d-none')) {
                $('#addMenuAfterChooseRestaurant').removeClass('d-none');
            }
            if ($('.arabicLanguage').hasClass('d-none')) {
                $('.arabicLanguage').removeClass('d-none');
            }
            if ($('.englishLanguage').hasClass('d-none')) {
                $('.englishLanguage').removeClass('d-none');
            }
        } else if (language == english) {
            if ($('#addMenuAfterChooseRestaurant').hasClass('d-none')) {
                $('#addMenuAfterChooseRestaurant').removeClass('d-none');
            }
            if (!($('.arabicLanguage').hasClass('d-none'))) {
                $('.arabicLanguage').addClass('d-none');
            }
            if ($('.englishLanguage').hasClass('d-none')) {
                $('.englishLanguage').removeClass('d-none');
            }
        } else if (language == arabic) {
            if ($('#addMenuAfterChooseRestaurant').hasClass('d-none')) {
                $('#addMenuAfterChooseRestaurant').removeClass('d-none');
            }
            if ($('.arabicLanguage').hasClass('d-none')) {
                $('.arabicLanguage').removeClass('d-none');
            }
            if (!($('.englishLanguage').hasClass('d-none'))) {
                $('.englishLanguage').addClass('d-none');
            }
        }

    });


    // ===================================================== //
    //================ add new category by ajax ============ //
    // ===================================================== //

    $('#addNewCategoryButton').on('click', function(e) {
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

        var formData = new FormData($('#addNewCategoryForm')[0]);

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
                        $("#categoriesDiv").load(location.href + " #categoriesDiv", function() {
                            DatatableReInitial()
                        });
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add Category", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });

    // ===================================================== //
    //================ delete category by ajax ============= //
    // ===================================================== //

    $(document).on('click', "#deleteCategoryButton", function(e) {


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
                                    $("#categoriesDiv").load(location.href + " #categoriesDiv", function() {
                                        DatatableReInitial()
                                    });

                                });
                        }
                        , error: function(reject) {
                            swal("failed to remove Category", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Category still exists!");
                }

            });

    });


    // ========================================================= //
    // ================ Re initialize datatable ================ //
    // ========================================================= //

    function DatatableReInitial() {

        $('#categoriesTable').DataTable({
            "order": [
                [7, "desc"]
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
        $('tfoot tr th:nth-of-type(3) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(4) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(5) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(8) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(9) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(7) select').addClass('d-none')
        $('tfoot').each(function() {
            $(this).insertAfter($(this).siblings('thead'));
        });
    }

    // ========================================================= //
    // ================ When document is ready  ================ //
    // ========================================================= //

    $(document).ready(function() {
        DatatableReInitial()
    })

</script>

@endsection
