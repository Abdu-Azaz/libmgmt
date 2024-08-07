<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;
use App\Models\Book;
use App\Models\Reservation;
use Illuminate\Support\Facades\Auth;

class BookSearch extends Component
{
    public $books;
    public $categories;
    public $selectedCategory = null;
    public $search = '';

    public function mount()
    {
        $this->books = Book::all();
        $this->categories = Category::all();
    }

    public function setCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->searchBooks();
    }

    public function searchBooks()
    {
        $query = Book::query();

        if ($this->selectedCategory) {
            $query->where('category_id', $this->selectedCategory);
        }

        if ($this->search) {
            $query->where(function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                      ->orWhere('isbn', 'like', '%' . $this->search . '%')
                      ->orWhereHas('category', function ($query) {
                          $query->where('name', 'like', '%' . $this->search . '%');
                      })
                      ->orWhere('author', 'like', '%' . $this->search . '%');
            });
        }

        $this->books = $query->get();
    }

    public function reserve(Book $book)
    {
        $user = Auth::user();

        if ($user && $user->student ) {
            Reservation::create([
                'student_id' => $user->student->id,
                'book_id' => $book->id,
            ]);
            
            $this->searchBooks(); // Refresh the book list
        }
    }

    public function cancelReservation(Book $book)
    {
        $user = Auth::user();

        if ($user && $user->student) {
            Reservation::where('student_id', $user->student->id)
                       ->where('book_id', $book->id)
                       ->delete();

            $this->searchBooks(); // Refresh the book list
        }
    }

    public function render()
    {
        return view('livewire.book-search');
    }
}
