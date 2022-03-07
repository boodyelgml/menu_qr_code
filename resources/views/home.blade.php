{{-- extend layout --}}
@extends('layouts.layout')

{{-- if guest --}}
@guest
<script type="text/javascript">
   window.location = "{{ url('/login') }}";//here double curly bracket
</script>
@endguest

{{-- if authorized --}}
@auth
@if(Auth::user()->role == 2)
<script type="text/javascript">
   window.location = "{{ url('/restaurant') }}";
</script>
@endif

{{-- title --}}
@section('title') Dashboard @endsection

{{-- content --}}
@section('content')
<div class="col-12">
   <div class="card">
      <div class="card-body">
         <div class="row">

            {{-- dashboard card 2 --}}
            <div class="col-3">
               <a href="{{ route('restaurants') }}">
                  <div class="card-box tilebox-one">
                     <i class="fi-layers float-right"></i>
                     <h6 class="text-muted text-uppercase mb-3">Restaurants</h6>
                     <h4 class="mb-3" data-plugin="counterup">{{ count($restaurants) }}</h4>
                     <span class="badge badge-primary"> +2% </span> <span
                        class="text-muted ml-2 vertical-middle">From previous period</span>
                  </div>
               </a>
            </div>

            {{-- dashboard card 3 --}}
            <div class="col-3">
               <a href="{{ route('menus') }}">
                  <div class="card-box tilebox-one">
                     <i class="fi-tag float-right"></i>
                     <h6 class="text-muted text-uppercase mb-3">Menus</h6>
                     <h4 class="mb-3" data-plugin="counterup">{{ count($menus) }}</h4>
                     <span class="badge badge-primary"> +14% </span> <span
                        class="text-muted ml-2 vertical-middle">From previous period</span>
                  </div>
               </a>
            </div>

            {{-- dashboard card 3 --}}
            <div class="col-3">
               <a href="{{ route('categories') }}">
                  <div class="card-box tilebox-one">
                     <i class="fi-tag float-right"></i>
                     <h6 class="text-muted text-uppercase mb-3">Categories</h6>
                     <h4 class="mb-3" data-plugin="counterup">{{ count($categories) }}</h4>
                     <span class="badge badge-primary"> +14% </span> <span
                        class="text-muted ml-2 vertical-middle">From previous period</span>
                  </div>
               </a>
            </div>

            {{-- dashboard card 4 --}}
            <div class="col-3">
               <a href="{{ route('items') }}">
                  <div class="card-box tilebox-one">
                     <i class="fi-briefcase float-right"></i>
                     <h6 class="text-muted text-uppercase mb-3">items</h6>
                     <h4 class="mb-3" data-plugin="counterup">{{ count($items) }}</h4>
                     <span class="badge badge-primary"> +1% </span> <span
                        class="text-muted ml-2 vertical-middle">From previous period</span>
                  </div>
               </a>
            </div>
         </div>
      </div>
   </div>
</div>

<style>
   .carousel img {
   height: 380px;
   width: 100% !important;
   }
   .overlay {
   position: absolute;
   top: 0;
   bottom: 0;
   left: 0;
   right: 0;
   height: 100%;
   width: 100%;
   opacity: 0.4;
   background-color: black;
   }
</style>
@endsection
@endauth
