@extends('layouts.admin', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ __('Create Exam') }}</h4>
                  <p class="card-category"> {{ __('') }}</p>
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
                  <form method="post" action="{{ route('store.exam') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="row">
                        <div class="col-md">
                            <div class="form-group{{ $errors->has('exam_name') ? ' has-danger' : '' }}">
                              <input class="form-control{{ $errors->has('exam_name') ? ' is-invalid' : '' }}" name="exam_name" id="input-name" type="text" placeholder="{{ __('Exam Name') }}" value="{{ old('exam_name') }}" required="true" aria-required="true"/>
                              @if ($errors->has('exam_name'))
                                <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('exam_name') }}</span>
                              @endif
                            </div>
                          </div>
                      <div class="col-md">
                        <div class="form-group{{ $errors->has('section_id') ? ' has-danger' : '' }}">
                          <select name="section_id" id="" class="form-control{{ $errors->has('section_id') ? ' is-invalid' : '' }}">
                            <option >Select Section</option>
                            @foreach ($sections as $data)
                            <option value="{{ $data->id }}">{{ $data->section_name }}</option>
                            @endforeach
                            
                          </select>
                          @if ($errors->has('section_id'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('section_id') }}</span>
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

                      <div class="col text-right">
                        <button type="submit" class="btn btn-sm btn-success">{{ __('Add') }}</button>
                      </div>
                    </div>
                  </form>
                  
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-success">
                          <th>
                              {{ __('Exam') }}
                          </th>
                        <th>
                            {{ __('Section') }}
                        </th>
                        <th>
                            {{ __('Number Item') }}
                        </th>
                        <th class="text-right">
                          {{ __('Actions') }}
                        </th>
                      </thead>
                      <tbody>
                          @foreach($exams as $data_1)
                          <tr>
                            <td>
                              {{ $data_1->exam_name }}
                            </td>
                            <td>
                              {{ $data_1->section_name }}
                            </td>
                            <td>
                                {{ $data_1->item_number }} item's
                              </td>
                            <td class="td-actions text-right">

                                <form action="{{--  {{ route('user.destroy', $user) }}  --}}" method="post">
                                    @csrf
                                    @method('delete')
                                
                                    <a rel="tooltip" class="btn btn-success btn-link" href="/exam/{{ $data_1->id }}" data-original-title="" title="">
                                      <i class="material-icons">view</i>
                                      <div class="ripple-container">view</div>
                                    </a>
                                    {{-- <a rel="tooltip" class="btn btn-success btn-link" href="/exam/update/{{ $data_1->id }}" data-original-title="" title="">
                                      <i class="material-icons">update</i>
                                      <div class="ripple-container">update</div>
                                    </a> --}}
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