<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.audios.audio_name') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateAudioLibraryOrder">
        @foreach ($audios as $audio)
            <tr class="reOrder" wire:sortable.item="{{ $audio->id }}" wire:key="audio-{{ $audio->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $audio->name }}</td>


            </tr>
        @endforeach
        </tbody>
    </table>
</div>

