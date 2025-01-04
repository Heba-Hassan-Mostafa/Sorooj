<?php

namespace App\Http\Livewire;

use App\Models\Audio;
use Livewire\Component;

class AudiosLibraryReorder extends Component
{

    public function render()
    {

        return view('livewire.audios-library-reorder', [

            'audios' => Audio::where('audioable_type','Audio')->orderBy('order_position','asc')->get()
        ]);
    }

    public function updateAudioLibraryOrder($items)
    {
        foreach($items as $item)
        {
            Audio::where('audioable_type','Audio')->find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
