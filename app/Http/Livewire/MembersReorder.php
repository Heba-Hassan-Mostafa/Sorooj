<?php

namespace App\Http\Livewire;

use App\Models\ManagementMember;
use Livewire\Component;

class MembersReorder extends Component
{
    public function render()
    {
        return view('livewire.members-reorder',[

            'members' => ManagementMember::orderBy('order_position','asc')->get()

        ]);
    }

    public function updateMembersOrder($items)
    {
        //dd($items);

        foreach($items as $item)
        {

            ManagementMember::find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
