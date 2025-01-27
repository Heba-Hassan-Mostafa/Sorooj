<?php

namespace App\Http\Livewire;

use App\Models\Blog;
use App\Models\Video;
use Livewire\Component;

class BlogVideosReorder extends Component
{
    public Blog $blog;

    public function mount(Blog $blog)
    {
        $this->course = $blog;
    }
    public function render()
    {

        return view('livewire.blog-videos-reorder', [

            'blog_videos' => $this->blog->videos()
                ->orderBy('order_position', 'asc')
                ->get(),
        ]);
    }

    public function updateBlogVideoOrder($items)
    {
        //dd($items);

        foreach($items as $item)
        {
            Video::where('videoable_type','Blog')->find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
