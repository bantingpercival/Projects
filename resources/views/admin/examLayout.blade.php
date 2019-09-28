@extends('layouts.admin', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ __($exams[0]->section_name) }}</h4>
                  <p class="card-category"> {{ __($exams[0]->exam_name) }}</p>
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
                  <form method="post" action="{{ route('store.exam_categ') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <input name="id" type="hidden" value="{{ $exams[0]->id }}"/>
                              
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group{{ $errors->has('categ_name') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('categ_name') ? ' is-invalid' : '' }}" name="categ_name" id="input-name" type="text" placeholder="{{ __('Exam Name') }}" value="{{ old('categ_name') }}" required="true" aria-required="true"/>
                              @if ($errors->has('categ_name'))
                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('categ_name') }}</span>
                              @endif
                            </div>
                          </div>
                      <div class="col-md">
                        <div class="form-group{{ $errors->has('item') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('item') ? ' is-invalid' : '' }}" name="item" id="input-name" type="text" placeholder="{{ __('Item Number') }}" value="{{ old('item') }}" required="true" aria-required="true"/>
                          @if ($errors->has('item'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group{{ $errors->has('score') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('score') ? ' is-invalid' : '' }}" name="score" id="input-name" type="text" placeholder="{{ __('Score Number') }}" value="{{ old('score') }}" required="true" aria-required="true"/>
                          @if ($errors->has('score'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('score') }}</span>
                          @endif
                        </div>
                      </div>

                      
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                          <div class="form-group{{ $errors->has('instruction') ? ' has-danger' : '' }}">
                            <input class="form-control{{ $errors->has('instruction') ? ' is-invalid' : '' }}" name="instruction" id="input-name" type="text" placeholder="{{ __('Instruction') }}" value="{{ old('instruction') }}" required="true" aria-required="true"/>
                            @if ($errors->has('instruction'))
                              <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('instruction') }}</span>
                            @endif
                          </div>
                        </div>
                        <div class="col text-right">
                            <button type="submit" class="btn btn-sm btn-success">{{ __('Add') }}</button>
                          </div>
                    </div>
                  </form>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-success">
                          <th>
                              {{ __('Category') }}
                          </th>
                        <th>
                            {{ __('Item Number') }}
                        </th>
                        <th>
                            {{ __('Points') }}
                        </th>
                        <th class="text-right">
                          {{ __('Actions') }}
                        </th>
                      </thead>
                      <tbody>
                          @foreach($category as $data_1)
                          <tr>
                            <td>
                              {{ $data_1->categ_name }}
                            </td>
                            <td>
                              {{ $data_1->item_number }} item's
                            </td>
                            <td>
                                {{ $data_1->item_points }} point's
                              </td>
                            <td class="td-actions text-right">

                                <form action="{{--  {{ route('user.destroy', $user) }}  --}}" method="post">
                                    @csrf
                                    @method('delete')
                                
                                    <a rel="tooltip" class="btn btn-success btn-link" href="/exam/questionner/{{ $data_1->id }}" data-original-title="" title="">
                                      <i class="material-icons">view</i>
                                      <div class="ripple-container">view</div>
                                    </a>
                                    <a rel="tooltip" class="btn btn-info btn-link" href="/exam/{{  $exams[0]->id}}/question/{{ $data_1->id }}" data-original-title="" title="">
                                      <i class="material-icons">view</i>
                                      <div class="ripple-container">add</div>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-link" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                        <i class="material-icons">close</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                </form>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div>
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