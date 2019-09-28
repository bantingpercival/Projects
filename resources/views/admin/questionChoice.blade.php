@extends('layouts.admin', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          @foreach ($answer as $item)
            <div class="col-md-3 col-sm-3">
            <div class="card">
              <div class="card-header card-header-success">
                <h4 class="card-title ">{{ $item->exam_choice }}</h4>
              </div>
            </div>
            </div>
          @endforeach
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