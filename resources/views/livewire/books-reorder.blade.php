<div class="table-responsive p-2" wire:ignore>
    <table class="table table-bordered">
        <thead>
        <tr>
            <th>#</th>
            <th>{{ trans('dashboard.books.book_image') }}</th>
            <th>{{ trans('dashboard.books.book_name') }}</th>
            <th>{{ trans('dashboard.books.book_category') }}</th>
            <th>{{ trans('dashboard.books.author_name') }}</th>
            <th>{{ trans('dashboard.books.publish_date') }}</th>
            <th>{{ trans('dashboard.books.view_count') }}</th>
            <th>{{ trans('dashboard.books.download_count') }}</th>
            <th>{{ trans('dashboard.status') }}</th>

        </tr>
        </thead>
        <tbody wire:sortable="updateBookOrder">
        @foreach ($books as $book)
            <tr class="reOrder" wire:sortable.item="{{ $book->id }}" wire:key="book-{{ $book->id }}"
                wire:sortable.handle>
                <td>{{ $loop->iteration }}</td>
                <td>
                    @if (!empty($book->image))
                        <img src="{{ asset($book->image) }}" style="width:50px;height:50px;"  alt=""/>
                    @else
                        <img src="{{ asset('assets/admin/images/book.jpg') }}" style="width:50px;height:50px;"  alt=""/>
                    @endif

                </td>
                <td>{{ $book->book_name }}</td>
                <td>{{ $book->category?->name }}</td>
                <td>{{ $book->author_name }}</td>
                <td>{{ $book->publish_date }}</td>
                <td>{{ $book->view_count ?? 0 }}</td>
                <td>{{ $book->download_count ?? 0 }}</td>
                <td>{{  $book->status() }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
</div>

