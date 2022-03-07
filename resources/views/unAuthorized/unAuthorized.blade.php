@extends('layouts.layout')

{{-- breadcrump --}}
@section('breadcrumps')
<li class="breadcrumb-item active"><a href="{{ route('items') }}"> Items list </a></li>
@endsection

{{-- CONTENT SECTION --}}
@section('content')
    <div class="col-12">
        <div class="alert alert-danger">
            Sorry you are not authorized
        </div>
    </div>
@endsection

