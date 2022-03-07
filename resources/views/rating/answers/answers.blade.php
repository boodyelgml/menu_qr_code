@extends('layouts.layout')
{{-- TITLE SECTION --}}
@section('title')
feedback questions list
@endsection

{{-- CONTENT SECTION --}}
@section('content')

{{--START All ads list --}}
<div class="col-12">
   <div class="card" id="QuestionDiv">

      {{-- card header --}}
      <div class="card-header font-bold">
         <h5>Feedback answers List</h5>
      </div>

      {{-- CARD BODY --}}
      <div class="card-body">
         @if(count($answers) > 0)
         <table id="QuestionTable" class="table  text-center table-bordered  table-sm" style="width:100%">
            <thead>
               <tr>
                  <th>Restaurants</th>
                  <th>Branch</th>
                  <th>Question</th>
                  <th style="width: 300px">Answer</th>
                  <th>Answerd at</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($answers as $answer)
                <tr>
                  <td>{{ $answer->restaurant->name }}</td>
                  <td>
                     @foreach ($branches as $branch)
                     @if($branch->id == $answer->branch_id)
                     {{ $branch->branch_address }}
                     @endif
                     @endforeach
                  </td>
                  <td>{{ $answer->questions->question }}</td>
                  <td>

                     <div class="progress m-auto" style="height: 20px; font-size: 15px;">

                        @if($answer->answer == 0)
                        <div class="progress-bar" role="progressbar" style="width: 0%; font-size: 15px;"
                           aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>

                        @elseif($answer->answer == 1)
                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                           style="width: 20%;font-size: 15px;" aria-valuenow="20" aria-valuemin="0"
                           aria-valuemax="100">20%</div>

                        @elseif($answer->answer == 2)
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                           style="width: 40%;font-size: 15px;" aria-valuenow="40" aria-valuemin="0"
                           aria-valuemax="100">40%</div>

                        @elseif($answer->answer == 3)
                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                           style="width: 60%;font-size: 15px;" aria-valuenow="60" aria-valuemin="0"
                           aria-valuemax="100">60%</div>

                        @elseif($answer->answer == 4)
                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                           style="width: 80%;font-size: 15px;" aria-valuenow="80" aria-valuemin="0"
                           aria-valuemax="100">80%</div>

                        @elseif($answer->answer == 5)
                        <div class="progress-bar progress-bar-striped" role="progressbar"
                           style="width: 100%;font-size: 15px;" aria-valuenow="100" aria-valuemin="0"
                           aria-valuemax="100">100%</div>
                        @endif
                     </div>
                  </td>
                  <td>{{ $answer->created_at->format('d F Y, h:i A') }}</td>
               </tr>

               @endforeach
            </tbody>
            <tfoot>
               <th>Question</th>
               <th>Arabic Question</th>
               <th>visibility</th>
               <th>restaurants</th>
               <th>restaurants</th>
            </tfoot>
         </table>
         @else
         <div class="alert alert-danger">
            No feedback Answers yet
         </div>
         @endif
      </div>
   </div>
</div>

{{--START All text fedback --}}
<div class="col-12 mt-3">
   <div class="card" id="QuestionDiv">

      {{-- card header --}}
      <div class="card-header font-bold">
         <h5>Feedback text</h5>
      </div>

      {{-- CARD BODY --}}
      <div class="card-body">
         @if(count($answers) > 0)
         <table id="feedbackTable" class="table  text-center table-bordered  table-sm" style="width:100%">
            <thead>
               <tr>
                  <th>Restaurants</th>
                  <th>Branch</th>
                  <th>feedback comment</th>
                  <th>Answerd at</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($feedbacks as $feedback)
                <tr>
                  <td>{{ $feedback->restaurant->name }}</td>
                  <td>
                     @foreach ($branches as $branch)
                     @if($branch->id == $feedback->branch_id)
                     {{ $branch->branch_address }}
                     @endif
                     @endforeach
                  </td>
                  <td>{{ $feedback->feedback }}</td>
                  <td>{{ $feedback->created_at->format('d F Y, h:i A') }}</td>
               </tr>
               @endforeach
            </tbody>
            <tfoot>
               <th>Question</th>
               <th>Arabic Question</th>
               <th>visibility</th>
               <th>restaurants</th>
            </tfoot>
         </table>
         @else
         <div class="alert alert-danger">
            No feedback Answers yet
         </div>
         @endif
      </div>
   </div>
</div>
@endsection
@section('scripts')
<script>
    $('document').ready(function(){


        $('#QuestionTable').DataTable({
            "order": [
                [4, "desc"]
            ],
            initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
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
            $('tfoot tr th:nth-of-type(4) select').addClass('d-none')

            $('#feedbackTable').DataTable({
                "order": [
                [3, "desc"]
            ],
            initComplete: function() {
            this.api().columns().every(function() {
                var column = this;
                var select = $('<select class="form-control"><option value=""></option></select>')
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
     })
</script>

@endsection
