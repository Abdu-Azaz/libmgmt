<div>
    <section class="hero-section d-flex justify-content-center align-items-center" id="section_1">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-12 mx-auto">
                    <h1 class="text-white text-center">Discover. Learn. Enjoy</h1>
                    <form method="get" class="custom-form mt-4 pt-2 mb-lg-0 mb-5" role="search">
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bi-search" id="basic-addon1"></span>
                            <input wire:model.debounce.300ms="search" name="keyword" type="search" class="form-control" id="keyword" placeholder="Title, ISBN, Category, Author" aria-label="Search">
                            <button type="submit" class="form-control">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <div class="container-fluid">
        <div class="row">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                @foreach ($categories as $category)
                    <li class="nav-item" role="presentation">
                        <button class="nav-link m-0 p-3 fw-bold {{ $selectedCategory == $category->id ? 'active' : '' }}" id="tab-{{ $category->id }}" data-bs-toggle="tab" type="button" role="tab" wire:click.prevent="setCategory({{ $category->id }})" aria-controls="tab-pane-{{ $category->id }}" aria-selected="{{ $selectedCategory == $category->id ? 'true' : 'false' }}">
                            {{ $category->name }}
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>

        @if ($books->isEmpty())
            <p>No books found.</p>
        @else
            <div class="row">
                @foreach ($books as $book)
                    <div class="col-lg-3 col-md-6 col-12 mb-4 mb-lg-0">
                        <div class="custom-block bg-white shadow-lg">
                            <div>
                                <img src="images/topics/undraw_Remote_design_team_re_urdx.png" class="custom-block-image img-fluid" alt="">
                                <div class="">
                                    <div>
                                        <h5 class="mb-2">{{ $book->title }}</h5>
                                        <p class="mb-0 fs-6">{!! $book->description !!}</p>
                                    </div>
                                    In Stock: {{ $book->quantity - $book->reservedCount() }}

                                    @if (Auth::check() && Auth::user()->student->user->roles[0]->name === 'student')
                                        @if (Auth::user()->student->reservations()->where('book_id', $book->id)->exists())
                                            <button wire:click="cancelReservation({{ $book->id }})" class="btn btn-sm btn-danger">Cancel Reservation</button>
                                        @else
                                            @if($book->quantity - $book->reservedCount() > 0)
                                            <button wire:click="reserve({{ $book->id }})" class="btn btn-sm btn-primary" wire:loading.attr="disabled" wire:target="reserve">
                                                Reserve
                                                <span wire:loading wire:target="reserve" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                                            </button>
                                                
                                            {{-- <button wire:click="reserve({{ $book->id }})" class="btn btn-sm btn-primary">Reserve</button> --}}
                                            @else
                                                <p>This book is not available yet</p>
                                            @endif
                                        @endif
                                    @else
                                        <br>
                                        <a class="btn btn-sm btn-primary" href="/dashboard/login">Login to reserve</a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
    
</div>
