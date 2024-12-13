<?php

namespace App\Http\Livewire;

use App\Enum\CategoryTypeEnum;
use App\Models\Category;
use Livewire\Component;

class CategoryBookReorder extends Component
{
    public function render()
    {
        return view('livewire.category-book-reorder',[

                'categories' => Category::where('type',CategoryTypeEnum::BOOK)->where('parent_id',null)
                    ->orderBy('order_position','asc')->get()

            ]
        );
    }

    public function updateBookCategoryOrder($items)
    {
        foreach($items as $item)
        {

            Category::where('type',CategoryTypeEnum::BOOK)->where('parent_id',null)
                ->find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
