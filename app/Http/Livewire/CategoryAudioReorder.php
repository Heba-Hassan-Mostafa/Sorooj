<?php

namespace App\Http\Livewire;

use App\Enum\CategoryTypeEnum;
use App\Models\Category;
use Livewire\Component;

class CategoryAudioReorder extends Component
{
    public function render()
    {
        return view('livewire.category-audio-reorder',[

                'categories' => Category::where('type',CategoryTypeEnum::AUDIO)->where('parent_id',null)
                    ->orderBy('order_position','asc')->get()

            ]
        );
    }

    public function updateAudioCategoryOrder($items)
    {
        foreach($items as $item)
        {

            Category::where('type',CategoryTypeEnum::AUDIO)->where('parent_id',null)
                ->find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
