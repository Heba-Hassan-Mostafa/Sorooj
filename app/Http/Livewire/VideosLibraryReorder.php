<?php

namespace App\Http\Livewire;

use App\Models\Video;
use Livewire\Component;

class VideosLibraryReorder extends Component
{

    public function render()
    {

        return view('livewire.videos-library-reorder', [

            'videos' => Video::where('videoable_type','Video')->orderBy('order_position','asc')->get()
        ]);
    }

    public function updateVideoLibraryOrder($items)
    {
        //dd($items);

        foreach($items as $item)
        {
            Video::where('videoable_type','Video')->find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
