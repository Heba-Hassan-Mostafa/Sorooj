<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.courses.course-category-name') }}</th>
            <th>{{ trans('dashboard.courses.course-count') }}</th>
            <th>{{ trans('dashboard.created_at') }}</th>
            <th>{{ trans('dashboard.status') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateCourseCategoryOrder">
        @foreach ($categories as $category)
            <tr class="reOrder" wire:sortable.item="{{ $category->id }}" wire:key="course-{{ $category->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $category->name }}</td>
                <td>{{ $category?->courses?->count() ?? 0 }}</td>
                <td>{{ $category->created_at->format('Y-m-d') }}</td>

                <td>{{ $category->status() }}</td>


            </tr>
        @endforeach
        </tbody>
    </table>
</div>
