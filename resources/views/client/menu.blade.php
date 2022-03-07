<!doctype html>
<html lang="en">
   @foreach ($getMenu as $menu)
   <head>
      {{-- meta tags --}}
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      {{-- title --}}
      <title>{{ $menu->restaurant->name }} | {{ $menu->name }}</title>
      {{-- bootstrap --}}
      <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
      {{-- style --}}
      <link href="{{asset('assets/css/client.css')}}" rel="stylesheet" type="text/css" />
      {{-- font awesome --}}
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
   </head>

   {{-- switch language --}}
   @if($menu->restaurant->language == 0)
   <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
         <a class="nav-link @if($menu->restaurant->language == 0 || $menu->restaurant->language == 1) active @endif" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">English</a>
      </li>
      <li class="nav-item" role="presentation">
         <a class="nav-link @if($menu->restaurant->language == 2) active @endif" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">عربي</a>
      </li>
   </ul>
   @endif



   {{--///////////============================= English Rating =============================////////////--}}


   {{--//////// English questions /////////--}}
   <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade @if($menu->restaurant->language == 0 || $menu->restaurant->language == 1) show active @endif " id="home" role="tabpanel" aria-labelledby="home-tab">
         @if(count($menu->restaurant->questions) > 0 && count($menu->branches) > 0)
         <button type="button" id="feedbackFormButton" class="btn btn-icon waves-effect waves-light btn-primary"> <i class="fa fa-thumbs-o-up"></i> </button>
         <form id="AddNewAnswerForm" method="POST" action="{{ route('createAnswer') }}">
            @method('POST')
            @csrf
            <div class="ratingContainer  text-center  py-3">
               <div class="branch mx-2 mb-3">
                  {{-- branches --}}
                  <select class="form-control" required name="branch_id" id="branchesList">
                     <option selected disabled>Select branch</option>
                     @foreach($menu->branches as $branch)
                     <option value="{{ $branch->id }}">{{ $branch->branch_address }}</option>
                     @endforeach
                  </select>
               </div>
               {{-- questions --}}
               @foreach ($menu->restaurant->questions as $question)
               @if($question->is_visible == 1)
               <span class="rate">
                  <h6 class="mb-0">{{ $question->question }}</h6>
                  <div class="emoji" style="font-size: 30px; display: contents;">😠</div>
                  <input class="test" type="range" min="1" max="5" step="1" value="0" style="width: 200px" name="answer[]">
                  {{-- hidde inputs --}}
                  <input value="{{ $question->id }}" name="question_id[]" type="hidden">
                  <input value="{{ $menu->restaurant->id }}" name="restaurant_id" type="hidden">
               </span>
               <br>
               @endif
               @endforeach
               {{-- leave comment --}}
               <div class="form-group mx-2 mt-3">
                  <textarea class="form-control" id="exampleFormControlTextarea1" rows="2" placeholder="Leave comment"  name="feedback"></textarea>
                  {{-- hidde inputs --}}
                  <input value="{{ $menu->restaurant->id }}" name="restaurant_id" type="hidden">
               </div>
               <button id="feedbackButton" type="button" class="btn btn-primary btn-sm" disabled>Send feedback</button>
            </div>
         </form>
         @endif



         {{--////////  Restaurant details/////////--}}
         <div class="restaurantInfo px-2 py-4 mb-2">
            <div class="row">
               <div class="col-4 text-center">
                  <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/restauranLogo') . '/'. $menu->restaurant->logo}}" alt="">
               </div>
               <div class="col-8 pl-2">
                  <h4 class="mt-1">{{ $menu->restaurant->name }}</h4>
                  <span>{{ $menu->restaurant->description }}</span>
               </div>
            </div>
         </div>



         {{--///////// English TopAd /////////--}}
         @if(strlen($menu->restaurant->top_ad) > 2)
         <div class="card card-body py-0" id="TopAdss">
            <span class="close text-right mb-2" aria-hidden="true">&times;</span>
            @foreach ($menu->restaurant->top_ad as $ad)
            @if($ad->is_visible == 1 && $ad->main == 1)
            <a href="{{ $ad->ad_link }}" target="_blank"><img src="{{asset('assets/images/TopAdPhoto').'/'.$ad->photo}}"></a>
            @elseif(($ad->is_visible == 1 && $ad->main == 0))
            <iframe width="420" height="315" src="{{ $ad->video_url }}">
            </iframe>
            @endif
            @endforeach
         </div>
         @endif



         {{--//////// categories & items/////////--}}
         @foreach (($menu->categories)->sortBy('sort_no') as $category)
         @if($category->is_visible == 1)
         <div class="accordion" id="accordionExample">
            <div class="card">



               {{--//////// English category ///////--}}
               <div class="card-header py-2" id="ABC{{ $category->id }}">
                  <div class="text-left" data-toggle="collapse" data-target="#AB{{ $category->id }}" aria-expanded="true" aria-controls="AB{{ $category->id }}">
                     <div class="row">
                        <div class="col-4 text-center">
                           <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/categoryPhoto') . '/'. $category->photo}}" alt="">
                        </div>
                        <div class="col-8 pl-1 category EngCat">
                           <h5 class="mb-2"> {{ $category->name }}</h5>
                           <span>{{ $category->description }}</span>
                        </div>
                     </div>
                  </div>
               </div>



               {{--///////// English items /////////--}}
               <div id="AB{{ $category->id }}" class="collapse" aria-labelledby="ABC{{ $category->id }}" data-parent="#accordionExample">
                  <div class="card-body">
                     @foreach (($category->items)->sortBy('sort_no') as $item)
                     @if($item->is_visible == 1)
                     <div class="row py-3" style="border-bottom: #f1f1f1 1px solid">
                        <div class="col-8 px-4">
                           <h6 class="m-0 p-0 mb-1">{{ $item->name }}</h6>
                           <span class="description">{{ $item->description }}</span><br>
                           <span class="mt-3 d-inline-block font-bold">{{ $item->price }} EGP</span>
                        </div>
                        <div class="col-4 text-right ml-0 pl-0">
                           <img data-toggle="modal" data-target=".bd-example-modal-lg" class="mt-1" src="{{asset('assets/images/itemPhoto') . '/'. $item->photo}}" alt="">
                        </div>
                     </div>
                     @endif
                     @endforeach
                  </div>
               </div>

            </div>
         </div>
         @endif
         @endforeach
      </div>

      {{--///////////============================= عربى =============================////////////--}}


      {{--//////// تقييم ////////--}}
      <div class="tab-pane fade @if($menu->restaurant->language == 2) show active @endif" id="profile" role="tabpanel" aria-labelledby="profile-tab">
         @if(count($menu->restaurant->questions) > 0 && count($menu->branches) > 0)
         <button type="button" id="feedbackFormButton_ar" class="btn btn-icon waves-effect waves-light btn-primary">
         <i class="fa fa-thumbs-o-up"></i>
         </button>
         <form id="AddNewAnswerForm_ar" method="POST" action="{{ route('createAnswer') }}">
            @method('POST')
            @csrf
            <div class="ratingContainer  text-center  py-3">


                {{--//////// فروع ////////--}}
               <div class="branch mx-2 mb-3">
                  <select class="form-control" required name="branch_id" id="branchesList_ar" style="direction: rtl">
                     <option selected disabled>أختار الفرع</option>
                      @foreach($menu->branches as $branch)
                     <option value="{{ $branch->id }}">{{ $branch->branch_address_ar }}</option>
                     @endforeach
                  </select>
               </div>


               {{--//////// اسئلة ////////--}}
               @foreach ($menu->restaurant->questions as $question)
               @if($question->is_visible == 1)
               <span class="rate">
                  <h6 class="mb-0">{{ $question->question_ar }}</h6>
                  <div class="emoji" style="font-size: 30px; display: contents;">😠</div>
                  <input class="test" type="range" min="1" max="5" step="1" value="0" style="width: 200px" name="answer[]">
                  <input value="{{ $question->id }}" name="question_id[]" type="hidden">
                  <input value="{{ $menu->restaurant->id }}" name="restaurant_id" type="hidden">
               </span>
               <br>
               @endif
               @endforeach


               {{--//////// أترك تعليق ////////--}}
               <div class="form-group mx-2 mt-3">
                  <textarea class="form-control " style="direction: rtl" id="exampleFormControlTextarea1" rows="2" placeholder="رأيك يهمنا"  name="feedback"></textarea>
                  <input value="{{ $menu->restaurant->id }}" name="restaurant_id" type="hidden">
               </div>
               <button id="feedbackButton_ar" type="button" class="btn btn-primary btn-sm" disabled>Send  feedback</button>


            </div>
         </form>
         @endif


         {{--//////// المطعم ////////--}}
         <div class="restaurantInfo px-2 py-4 mb-2">
            <div class="row">
               <div class="col-8 pr-0 text-right">
                  <h4 class="mt-1">{{ $menu->restaurant->name_ar }}</h4>
                  <span>{{ $menu->restaurant->description_ar }}</span>
               </div>
               <div class="col-4 text-center">
                  <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/restauranLogo') . '/'. $menu->restaurant->logo}}" alt="">
               </div>
            </div>
         </div>


         {{--//////// الاعلان اعلى الفيو ////////--}}
         @if(strlen($menu->restaurant->top_ad) > 2)
         <div class="card card-body py-0" id="TopAdss_ar">
            <span class="close_ar text-right mb-2" aria-hidden="true">&times;</span>
            @foreach ($menu->restaurant->top_ad as $ad)
            @if($ad->is_visible == 1 && $ad->main == 1)
            <a href="{{ $ad->ad_link }}" target="_blank"><img src="{{asset('assets/images/topAdPhoto').'/'.$ad->photo}}"></a>
            @elseif(($ad->is_visible == 1 && $ad->main == 0))
            <iframe width="420" height="315" src="{{ $ad->video_url }}">
            </iframe>
            @endif
            @endforeach
         </div>
         @endif


         {{--//////// الاقسام والوجبات ////////--}}
         @foreach (($menu->categories)->sortBy('sort_no') as $category)
         @if($category->is_visible == 1)
         <div class="accordion" id="accordionExample">
            <div class="card">


               {{--//////// الاقسام ////////--}}
               <div class="card-header py-2" id="ABCD{{ $category->id }}">
                  <div class="text-right" data-toggle="collapse" data-target="#ABD{{ $category->id }}" aria-expanded="true" aria-controls="ABD{{ $category->id }}">
                     <div class="row">
                        <div class="col-8 px-1 text-right category">
                           <h6>{{ $category->name_ar }}</h6>
                           <span>{{ $category->description_ar }}</span>
                        </div>
                        <div class="col-4 text-center">
                           <img data-toggle="modal" data-target=".bd-example-modal-lg" src="{{asset('assets/images/categoryPhoto') . '/'. $category->photo}}" alt="">
                        </div>
                     </div>
                  </div>
               </div>


               {{--//////// الوجبات ////////--}}
               <div id="ABD{{ $category->id }}" class="collapse text-right" aria-labelledby="ABCD{{ $category->id }}" data-parent="#accordionExample">
                  <div class="card-body">
                     @foreach (($category->items)->sortBy('sort_no') as $item)
                     @if($item->is_visible == 1)
                     <div class="row py-2" style="border-bottom: #f1f1f1 1px solid">
                        <div class="col-4 text-left ">
                           <img data-toggle="modal" data-target=".bd-example-modal-lg" class="mt-1" src="{{asset('assets/images/itemPhoto') . '/'. $item->photo}}" alt="">
                        </div>
                        <div class="col-8 px-4 ml-0 pl-0">
                           <h6 class="m-0 p-0 mb-1">{{ $item->name_ar }}</h6>
                           <span class="description">{{ $item->description_ar }}</span><br>
                           ج.م <span class="mt-2 d-inline-block font-bold">{{ $item->price }}</span>
                        </div>
                     </div>
                     @endif
                     @endforeach
                  </div>
               </div>


            </div>
         </div>
         @endif
         @endforeach
      </div>
   </div>


   {{--///////////============================= modals and plugins =============================////////////--}}

   <!--//////// thanxs modal ////////-->
   <div class="modal fade bd-example-modal-sm" id="thanxModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm">
         <div class="modal-content py-5 px-2 text-center">
            <img src="{{asset('assets/images/feedback/1.jpg')}}">
         </div>
      </div>
   </div>

   <!--//////// View images modal ////////-->
   <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content text-center d-inline-block">
            <img data-toggle="modal" data-target=".bd-example-modal-lg" src="" id="targetImage" alt="" class="img-fluid">
         </div>
      </div>
   </div>

   <!--//////// pop up ad ////////-->
   @if(strlen($menu->restaurant->popup_ad) > 2)
   <div class="modal fade bd-example-modal-lg " id="popUpad" tabindex="-1" role="dialog" aria-labelledby="myLargseModalLabel" aria-hidden="true">
      <div class="modal-dialog modal-lg">
         <div class="modal-content text-center d-inline-block">
            @foreach ($menu->restaurant->popup_ad as $ad)
            @if($ad->is_visible == 1 && $ad->main == 1)
            <a href="{{ $ad->ad_link }}" target="_blank"> <img src="{{asset('assets/images/popUpAdPhoto').'/'.$ad->photo}}"></a>
            @elseif(($ad->is_visible == 1 && $ad->main == 0))
            <iframe width="420" height="315" src="{{ $ad->video_url }}">
            </iframe>
            @endif
            @endforeach
         </div>
      </div>
   </div>
   @endif


    {{--================== scripts ==================--}}

    <script src="{{asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('assets/js/clientViewScript.js')}}"></script>

    <script>

        // send  english feedback
            $('#feedbackButton').on('click', function(e) {
           e.preventDefault();

           // Reset all errors
           $('#branch_id_error').text('');


           var formData = new FormData($('#AddNewAnswerForm')[0]);

           $.ajax({
               type: 'post'
               , enctype: 'multipart/form-data'
               , url: '{{route('createAnswer')}}'
               , data: formData
               , processData: false
               , contentType: false
               , cache: false
               , success: function(data) {
                $('#thanxModal').modal('show');
                                 $('#AddNewAnswerForm_ar').fadeOut(200);
                                $('#AddNewAnswerForm').fadeOut(200);
                                $('#feedbackFormButton_ar').fadeOut(200);
                                $('#feedbackFormButton').fadeOut(200);
               }
               , error: function(reject) {
                alert('fail')
                   var response = $.parseJSON(reject.responseText);
                   $.each(response.errors, function(key, val) {
                       $("#" + key + "_error").text(val[0]);
                   });
               }
           });
       });

    // send  arabic feedback
            $('#feedbackButton_ar').on('click', function(e) {
           e.preventDefault();

           // Reset all errors
           $('#branch_id_error').text('');


           var formData = new FormData($('#AddNewAnswerForm_ar')[0]);

           $.ajax({
               type: 'post'
               , enctype: 'multipart/form-data'
               , url: '{{route('createAnswer')}}'
               , data: formData
               , processData: false
               , contentType: false
               , cache: false
               , success: function(data) {
                $('#thanxModal').modal('show');
                                $('#AddNewAnswerForm_ar').fadeOut(200);
                                $('#AddNewAnswerForm').fadeOut(200);
                                $('#feedbackFormButton_ar').fadeOut(200);
                                $('#feedbackFormButton').fadeOut(200);
               }
               , error: function(reject) {
                alert('fail')
                   var response = $.parseJSON(reject.responseText);
                   $.each(response.errors, function(key, val) {
                       $("#" + key + "_error").text(val[0]);
                   });
               }
           });
       });




       $('#feedbackButton').on('click' , function(){
           $('#AddNewAnswerForm_ar').fadeOut(200);
           $('#AddNewAnswerForm').fadeOut(200);
           $('#feedbackFormButton_ar').fadeOut(200);
           $('#feedbackFormButton').fadeOut(200);
       })

       $('#feedbackButton_ar').on('click' , function(){
        $('#AddNewAnswerForm_ar').fadeOut(200);
           $('#AddNewAnswerForm').fadeOut(200);
           $('#feedbackFormButton_ar').fadeOut(200);
           $('#feedbackFormButton').fadeOut(200);
       })



        $(document).ready(function () {

            var emojis = ['', '😠', '😦', '😑', '😀', '😍'];

            $(".test:nth(0)").change(function () {
                var i = $(this).val();
                $(".emoji:nth(0)").html(emojis[i]);
            });
            $(".test:nth(1)").change(function () {
                var i = $(this).val();
                $(".emoji:nth(1)").html(emojis[i]);
            });

            $(".test:nth(2)").change(function () {
                var i = $(this).val();
                $(".emoji:nth(2)").html(emojis[i]);
            });
            $(".test:nth(3)").change(function () {
                var i = $(this).val();
                $(".emoji:nth(3)").html(emojis[i]);
            });
            $(".test:nth(4)").change(function () {
                var i = $(this).val();
                $(".emoji:nth(4)").html(emojis[i]);
            });
            $(".test:nth(5)").change(function () {
                var i = $(this).val();
                $(".emoji:nth(5)").html(emojis[i]);
            });


        $('#AddNewAnswerForm').hide();
        $('#AddNewAnswerForm_ar').hide();

        })
        $('#branchesList').on('change', function () {
            $('#feedbackButton').removeAttr('disabled');
        })


        $('#branchesList_ar').on('change', function () {
            $('#feedbackButton_ar').removeAttr('disabled');
        })


        $('#feedbackFormButton').on('click' ,function(){

        $('#AddNewAnswerForm').fadeToggle(500);
        })


        $('#feedbackFormButton_ar').on('click' ,function(){

        $('#AddNewAnswerForm_ar').fadeToggle(500);
        })

    </script>
</body>
@endforeach

</html>
