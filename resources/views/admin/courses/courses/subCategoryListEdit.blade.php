@foreach($subcategories as $subcategory)
    <ul>
        <i class="fas fa-level-down-alt icon-path"></i>
        <label style="font-size: 16px;">
            <input type="radio" name="parent_id" value= "{{ $subcategory->id }}"
                {{ old('category_id',$course->category_id) == $subcategory->id ?'checked' : '' }}>


            {{ $subcategory->name }}</label>

        @if(count($subcategory->subcategory))
            @include('admin.courses.courses.subCategoryListEdit',['subcategories' => $subcategory->subcategory])
        @endif
    </ul>

@endforeach
