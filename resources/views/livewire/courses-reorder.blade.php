<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.courses.course_image') }}</th>
            <th>{{ trans('dashboard.courses.course_name') }}</th>
            <th>{{ trans('dashboard.courses.course_category') }}</th>
            <th>{{ trans('dashboard.courses.author_name') }}</th>
            <th>{{ trans('dashboard.courses.publish_date') }}</th>
            <th>{{ trans('dashboard.courses.view_count') }}</th>
            <th>{{ trans('dashboard.status') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateCourseOrder">
        @foreach ($courses as $course)
            <tr class="reOrder" style="cursor: pointer" wire:sortable.item="{{ $course->id }}" wire:key="course-{{ $course->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if (!empty($course->image))
                        <img src="{{ asset($course->image) }}" style="width:50px;height:50px;"  alt=""/>
                    @else
                        <img src="{{ asset('assets/admin/images/courses.webp') }}" style="width:50px;height:50px;"  alt=""/>
                    @endif

                </td>
                <td>{{ $course->course_name }}</td>
                <td>{{ $course->category?->name }}</td>
                <td>{{ $course->author_name }}</td>
                <td>{{ $course->publish_date }}</td>
                <td>{{ $course->view_count ?? 0 }}</td>

                <td>{{  $course->status() }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

