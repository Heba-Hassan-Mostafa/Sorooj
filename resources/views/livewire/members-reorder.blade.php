<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.image') }}</th>
            <th>{{ trans('dashboard.members.name') }}</th>
            <th>{{ trans('dashboard.members.position') }}</th>
            <th>{{ trans('dashboard.status') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateMembersOrder">
        @foreach ($members as $member)
            <tr class="reOrder" wire:sortable.item="{{ $member->id }}" wire:key="member-{{ $member->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if (!empty($member->avatar))
                        <img src="{{ asset($member->avatar) }}" style="width:50px;height:50px;"  alt=""/>
                    @else
                        <img src="{{ asset('assets/avatar.jpg') }}" style="width:50px;height:50px;" />
                    @endif

                </td>
                <td>{{ $member->name }}</td>
                <td>{{ $member->position }}</td>
                <td>{{ $member->status() }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

