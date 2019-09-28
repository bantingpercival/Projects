@extends('layouts.admin', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ $student_result['name'] }}</h4>
                  <p class="card-category"> Total Exam: {{ $student_result['exam_score'] }}</p>
                </div>
                <div class="card-body">
                  @foreach ($student_result['result_exam'] as $result)
                    <h4 class="text-success">{{ $result['categ_name'] }}: {{ $result['instruction'] }}</h4>
                    @foreach ($result['questions'] as $key => $question)
                        <P>
                          @if ($question->CORRECT_ANSWER == $question->CHOICE_ANSWER)
                            <span class="text-info"><b>{{ $key+=1 }}
                          @else
                          <span class="text-danger"><b>{{ $key+=1 }}
                            
                          @endif.</b></span> {{ $question->EXAM_QUESTION }}</P>
                        <p>
                          @if ($question->CORRECT_ANSWER == $question->CHOICE_ANSWER)
                            <span class="text-success">{{ $question->CHOICE_ANSWER }}</span>
                          @else
                          <p class="text-success">Correct Answer: {{ $question->CORRECT_ANSWER }}</p>
                            <p class="text-danger">Your Answer: {{ $question->CHOICE_ANSWER }}</p>
                            
                          @endif
                         
                        </p>
                    @endforeach
                  @endforeach
                  
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