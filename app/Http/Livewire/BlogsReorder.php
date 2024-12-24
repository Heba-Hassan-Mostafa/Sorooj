<?php

namespace App\Http\Livewire;

use App\Models\Blog;
use Livewire\Component;

class BlogsReorder extends Component
{
    public function render()
    {
        return view('livewire.blogs-reorder',[

            'blogs' => Blog::orderBy('order_position','asc')->get()

        ]);
    }

    public function updateBlogOrder($items)
    {
        //dd($items);

        foreach($items as $item)
        {

            Blog::find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
