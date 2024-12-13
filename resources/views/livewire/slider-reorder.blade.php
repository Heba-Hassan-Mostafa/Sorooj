<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.slider.image') }}</th>
            <th>{{ trans('dashboard.slider.title') }}</th>
            <th>{{ trans('dashboard.slider.link') }}</th>
            <th>{{ trans('dashboard.slider.created_at') }}</th>
            <th>{{ trans('dashboard.status') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateSliderOrder">
        @foreach ($sliders as $slider)
            <tr class="reOrder" wire:sortable.item="{{ $slider->id }}" wire:key="slider-{{ $slider->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if (!empty($slider->image))
                        <img src="{{ asset($slider->image) }}" style="width:50px;height:50px;"  alt=""/>
                    @else
                        <img src="{{ asset('assets/admin/images/default_slider.webp') }}" style="width:50px;height:50px;"  alt=""/>
                    @endif

                </td>
                <td>{{ $slider->title ?? '-----' }}</td>
                <td>{{ $slider->link ?? '-----' }}</td>
                <td>{{ $slider->created_at?->format('Y-m-d') }}</td>
                <td>{{  $slider->status() }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

