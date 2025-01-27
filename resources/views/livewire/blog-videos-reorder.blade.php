<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.blogs.video_name') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateBlogVideoOrder">
        @foreach ($blog_videos as $video)
            <tr class="reOrder" wire:sortable.item="{{ $video->id }}" wire:key="video-{{ $video->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $video->name }}</td>


            </tr>
        @endforeach
        </tbody>
    </table>
</div>

