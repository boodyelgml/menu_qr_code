@extends('layouts.layout')



{{-- content section --}}
@section('content')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item"><a href="{{ route('categories') }}"> Categories list </a></li>
<li class="breadcrumb-item active"><a href="{{ route('editCategory' , $categories[0]->id) }}">
        Edit
        @if($categories[0]->restaurant->language == 2)
        {{ $categories[0]->name_ar }}
        @else
        {{ $categories[0]->name }}
        @endif
    </a>
</li>
@endsection
<div class="col-12">
    <div class="card">
        <div class="card-header font-bold">
            <h5>Edit {{ $categories[0]->name }} Information</h5>
        </div>
        <div class="card-body">
            @foreach($categories as $category)
            <div class="row">
                <div class="col-12">
                    <form class="form-horizontal" id="updateCategoryForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            {{-- hidden language input --}}
                            <input type="text" id="restaurantLanguageInput" value="{{ $category->restaurant->id }}" name="restaurant_id" hidden>
                            <input type="text" id="restaurantLanguageInput" value="{{ $category->restaurant->language }}" name="language" hidden>

                            {{-- add category --}}
                            <section id="addMenuAfterChooseRestaurant" class="col-12">
                                <div class="row">
                                    <div class="col-2 ">

                                        {{-- photo --}}
                                        <div class="form-group mt-3">

                                            {{-- placeholder --}}
                                            @if(strlen($category->photo) >= 2)
                                            <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/categoryPhoto/').'/'.$category->photo}}" />
                                            @else
                                            <img data-toggle="modal" data-target=".bd-example-modal-lg" class="hvr hvr-grow placeholder_image img-fluid" src="{{asset('assets/images/categoryPhoto/placeholder.png')}}" />
                                            @endif

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
                                                            <label for="">Upload category photo</label>
                                                            <div class="custom-file ">
                                                                <input type="file" class="custom-file-input" id="customFile" name="photo">
                                                                <label class="custom-file-label" for="photo">Upload
                                                                    category
                                                                    photo</label>
                                                                <small id="photo_error"></small>
                                                            </div>
                                                        </div>

                                                        {{-- is visible --}}
                                                        <div class="form-group col-4">
                                                            <label for="">Is category visible !</label>
                                                            <select class="form-control" name="is_visible">
                                                                <option value="1" @if($category->is_visible == 1)
                                                                    selected @endif>visible</option>
                                                                <option value="0" @if($category->is_visible == 0)
                                                                    selected @endif>Not visible</option>
                                                            </select>
                                                            <small id="is_visible_error"></small>
                                                        </div>

                                                        {{-- sort number --}}
                                                        <div class="form-group col-4">
                                                            <label for="">category Sort Number</label>
                                                            <input class="form-control" type="number" id="sort_no" value="{{ $category->sort_no }}" required name="sort_no">
                                                            <small id="sort_no_error"></small>
                                                        </div>

                                                        {{-- is visible --}}
                                                        <div class="form-group col-4">
                                                            <label for="">Restaurant</label>
                                                            <input class="form-control" type="text" value=" @if($category->restaurant->language == 2) {{ $category->restaurant->name_ar }} @else {{ $category->restaurant->name }} @endif" disabled>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>

                                            {{-- english info --}}
                                            @if($category->restaurant->language == 0 || $category->restaurant->language == 1)
                                            <div class="col-12 englishLanguage mt-4">
                                                <fieldset class="scheduler-border englishLanguage">
                                                    <legend class="scheduler-border ">English info</legend>
                                                    <div class="row">

                                                        {{-- name --}}
                                                        <div class="form-group col-6 englishLanguage">
                                                            <input class="form-control" required type="text" required="" value="{{ $category->name }}" name="name" placeholder="category name">
                                                            <small id="name_error"></small>
                                                        </div>

                                                        {{-- description --}}
                                                        <div class="form-group col-6 englishLanguage">
                                                            <input class="form-control" type="text" required value="{{ $category->description }}" name="description" placeholder="category description">
                                                            <small id="description_error"></small>
                                                        </div>
                                                    </div>
                                                </fieldset>
                                            </div>
                                            @endif

                                            {{-- arabic info --}}
                                            @if($category->restaurant->language == 0 || $category->restaurant->language == 2)
                                            <div class="col-12 arabicLanguage mt-4">
                                                <fieldset class="scheduler-border arabicLanguage">
                                                    <legend class="scheduler-border ">Arabic info</legend>
                                                    <div class="row">

                                                        {{-- وصف المنيو --}}
                                                        <div class="form-group col-6 arabicLanguage">
                                                            <input class="form-control" type="text" required value="{{ $category->description_ar }}" placeholder="وصف  القسم" name="description_ar" style="direction: rtl">
                                                            <small id="description_ar_error"></small>
                                                        </div>

                                                        {{-- اسم المنيو --}}
                                                        <div class="form-group col-6 arabicLanguage">
                                                            <input class="form-control" required type="text" value="{{ $category->name_ar }}" placeholder="أسم القسم" name="name_ar" style="direction: rtl">
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

                            {{-- add button --}}
                            <div class="col-12 text-right">
                                <button id="updateCategoryButton" class="btn btn-primary waves-light waves-effect w-md mt-3">Update Category</button>
                            </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection

@section("scripts")
<script>
    //================================================//
    //======= update category information =========//
    //================================================//


    $('#updateCategoryButton').on('click', function(e) {

        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#name_error').text('');
        $('#description_error').text('');
        $('#photo_error').text('');
        $('#is_visible_error').text('');
        $('#sort_no_error').text('');
        $('#menu_id_error').text('');

        var formData = new FormData($('#updateCategoryForm')[0]);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route("updateCategory" , $category->id)}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("category updated successfully!", "", "success")
                    .then(() => {
                        window.location = "{{ url('/category') }}";

                    });


            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to update Category", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });

    });

</script>
@endsection

