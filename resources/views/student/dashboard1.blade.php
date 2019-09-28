@extends('layouts.student', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      @if (!$user)
        <div class="row">
          <div class="col-md">
              <div class="card">
                  <div class="card-header card-header-info">
                    <h4 class="card-title ">{{ __('Sections') }}</h4>
                    <p class="card-category"> {{ __('Tap your Section') }}</p>
                  </div>
                  <div class="card-body">
                    @foreach ($section as $data)
                      <a href="/user/{{ Auth::id() }}/{{ $data->id }}" class="btn btn-block btn-default">{{ $data->section_name }}</a>
                    @endforeach
                  </div>
              </div>
          </div>
        </div>
      @else
        <div class="row">
          @foreach ($exam as $key => $data)
          <div class="col-lg-3 col-md-6 col-sm-6">
            <a href="/exam/question/{{ $data->id }}">
              <div class="card card-stats">
                <div class="card-header card-header-info card-header-icon">
                  <div class="card-icon">
                    <i class="fa fa-clipboard"></i>
                  </div>
                </div>
                <div class="card-body">
                    <div class="h2">{{ $data->exam_name }}</div>
                </div>
                <div class="card-footer">
                  <div class="stats">Tap to take your exam</div>
                </div>
              </div>
            </a>
          </div>
            {{-- @if ($data->id == $complete[$key]['id'])
              @if ($complete[$key]['completed'])
                <div class="col-lg-3 col-md-6 col-sm-6">
                  
                    <div class="card card-stats">
                      <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                          <i class="fa fa-clipboard"></i>
                        </div>
                        <p class="card-category">{{ $data->categ_name }}</p>
                        <h3 class="card-title">{{  $data->item_number}} Items</h3>
                      </div>
                      <div class="card-body">
                          <div class="">{{ $data->categ_instruction }}</div>
                      </div>
                      <div class="card-footer">
                        <div class="stats">This Category is Finish</div>
                      </div>
                    </div>
                </div>
              @else
                <div class="col-lg-3 col-md-6 col-sm-6">
                  <a href="/questions/{{ $data->id }}">
                    <div class="card card-stats">
                      <div class="card-header card-header-info card-header-icon">
                        <div class="card-icon">
                          <i class="fa fa-clipboard"></i>
                        </div>
                        <p class="card-category">{{ $data->categ_name }}</p>
                        <h3 class="card-title">{{  $data->item_number}} Items</h3>
                      </div>
                      <div class="card-body">
                          <div class="">{{ $data->categ_instruction }}</div>
                      </div>
                      <div class="card-footer">
                        <div class="stats">Tap to take your exam</div>
                      </div>
                    </div>
                  </a>
                </div>
              @endif
            @endif --}}
            
          @endforeach
            
        </div>
      @endif
      
      
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