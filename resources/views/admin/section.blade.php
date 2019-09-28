@extends('layouts.admin', ['activePage' => 'section', 'titlePage' => __('Section')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ __('Section') }}</h4>
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
                  <form method="post" action="{{ route('store.section') }}" autocomplete="off" class="form-horizontal">
                    @csrf
                    @method('post')
                    <div class="row">
                      <div class="col-sm-4">
                        <div class="form-group{{ $errors->has('section_name') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('section_name') ? ' is-invalid' : '' }}" name="section_name" id="input-name" type="text" placeholder="{{ __('Section') }}" value="{{ old('name') }}" required="true" aria-required="true"/>
                          @if ($errors->has('section_name'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('section_name') }}</span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group{{ $errors->has('section_grade') ? ' has-danger' : '' }}">
                          <input class="form-control{{ $errors->has('section_grade') ? ' is-invalid' : '' }}" name="section_grade" id="input-name" type="text" placeholder="{{ __('Grade  ') }}" value="{{ old('name') }}" required="true" aria-required="true"/>
                          @if ($errors->has('section_grade'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('section_grade') }}</span>
                          @endif
                        </div>
                      </div>
                      <div class="col-md">
                        <div class="form-group{{ $errors->has('subject_id') ? ' has-danger' : '' }}">
                          <select class="form-control{{ $errors->has('subject_id') ? ' is-invalid' : '' }}"  name="subject_id" id="input-name">
                            @foreach ($subject as $data)
                                <option value={{ $data->id }}>{{ $data->subject_name }}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('subject_id'))
                            <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('subject_id') }}</span>
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
                            {{ __('Section name') }}
                        </th>
                        <th>
                            {{ __('Grade') }}
                        </th>
                        <th>
                            {{ __('Subject') }}
                        </th>
                        <th class="text-right">
                          {{ __('Actions') }}
                        </th>

                      </thead>
                      <tbody>
                       @foreach($sections as $section)
                          <tr>
                            <td>
                              {{ $section->section_name }}
                            </td>
                            <td>
                              {{ $section->section_grade }}
                            </td>
                            <td>
                              
                            </td>
                            <td class="td-actions text-right">
                              @if (/* $user->id !=  */auth()->id())
                                <form action="{{--  {{ route('user.destroy', $user) }}  --}}" method="post">
                                    @csrf
                                    @method('delete')
                                
                                    <a rel="tooltip" class="btn btn-success btn-link" href="{{--  {{ route('user.edit', $user) }}  --}}" data-original-title="" title="">
                                      <i class="material-icons">edit</i>
                                      <div class="ripple-container"></div>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-link" data-original-title="" title="" onclick="confirm('{{ __("Are you sure you want to delete this user?") }}') ? this.parentElement.submit() : ''">
                                        <i class="material-icons">close</i>
                                        <div class="ripple-container"></div>
                                    </button>
                                </form>
                              @else
                                <a rel="tooltip" class="btn btn-success btn-link" href="{{ route('profile.edit') }}" data-original-title="" title="">
                                  <i class="material-icons">edit</i>
                                  <div class="ripple-container"></div>
                                </a>
                              @endif
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