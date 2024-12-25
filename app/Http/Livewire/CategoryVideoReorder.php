<?php

namespace App\Http\Livewire;

use App\Enum\CategoryTypeEnum;
use App\Models\Category;
use Livewire\Component;

class CategoryVideoReorder extends Component
{
    public function render()
    {
        return view('livewire.category-video-reorder',[

                'categories' => Category::where('type',CategoryTypeEnum::VIDEO)->where('parent_id',null)
                    ->orderBy('order_position','asc')->get()

            ]
        );
    }

    public function updateVideoCategoryOrder($items)
    {
        foreach($items as $item)
        {

            Category::where('type',CategoryTypeEnum::VIDEO)->where('parent_id',null)
                ->find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
