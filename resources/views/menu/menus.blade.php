@extends('layouts.layout')

{{-- START STYLES SECTION --}}
@section('styles')
<style>
    #menusTable td {
        vertical-align: middle;
    }

    svg {
        height: 80px;
        width: 80px;
    }

    #png-container img {
        height: 200px;
    }

    .QrDiv img {
        width: 120px !important;
    }

</style>
@endsection

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('menus') }}">Menus list </a></li>
@endsection

{{-- CONTENT SECTION --}}
@section('content')

{{-- start add new Menu --}}
<div class="col-12 ">
    <p class="text-right">
        <button class="btn btn-success waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            <i class="mdi mdi-food-fork-drink"></i> Add New Menu
        </button>
    </p>
    <div class="collapse " id="collapseExample" style="">
        <div class="card">
            <div class="card-header font-bold">
                <h5>Add new Menu</h5>
            </div>

            {{-- ADD Menu FORM --}}
            <div class="card-body ">
                <form class="form-horizontal" id="addNewMenuForm" action="{{route('createMenu')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        {{-- restaurant id --}}
                        <div class="form-group col-4">
                            <label for="">Choose Restaurant</label>
                            <select class="form-control" name="restaurant_id" id="ChooseRestaurantInsideCreateNewMenu">
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
                        <input type="text" id="restaurantLanguageInput" value="" name="language" hidden>

                        {{-- add menu --}}
                        <section id="addMenuAfterChooseRestaurant" class="d-none col-12">
                            <div class="row">
                                <div class="col-2 ">
                                    <div class="form-group mt-3">
                                        <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/menuPhoto/placeholder.png')}}" />
                                        <img data-toggle="modal" data-target=".bd-example-modal-lg" id="blah" src="#" alt="" class="img-fluid" />
                                    </div>
                                </div>

                                {{-- menu form --}}
                                <div class="col-10 ">
                                    <div class="row">
                                        <div class="col-12">

                                            {{-- general info --}}
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border ">General info</legend>
                                                <div class="row">

                                                    {{-- photo --}}
                                                    <div class="form-group col-4">
                                                        <label for="">Upload Menu photo</label>
                                                        <div class="custom-file ">
                                                            <input type="file" class="custom-file-input" id="customFile" name="photo">
                                                            <label class="custom-file-label" for="photo">Upload Menu
                                                                photo</label>
                                                            <small id="photo_error"></small>
                                                        </div>
                                                    </div>

                                                    {{-- is visible --}}
                                                    <div class="form-group col-4">
                                                        <label for="">Menu Visibility</label>
                                                        <select class="form-control" name="is_visible">
                                                            <option value="1" selected>visible</option>
                                                            <option value="0">Not visible</option>
                                                        </select>
                                                        <small id="is_visible_error"></small>
                                                    </div>

                                                    {{-- sort number --}}
                                                    <div class="form-group col-4">
                                                        <label for="">Menu Sort Number</label>
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
                                                        <input class="form-control" type="text" name="name" placeholder="menu name">
                                                        <small id="name_error"></small>
                                                    </div>

                                                    {{-- description --}}
                                                    <div class="form-group col-6 englishLanguage">
                                                        <input class="form-control" type="text" name="description" placeholder="menu description">
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
                                                        <input class="form-control" type="text" placeholder="وصف القائمة" name="description_ar" style="direction: rtl">
                                                        <small id="description_ar_error"></small>
                                                    </div>

                                                    {{-- اسم المنيو --}}
                                                    <div class="form-group col-6 arabicLanguage">
                                                        <input class="form-control" type="text" placeholder="أسم القائمة" name="name_ar" style="direction: rtl">
                                                        <small id="name_ar_error"></small>
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>

                                        {{-- restaurant categories --}}
                                        <div class="col-6 mt-4">
                                            <fieldset class="scheduler-border">
                                                <legend class="scheduler-border ">Add categories to this menu</legend>
                                                <div class="form-group">
                                                    <label for="exampleFormControlSelect2">optional *</label>
                                                    <select multiple class="form-control" id="restaurantCategories" name="category_id[]">
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
                    <div class="text-right mt-3">
                        <button id="addNewMenuButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Add
                            Menu</button>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>

    {{--START All menus list --}}
    <div class="card" id="menusDiv">

        {{-- card header --}}
        <div class="card-header font-bold">
            <h5>Menus List</h5>
        </div>

        {{-- CARD BODY --}}
        <div class="card-body">
            @if(count($menus) > 0)
            <table id="MenusTable" class="table text-center table-bordered  table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Menu Name</th>
                        <th>Qr</th>
                        <th>Description</th>
                        <th>Visibility</th>
                        <th style="width: 180px">Categories</th>
                        <th>Restaurant</th>
                        <th>Created at</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($menus as $menu)

                    <tr>
                        {{-- photo --}}
                        <td> <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/menuPhoto').'/'.$menu->photo}}" alt="profile" height="80px" class="hvr-grow"></td>

                        {{-- menu name --}}
                        <td> {{$menu->name}} </td>

                        {{-- menu qr --}}
                        <td>
                            <a href="{{ route('menuView' , $menu->id  ) }}">Preview menu</a>
                            <div class="QrDiv" id="Menu{{$menu->id}}"></div>
                        </td>

                        {{-- about --}}
                        <td> {{$menu->description}} </td>

                        {{-- is visible --}}
                        <td>
                            @if ($menu->is_visible == 1)
                            <span class="badge badge-success">Visible</span>
                            @else
                            <span class="badge badge-danger">Not visible</span>
                            @endif
                        </td>

                        {{-- menu restaurant --}}
                        <td> {{$menu->restaurant->name}} </td>

                        {{--categories--}}
                        <td>
                            @if (count($menu->categories) >= 1)
                            @foreach($menu->categories as $category)
                            <a href="{{route('showCategory' , $category->id)}}">{{ $category->name }}</a> <br>
                            @endforeach
                            @else
                            <span class="badge badge-pill badge-secondary">no categories found</span>
                            @endif
                        </td>

                        {{-- created at --}}
                        <td>{{$menu->created_at->format('d F Y, h:i A')}}</td>

                        {{-- actions buttons --}}
                        <td>
                            <a href="{{route("showMenu" , $menu->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Show menu" class="btn btn-icon waves-effect waves-light btn-success">
                                <i class="dripicons-enter"></i></a>
                            <a href="{{route("editMenu" , $menu->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="Edit menu" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                            <button id="deleteMenuButton" menu_id="{{route('deleteMenu', $menu->id)}}" data-toggle="tooltip" data-placement="top" title="Delete menu" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                        </td>
                    </tr>
                    <script>
                        var qrcode = new QRCode(document.getElementById("Menu{{$menu->id}}"), {
                            text: "{{ route('menuView' , $menu->id  ) }}"
                            , logo: "{{asset('assets/images/restauranLogo').'/'.$menu->restaurant->logo}}"
                            , logoWidth: 100
                            , logoHeight: 100
                            , logoBackgroundTransparent: true
                        , });

                    </script>
                    @endforeach
                </tbody>
                <tfoot>
                    <th>Photo</th>
                    <th>Menu Name</th>
                    <th>Qr</th>
                    <th>Description</th>
                    <th>Visibility</th>
                    <th style="width: 180px">Categories</th>
                    <th>Restaurant</th>
                    <th>Created at</th>
                    <th style="width: 150px">Actions</th>
                </tfoot>
            </table>
            @else
            <div class="alert alert-danger">
                No menus found
            </div>
            @endif
        </div>
    </div>
</div>
</div>

@endsection
{{-- start script section  --}}
@section("scripts")

<script>
    //=====================================================//
    //======== get categories  when choose restaurant ==== //
    //=====================================================//
    function getCategories() {
        $('#restaurantCategories').empty();
        var restaurantID = $('#ChooseRestaurantInsideCreateNewMenu').val();
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
                        var node = $(`<option style="border-bottom:1px solid #f1f1f1;" value="${category.id}">  ${category.name == null ?  category.name_ar : category.name}  </option>`);
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



    //=====================================================//
    //======== get branches  when choose restaurant ==== //
    //=====================================================//


    function getBranches() {
        $('#restaurantBranches').empty();
        var restaurantID = $('#ChooseRestaurantInsideCreateNewMenu').val();
        $.ajax({
            url: '{{route("getBranchesAfterChooseRestaurant")}}'
            , method: 'get'
            , data: {
                restaurantID
            }
            , success: response => {
                if (response) {
                    var branches = response.branch;
                    // insert items to dom
                    branches.forEach(branch => {
                        var node = $(`<option style="border-bottom:1px solid #f1f1f1;" value="${branch.id}">  ${branch.branch_address == null ?  branch.branch_address_ar : branch.branch_address}  </option>`);
                        $('#restaurantBranches').append(node);
                    });
                }
                if ($('#restaurantBranches > option').length == 0) {
                    var node = $(`<option disabled style="background:red; color:white">No Branches at this restaurant</option>`);
                    $('#restaurantBranches').append(node);
                }
            }
        });
    }


    //=====================================================//
    //= get categories and language when choose restaurant = //
    //=====================================================//


    $("#ChooseRestaurantInsideCreateNewMenu").change(function() {

        getBranches()
        getCategories();
        var element = $(this).find('option:selected');
        var language = element.attr("language");
        $('#restaurantLanguageInput').val(language);
        englishArabic = 0
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

    // ===================================================== //
    //================ add new menu by ajax ================ //
    // ===================================================== //

    $('#addNewMenuButton').on('click', function(e) {
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

        var formData = new FormData($('#addNewMenuForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route('createMenu')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Menu Added successfully!", "", "success")
                    .then(() => {
                        location.reload();
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


    // ===================================================== //
    //================ delete  menu by ajax ================ //
    // ===================================================== //

    $(document).on('click', "#deleteMenuButton", function(e) {

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
                                    $("#menusDiv").load(location.href + " #menusDiv", function() {
                                        DatatableReInitial()
                                    });
                                });
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


    // ====================================================== //
    // =============== re initial datatable func ============ //
    // ====================================================== //

    function DatatableReInitial() {

        $('#MenusTable').DataTable({
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
        $('tfoot tr th:nth-of-type(6) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(9) select').addClass('d-none')

        $('tfoot').each(function() {
            $(this).insertAfter($(this).siblings('thead'));
        });
    }


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

    // ======================================================== //
    // ================ when document is ready  =============== //
    //========================================================= //

    $(document).ready(function() {
        DatatableReInitial()
    })

</script>
@endsection
