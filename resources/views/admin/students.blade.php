.@extends('layouts.admin', ['activePage' => 'section', 'titlePage' => __('Section')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-md-12">
              <div class="card">
                <div class="card-header card-header-success">
                  <h4 class="card-title ">{{ __('Students') }}</h4>
                  <p class="card-category"> {{ __('') }}</p>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead class=" text-success">
                        <th>
                            {{ __('Name') }}
                        </th>
                        <th>
                            {{ __('Status') }}
                        </th>
                        <th>
                            {{ __('Score') }}
                        </th>
                        <th class="text-right">
                          {{ __('Actions') }}
                        </th>

                      </thead>
                      <tbody>
                       @foreach($students as $student)
                          <tr>
                            <td>
                              {{ ucwords($student['name']) }}
                            </td>
                            <td>
                              {{ $student['score'] }}
                            </td>
                            <td>
                              
                            </td>
                            <td class="td-actions text-right">
                                <form action="{{--  {{ route('user.destroy', $user) }}  --}}" method="post">
                                    @csrf
                                    @method('delete')
                                
                                    <a rel="tooltip" class="btn btn-success btn-link" href="/student/answer/4/{{ $student['id'] }}" data-original-title="" title="">
                                      <i class="material-icons">view</i>
                                      <div class="ripple-container">view</div>
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