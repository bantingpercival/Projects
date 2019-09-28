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
                  @if (session('status'))
                    <div class="row">
                      <div class="col-sm-12">
                        <div class="alert alert-success">
                          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <i class="material-icons">close</i>
                          </button>
                          <span>{{ session('status') }}</span>
                        </div>
                      </div>
                    </div>
                  @endif
                  <form method="post" action="{{ route('store.exam_question') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <input name="id" type="hidden" value="{{ $category[0]->id }}"/>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                              <div class="form-group{{ $errors->has('question') ? ' has-danger' : '' }}">
                                <textarea class="form-control" name="question" id="" cols="30" rows="10"></textarea>
                                
                              </div>
                            </div>                      
                          </div>
                          @for ( $i =  0; $i < 5; $i++)
                          <div class="row">
                              <div class="col-md">
                                  <select class="form-control" name="answer[]" id="">
                                    
                                    <option value='0'>False</option>
                                    <option value='1'>True</option>
                                  </select>
                              </div>
                              <div class="col-md-10">
                                <div class="form-group">
                                  <input class="form-control{{ $errors->has('Choices') ? ' is-invalid' : '' }}" name="choices[]" id="input-name" type="text" placeholder="{{ __('Choices') }}" value="{{ old('Choices') }}" />
                                  
                                </div>
                              </div>
                              
                          </div>
                          @endfor
                          
                          <div class="col text-right">
                            <button type="submit" class="btn btn-success">{{ __('Add') }}</button>
                          </div>
                    </div>
                   
                  </form>
                  
                  
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