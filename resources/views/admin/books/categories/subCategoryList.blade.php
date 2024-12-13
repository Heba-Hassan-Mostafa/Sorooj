@foreach($subcategories as $subcategory)
    <ul>
        <i class="fas fa-level-down-alt icon-path"></i>
        <label style="font-size: 16px;">
            <input type="radio" name="parent_id" value= "{{ $subcategory->id }}">


            {{ $subcategory->name }}</label>

        @if(count($subcategory->subcategory))
            @include('admin.books.categories.subCategoryList',['subcategories' => $subcategory->subcategory])
        @endif
    </ul>

@endforeach
