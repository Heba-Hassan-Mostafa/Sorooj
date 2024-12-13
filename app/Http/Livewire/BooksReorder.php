<?php

namespace App\Http\Livewire;

use App\Models\Book;
use Livewire\Component;

class BooksReorder extends Component
{
    public function render()
    {
        return view('livewire.books-reorder',[

            'books' => Book::orderBy('order_position','asc')->get()

        ]);
    }

    public function updateBookOrder($items)
    {
        //dd($items);

        foreach($items as $item)
        {

            Book::find($item['value'])->update(['order_position'=>$item['order']]);
        }
    }
}
