<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.blogs.blog_image') }}</th>
            <th>{{ trans('dashboard.blogs.blog_name') }}</th>
            <th>{{ trans('dashboard.blogs.blog_category') }}</th>
            <th>{{ trans('dashboard.blogs.publish_date') }}</th>
            <th>{{ trans('dashboard.blogs.view_count') }}</th>
            <th>{{ trans('dashboard.blogs.download_count') }}</th>
            <th>{{ trans('dashboard.status') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateBlogOrder">
        @foreach ($blogs as $blog)
            <tr class="reOrder" wire:sortable.item="{{ $blog->id }}" wire:key="blog-{{ $blog->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if (!empty($blog->image))
                        <img src="{{ asset($blog->image) }}" style="width:50px;height:50px;"  alt=""/>
                    @else
                        <img src="{{ asset('assets/admin/images/blogs.webp') }}" style="width:50px;height:50px;"  alt=""/>
                    @endif

                </td>
                <td>{{ $blog->blog_name }}</td>
                <td>{{ $blog->category?->name }}</td>
                <td>{{ $blog->author_name }}</td>
                <td>{{ $blog->publish_date }}</td>
                <td>{{ $blog->view_count ?? 0 }}</td>
                <td>{{ $blog->download_count ?? 0 }}</td>
                <td>{{  $blog->status() }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

