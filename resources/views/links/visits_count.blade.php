@extends('layouts.layout')
{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('items') }}"> Links visits count</a></li>
@endsection



{{-- CONTENT SECTION --}}
@section('content')
{{-- start add new AD --}}
<div class="col-12" id="linksDiv">
    <div class="card">
        <div class="card-header">
            <h5>Urls</h5>
        </div>
        <div class="card-body">


            <table id="LinksTable" class="table  text-center table-bordered  table-sm" style="width:100%">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Visit date</th>
                        <th>Visit time</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($visits as $visit)


                    <tr>

                        {{-- name --}}
                        <td>{{ $visit->link->name }}</td>

                        {{-- qr --}}
                        <td>{{ $visit->link->description }}</td>

                        {{-- date --}}
                        <td>{{ $visit->created_at->format('Y.m.d') }}</td>

                        {{-- time --}}
                        <td>{{ $visit->created_at->format('H:i:s') }}</td>



                    </tr>

                    @endforeach
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Visit date</th>
                        <th>Visit time</th>
                    </tr>
                </tfoot>
                </tbody>

            </table>



        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('#LinksTable').DataTable({

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


    });

</script>
@endsection
