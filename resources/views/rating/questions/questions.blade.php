@extends('layouts.layout')
{{-- TITLE SECTION --}}
@section('title')
feedback questions list
@endsection

{{-- CONTENT SECTION --}}
@section('content')

{{-- start add new AD --}}
<div class="col-12 ">

    <p class="text-right">
        <button class="btn btn-primary waves-light waves-effect w-md" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="true" aria-controls="collapseExample">
            <i class="mdi mdi-food-fork-drink"></i> Add feedback question
        </button>
    </p>

    <div class="collapse " id="collapseExample" style="">

        <div class="card">
            {{-- CARD HEADER --}}
            <div class="card-header font-bold">
                <h5>Add new feedback question</h5>
            </div>

            <div class="card-body ">

                {{-- START question feeback FORM --}}
                <form class="form-horizontal" id="addNewQuestionForm" action="{{route('createFeedbackQuestion')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        {{-- Question --}}
                        <div class="form-group col-4">
                            <label for="">Question</label>
                            <input class="form-control" type="text" required id="question" name="question" placeholder="Example : how is our service ?">
                            <small id="question_error"></small>
                        </div>

                        {{-- Question ar --}}
                        <div class="form-group col-4">
                            <label for="">arabic Question</label>
                            <input class="form-control" type="text" required id="question_ar" name="question_ar" style="direction: rtl" placeholder="مثال : ما رأيك فى خدمتنا ؟">
                            <small id="question_ar_error"></small>
                        </div>

                        {{-- is visible --}}
                        <div class="form-group col-4">
                            <label for="">visibility</label>
                            <select class="form-control" name="is_visible">
                                <option value="1" selected>visible</option>
                                <option value="0">Not visible</option>
                            </select>
                            <small id="is_visible_error"></small>
                        </div>

                        {{-- restaurants --}}
                        <div class="form-group  col-4">
                            <label for="">choose restaurants</label>
                            <select multiple class="form-control" id="exampleFormControlSelect2" name="restaurant_id[]">

                                {{-- super admin --}}
                                @foreach ($restaurants as $restaurant)
                                <option value="{{ $restaurant->id }}">
                                    {{ $restaurant->name }}
                                </option>
                                @endforeach
                            </select>
                            <small id="restaurant_id_error"></small>
                        </div>
                    </div>

                    {{-- add button --}}
                    <div class="text-right">
                        <button id="addNewQuestionButton" class="btn btn-primary waves-light waves-effect w-md" type="submit">Add question</button>
                    </div>
                </form>
            </div>
        </div>
        <div style="color: #f1f1f1; margin-top:-10px;">.</div>
    </div>
</div>

{{--START All ads list --}}
<div class="col-12">
    <div class="card" id="QuestionDiv">

        {{-- card header --}}
        <div class="card-header font-bold">
            <h5>Feedback questions List</h5>
        </div>

        {{-- CARD BODY --}}
        <div class="card-body">
            @if(count($questions) > 0)
            <table id="QuestionTable" class="table  text-center table-bordered  table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Arabic Question</th>
                        <th>visibility</th>
                        <th>restaurants</th>
                        <th style="width: 150px">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($questions as $question)
                    <tr>

                        {{-- question --}}
                        <td>{{ $question->question }}</td>

                        {{-- question_ar --}}
                        <td>{{ $question->question_ar }}</td>


                        {{-- visibility --}}
                        <td>
                            @if($question->is_visible == 1)
                            <div class="badge-success badge">visible</div>
                            @else
                            <div class="badge-danger badge">not visible</div>
                            @endif
                        </td>

                        {{-- restaurant --}}
                        <td>
                            @foreach ($question->restaurants as $restaurant)
                            @if($restaurant->user_id == Auth::user()->id || Auth::user()->role == 1)
                            <a href="{{ route('showRestaurant' , $restaurant->id) }}">
                                {{ $restaurant->name }}
                                <br></a>
                            @endif
                            @endforeach
                        </td>

                        {{-- Actions --}}
                        <td>
                            <a href="{{route('editQuestion' , $question->id)}}" type="button" name="button" data-toggle="tooltip" data-placement="top" title="edit question" class="btn btn-icon waves-effect waves-light btn-primary"><i class="dripicons-gear"></i></a>
                            <button id="deleteQuestionButton" question_id="{{route('deleteQuestion' , $question->id)}}" data-toggle="tooltip" data-placement="top" title="remove question" class="btn btn-icon waves-effect waves-light btn-danger" type="submit"><i class="dripicons-trash"></i></button>
                        </td>
                    </tr>

                    @endforeach
                </tbody>
                <tfoot>
                    <th>Question</th>
                    <th>Arabic Question</th>
                    <th>visibility</th>
                    <th>restaurants</th>
                    <th style="width: 150px">Actions</th>
                </tfoot>
            </table>
            @else
            <div class="alert alert-danger">
                No feedback questions yet
            </div>
            @endif
        </div>
    </div>
</div>
@endsection


{{-- start script section  --}}
@section("scripts")
<script>
    $('#addNewQuestionButton').on('click', function(e) {
        $('.loaderContainer').fadeIn(200);

        e.preventDefault();

        // Reset all errors
        $('#question_error').text('');
        $('#question_ar_error').text('');
        $('#is_visible_error').text('');
        $('#restaurant_id_error').text('');

        var formData = new FormData($('#addNewQuestionForm')[0]);
        console.log(formData);

        $.ajax({
            type: 'post'
            , enctype: 'multipart/form-data'
            , url: '{{route('createFeedbackQuestion')}}'
            , data: formData
            , processData: false
            , contentType: false
            , cache: false
            , success: function(data) {
                $('.loaderContainer').fadeOut(200);

                swal("Ad Added successfully!", "", "success")
                    .then(() => {
                        $("#QuestionDiv").load(location.href + " #QuestionDiv", function() {
                            $('#QuestionTable').DataTable();
                        });
                    });

            }
            , error: function(reject) {
                $('.loaderContainer').fadeOut(200);

                swal("failed to add restaurant", "please check ereors", "error");
                var response = $.parseJSON(reject.responseText);
                $.each(response.errors, function(key, val) {
                    $("#" + key + "_error").text(val[0]);
                });
            }
        });
    });



    $(document).on('click', "#deleteQuestionButton", function(e) {


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
                    var questionID = $(this).attr('question_id');
                    $.ajax({
                        type: 'delete'
                        , url: questionID
                        , data: ""
                        , success: function(data) {
                            $('.loaderContainer').fadeOut(200);

                            swal("Ad Deleted successfully!", "", "success")
                                .then(() => {
                                    $("#QuestionDiv").load(location.href + " #QuestionDiv", function() {
                                        $('#QuestionTable').DataTable();
                                    });
                                });
                        }
                        , error: function(reject) {
                            $('.loaderContainer').fadeOut(200);

                            swal("failed to remove Ad", "please check ereors", "error");
                        }
                    });
                } else {
                    $('.loaderContainer').fadeOut(200);

                    swal("Ad still exists!");
                }

            });
    });

    function datatableReInitial() {

        $('#QuestionTable').DataTable({

            initComplete: function() {
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
        $('tfoot tr th:nth-of-type(3) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(4) select').addClass('d-none')
        $('tfoot tr th:nth-of-type(5) select').addClass('d-none')

    }

    // ===============  datatable init  =================//
    $(document).ready(function() {
        datatableReInitial()
    })

</script>
@endsection
