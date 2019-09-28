@extends('layouts.student', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
        <div class="row"><div class="card">
            <div class="card-header card-header-success">
              <h4 class="card-title ">{{ __($category[0]->categ_name) }}</h4>
              <p class="card-category"> {{ __($category[0]->categ_instruction) }}</p>
            </div>
        </div>
        <form action="{{ route('store.answer') }}" method="post" autocomplete="off" class="form-horizontal">
          @csrf
          @method('post')
          @if ($category[0]->categ_name == ucwords('multiple choice') || $category[0]->categ_name == ucwords('Creativity'))
            <input type="hidden" value="{{ $category[0]->categ_name }}" name="type">
            <input type="hidden" value="{{ $category[0]->id }}" name="id">
            @foreach ($questions as $key => $data)
              <div class="card">
                  <div class="card-header card-header-success">
                    <h4 class="card-title ">{{ $key }}. {{ $data['question'] }}</h4>
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
          @elseif($category[0]->categ_name == ucwords('identification'))
            <input type="hidden" value="{{ $category[0]->categ_name }}" name="type">
            <input type="hidden" value="{{ $category[0]->id }}" name="id">
            @foreach ($questions as $key => $data)
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ $data['question'] }}</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md">
                      <div class="form-group">
                        <input type="text" class="form-control" name="operator[{{ $data['question_id'] }}]" placeholder="Operator">
                      </div>
                    </div>
                    <div class="col-md">
                      <div class="form-group">
                        <input type="text" class="form-control" name="name[{{ $data['question_id'] }}]" placeholder="Name">
                      </div>
                    </div>
                    
                  </div>
                </div>
              </div>
            @endforeach
          @elseif($category[0]->categ_name == ucwords('problem solving'))
            <input type="hidden" value="{{ $category[0]->categ_name }}" name="type">
            <input type="hidden" value="{{ $category[0]->id }}" name="id">
            @foreach ($questions as $key => $data)
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ $data['question'] }}</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md">
                      <div class="form-group">
                        <textarea class="form-control" name="answer[{{ $data['question_id'] }}]" id="" cols="30" rows="10"></textarea>
                        {{-- <input type="text" class="form-control" name="answer[]" placeholder="Operator"> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            @elseif($category[0]->categ_name == ucwords('problem solving') )
            <input type="hidden" value="{{ $category[0]->categ_name }}" name="type">
            <input type="hidden" value="{{ $category[0]->id }}" name="id">
            @foreach ($questions as $key => $data)
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ $data['question'] }}</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md">
                      <div class="form-group">
                        <textarea class="form-control" name="answer[{{ $data['question_id'] }}]" id="" cols="30" rows="10"></textarea>
                        {{-- <input type="text" class="form-control" name="answer[]" placeholder="Operator"> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            @elseif($category[0]->categ_name == ucwords('Identification Part 2') || $category[0]->categ_name == ucwords('Identification Part 1'))
            <input type="hidden" value="forICT" name="type">
            <input type="hidden" value="{{ $category[0]->id }}" name="id">
            @foreach ($questions as $key => $data)
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ $key+=1 }}. {{ $data['question'] }}</h4>
                  <p class="card-category"></p>
                </div>
                <div class="card-body">
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                        <input type="text" class="form-control" name="answer[{{ $data['question_id'] }}]" id="" placeholder="Enter your answer">
                        {{-- <input type="text" class="form-control" name="answer[]" placeholder="Operator"> --}}
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
          @endif
          <button type="submit" class="btn btn-success">Submit</button>
        </form>
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