@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.sidebar.audios-categories') }}
@endsection
@section('content')
    <h4 class="py-3">
        <a href="{{ route('admin.dashboard') }}">
            <span class="text-muted fw-light">{{ trans('dashboard.main') }}/
            </span>
        </a>
        {{ trans('dashboard.sidebar.audios-categories') }}
    </h4>
    <a href="{{ route('admin.audios.category.create') }}" class=" mainBtnStyle me-2 mb-2">
        {{ trans('dashboard.audios.add-audio-category') }}
    </a>
    <a href="{{ route('admin.audios.category.sort-categories') }}" class="btn btn-warning font-weight-bold p-2"
       role="button" aria-pressed="true"> <i style="font-size: 16px" class="fas fa-sort"></i>
        {{ trans('dashboard.change_order') }}</a>
    <div class="card mt-3">
        <div class="table-responsive p-2">
            <table class="myDatatable table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>{{ trans('dashboard.audios.audio-category-name') }}</th>
                    <th>{{ trans('dashboard.audios.audio-count') }}</th>
                    <th>{{ trans('dashboard.created_at') }}</th>
                    <th>{{ trans('dashboard.status') }}</th>
                    <th>{{ trans('dashboard.options') }}</th>

                </tr>
                </thead>
                <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $category->name }}</td>
                        <td>{{ $category?->audios?->count() ?? 0 }}</td>
                        <td>{{ $category->created_at->format('Y-m-d') }}</td>

                        <td>
                            <label class="switch switch-success" for="{{ $category->id }}">
                                <input type="checkbox" class="switch-input status" id="{{ $category->id }}"
                                       data-id="{{ $category->id }}" {{ $category->status == true ? 'checked' : '' }} />
                                <span class="switch-toggle-slider">
                                        <span class="switch-on">
                                            <i class="ti ti-check"></i>
                                        </span>
                                        <span class="switch-off">
                                            <i class="ti ti-x"></i>
                                        </span>
                                    </span>
                            </label>
                        </td>
                        <td>
                            <div class="m-2">
                                <a href="{{ route('admin.audios.category.edit',$category->id) }}"  class="btn btn-info btn-sm text-white"  title="{{ trans('dashboard.edit') }}">
                                    <i class="fa fa-edit"></i>
                                </a>

                                <a onclick="fireDeleteEvent({{ $category->id }})" type="button"
                                   title="{{ trans('dashboard.delete') }}" data-toggle="tooltip"
                                   class="btn btn-danger btn-sm text-white"><i class="fas fa-trash-alt"></i></a>

                                <form action="{{ route('admin.audios.category.destroy', $category->id) }}" method="POST"
                                      id="form-{{ $category->id }}">
                                    @csrf
                                    @method('Delete')
                                </form>
                            </div>
                        </td>

                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>

@endsection
@section('scripts')

    <script>
        $(function() {
            $('.myDatatable').off('change', '.status').on('change', '.status', function() {
                var status = $(this).prop('checked') === true ? 1 : 0;
                var id = $(this).data('id');
                console.log('Status:', status, 'ID:', id);

                $.ajax({
                    type: "GET",
                    dataType: "json",
                    url: '{{ route('admin.audios.category.change-status') }}',
                    data: {
                        'status': status,
                        'id': id
                    },
                    success: function(data) {
                        console.log(`Category: ${id} Status changed successfully.`);
                    },
                    error: function(xhr) {
                        console.error('Error:', xhr.responseText);
                    }
                });
            });
        });
    </script>

@endsection
