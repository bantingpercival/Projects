@extends('layouts.admin', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ __($category[0]->categ_name) }}</h4>
                  <p class="card-category"> {{ __($category[0]->categ_instruction) }}</p>
                </div>
                <div class="card-body">
                  
                  @if (count($questions)>0)
                   @if ($category[0]->categ_name == 'multiple choice')
                   @foreach ($questions as $key => $data)
                  
                   <div class="card">
                       <div class="card-header card-header-success">
                         <h4 class="card-title ">{{ $key+=1 }} {{ $data['question'] }}</h4>
                         <p class="card-category"></p>
                       </div>
                       <div class="card-body">
                         <div class="form-group">
                           @foreach ($data['choices'] as $choice )
                           
                               <div class="">
                                 <input type="radio" name="answer[{{ $data['question_id'] }}]" value="{{ $choice->cId }}"> {{ $choice->choice }} <br>
                               </div>
                               
                           @endforeach
                         </div>
                       </div>
                   </div>
                 @endforeach
                   @else
                   @foreach ($questions as $key => $data)
                  
                   <div class="card">
                       <div class="card-header card-header-success">
                         <h4 class="card-title ">{{ $key+=1 }} {{ $data['question'] }}</h4>
                         <p class="card-category"></p>
                       </div>
                       <div class="card-body">
                         <div class="form-group">
                           @foreach ($data['choices'] as $choice )
                                <form action="/exam/update" method="post" class="row">
                                  @csrf
                                    @method('post')
                                
                                  <input type="hidden" name="id" value="{{ $choice->cId }}">
                                  <input type="text" name ="input" value="{{ $choice->choice }}" class="col-md form-control">
                                  <button type="submit" class="btn btn-success col-md-3">Change</button>
                                  
                                  @if ($choice->answer == 0)
                                    <a href="/exam/update/{{ $choice->cId }}" class="btn btn-info">Active</a>
                                  @else
                                      
                                  @endif
                                </form>
                               {{-- <div class="">
                                 <input type="radio" name="answer[{{ $data['question_id'] }}]" value="{{ $choice->cId }}"> {{ $choice->choice }} <br>
                               </div> --}}
                               
                           @endforeach
                         </div>
                       </div>
                   </div>
                 @endforeach
                   @endif
                   
                  @endif
                  
                  
                    
                </div>
              </div>
          </div>
      </div>
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush