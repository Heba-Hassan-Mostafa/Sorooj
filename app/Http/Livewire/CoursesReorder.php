<?php

namespace App\Http\Livewire;

use App\Models\Course;
use Livewire\Component;

class CoursesReorder extends Component
{
    public function render()
    {
        return view('livewire.courses-reorder',[

            'courses' => Course::orderBy('order_position','asc')->get()

        ]);
    }

    public function updateCourseOrder($items)
    {
        //dd($items);

        foreach($items as $item)
        {

            Course::find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
