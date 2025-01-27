<?php

namespace App\Http\Livewire;

use App\Models\Course;
use App\Models\Video;
use Livewire\Component;

class VideosReorder extends Component
{
    public Course $course;

    public function mount(Course $course)
    {
        $this->course = $course;
    }
    public function render()
    {

        return view('livewire.videos-reorder', [

            'videos' => $this->course->videos()
                ->orderBy('order_position', 'asc')
                ->get(),
        ]);
    }

    public function updateVideoOrder($items)
    {
        //dd($items);

        foreach($items as $item)
        {
            Video::where('videoable_type','Course')->find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
