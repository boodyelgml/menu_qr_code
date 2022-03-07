@extends('layouts.layout')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('items') }}"> Items list </a></li>
@endsection

{{-- CONTENT SECTION --}}
@section('content')

{{-- add new restaurant --}}
<div class="col-12 ">
    <p class="text-right">
        <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            <i class="mdi mdi-food-fork-drink"></i> Add New Item
        </button>
    </p>

    {{--/////////// add Item form /////////--}}
    <div class="collapse" id="collapseExample">
        <div class="card">
            <div class="card-header font-bold">
                <h5>Add new Item</h5>
            </div>
            <div class="card-body ">
                <form class="form-horizontal" id="addNewItemForm" action="{{route('createItem')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        {{-- restaurant id --}}
                        <div class="form-group col-4">
                            <label for="">Choose Restaurant </label>
                            <select class="form-control" name="restaurant_id" id="chooseRestaurant">
                                <option value="" disabled selected>Select restaurant</option>
                                @foreach($restaurants as $restaurant)
                                <option language="{{$restaurant->language}}" value="{{$restaurant->id}}"> {{$restaurant->name}} </option>
                                @endforeach
                            </select>
                            <small id="restaurant_id_error"></small>
                        </div>

                        {{-- hidden language input --}}
                        <input type="text" id="restaurantLanguageInput" value="" name="language" hidden>

                        {{-- add menu form--}}
                        <section id="addMenuAfterChooseRestaurant" class="d-none col-12">
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
                                                            <label class="custom-file-label" for="photo">Upload item photo</label>
                                                            <small id="photo_error"></small>
                                                        </div>
                                                    </div>

                                                    {{-- is visible --}}
                                                    <div class="form-group col-4">
                                                        <label for="">item visibility</label>
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

                                        {{-- arabic info --}}
                                        <div class="col-12 arabicLanguage mt-4">
                                            <fieldset class="scheduler-border arabicLanguage">
                                                <legend class="scheduler-border ">Arabic info</legend>
                                                <div class="row">

                                                    {{-- وصف المنيو --}}
                                                    <div class="form-group col-6 arabicLanguage">
                                                        <input class="form-control" type="text" placeholder="وصف الوجبة" name="description_ar" style="direction: rtl">
                                                        <small id="description_ar_error"></small>
                                                    </div>

                                                    {{-- اسم المنيو --}}
                                                    <div class="form-group col-6 arabicLanguage">
                                                        <input class="form-control" type="text" placeholder="أسم الوجبة" name="name_ar" style="direction: rtl">
                                                        <small id="name_ar_error"></small>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        {{-- restaurant categories --}}
                                        <div class="col-12 mt-4">
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border ">Choose categories</legend>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">optional *</label>
                                                    <select multiple class="form-control" id="restaurantCategories" name="category_id[]">
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
                    <div class="text-right">
                        <button id="addNewItemButton" class="btn btn-primary waves-light waves-effect w-md mt-3" type="submit">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>

    {{-- //////// All Items list ///////// --}}
    <div class="card" id="restaurantsDiv">

        {{-- card header --}}
        <div class="card-header font-bold">
            <h5>Items List</h5>
        </div>
        <div class="card-body">
            @if(count($items) > 0)

            {{-- items table --}}
            <table id="RestaurantsTable" class="table  text-center table-bordered  table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>photo</th>
                        <th>Item Name</th>
                        <th>description</th>
                        <th style="width: 70px">price</th>
                        <th>Visibility</th>
                        <th>Restaurat</th>
                        <th>Menus</th>
                        <th>Categories</th>
                        <th>Sort Number</th>
                        <th>created at</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($items as $item)

                    <tr>
                        {{-- photo --}}
                        <td> <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/itemPhoto').'/'.$item->photo}}" alt="profile" height="50px" class="hvr-grow"></td>

                        {{-- Name --}}
                        <td> {{$item->name}} </td>

                        {{-- descrition --}}
                        <td> {{$item->description}}</td>

                        {{-- price --}}
                        <td>{{$item->price}} EGP</td>

                        {{-- is visible --}}
                        <td>
                            @if ($item->is_visible == 1)
                            <span class="badge badge-success">Visible</span>
                            @else
                            <span class="badge badge-danger">Not visible</span>
                            @endif
                        </td>
                        {{-- Restaurant --}}
                        <td> {{$item->restaurant->name}} </td>

                        {{-- menus --}}
                        <td>
                            @if (count($item->categories) >= 1)
                            @foreach ($item->categories as $category)
                            @if (count($category->menus) >= 1)
                            @foreach ($category->menus  as $menu)
                            @if($item->restaurant->language == 2)
                                {{ $menu->name_ar }}
                                @else
                                {{ $menu->name }}
                                @endif
                            @endforeach
                            @else
                            <span class="badge badge-pill badge-secondary">item not assigned to any menu</span>
                            @endif
                            @endforeach
                            @else
                            <span class="badge badge-pill badge-secondary">item not assigned to any menu</span>
                            @endif
                        </td>
                        {{-- category --}}
                        <td>
                            @if (count($item->categories) >= 1)
                            @foreach ($item->categories as $category)
                            @if($item->restaurant->language == 2)
                            <a href="{{route('showCategory' , $category->id)}}">{{$category->name_ar}}</a> <br>
                            @else
                            <a href="{{route('showCategory' , $category->id)}}">{{$category->name}}</a> <br>
                            @endif
                            @endforeach
                            @else
                            <span class="badge badge-pill badge-secondary">item not assigned to any category</span>
                            @endif
                        </td>

                        {{-- Sort Number --}}
                        <td>{{$item->sort_no}}</td>

                        {{-- created_at --}}
                        <td>{{$item->created_at->format('d F Y, h:i A')}}</td>

                        {{-- Actions --}}
                        <td>
                             <a href="{{route('showItem' , $item->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="show Item" class="btn btn-icon waves-effect waves-light btn-success"><i class="dripicons-enter"></i></a>
                             <a href="{{route('editItem' , $item->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="edit Item" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                             <button id="deleteItemButton" item_id="{{route('deleteItem' , $item->id)}}" data-toggle="tooltip" data-placement="top" title="remove Item" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th>photo</th>
                    <th>Item Name</th>
                    <th>description</th>
                    <th>price</th>
                    <th>is visible</th>
                    <th>Categories</th>
                    <th>Categories</th>
                    <th>Categories</th>
                    <th> Sort Number</th>
                    <th>created at</th>
                    <th>Actions</th>
                </tfoot>
            </table>
            @else
            <div class="alert alert-danger">
                No items found here
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


{{-- start script section  --}}
@section("scripts")

<script>
    //=======choose restaurant to add item===========//


    $("#chooseRestaurant").change(function() {

        getCategories()

        var element = $(this).find('option:selected');

        var language = element.attr("language");

        $('#restaurantLanguageInput').val(language);


        var englishArabic = 0
            , english = 1
            , arabic = 2

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


    //======= get categories after choose restaurant ===========//

    function getCategories() {

        $('#restaurantCategories').empty();

        var restaurantID = $('#chooseRestaurant').val();


        $.ajax({
            url: '{{route("getCategoriesAfterChooseRestaurant")}}'
            , method: 'get'
            , data: {
                restaurantID
            }
            , success: response => {

                if (response) {
                    var categories = response.categories;

                    // insert items to dom
                    categories.forEach(category => {

                        var node = $(`<option style="border-bottom:1px solid #f1f1f1;" value=${category.id}>${category.name == null ? category.name_ar : category.name}</option>`);
                        $('#restaurantCategories').append(node);
                    });

                }
                if ($('#restaurantCategories > option').length == 0) {
                    var node = $(`<option disabled style="background:red; color:white">No categories at this restaurant</option>`);
                    $('#restaurantCategories').append(node);
                }
            }
        });
    }


    //======= add new item by ajax ==================//


    $('#addNewItemButton').on('click', function(e) {

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
        var formData = new FormData($('#addNewItemForm')[0]);

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
                        $("#restaurantsDiv").load(location.href + " #restaurantsDiv", function() {
                            datatableReInitial()
                        });

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

    //======= delete  item by ajax ==================//


    $(document).on('click', "#deleteItemButton", function(e) {


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

                            swal("Item Deleted successfully!", "", "success")
                                .then(() => {
                                    $("#restaurantsDiv").load(location.href + " #restaurantsDiv", function() {
                                        datatableReInitial()
                                    });

                                });

                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove Item", "please check ereors", "error");
                        }
                    });
                } else {
                    swal("Item still exists!");
                }
            });
    });



    //======= delete  item by ajax ==================//

    function datatableReInitial() {

        $('#RestaurantsTable').DataTable({
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
    }

    // ===============  datatable init  =================//
    $(document).ready(function() {
        datatableReInitial()
    })

</script>
@endsection
