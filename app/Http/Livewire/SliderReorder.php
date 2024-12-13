<?php

namespace App\Http\Livewire;

use App\Models\Slider;
use Livewire\Component;

class SliderReorder extends Component
{
    public function render()
    {
        return view('livewire.slider-reorder',[

            'sliders' => Slider::orderBy('order_position','asc')->get()

        ]);
    }

    public function updateSliderOrder($items)
    {

        foreach($items as $item)
        {

            Slider::find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
