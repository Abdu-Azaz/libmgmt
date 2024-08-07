@php
    $student = auth()->user()->student;
    $reserved_books = \App\Models\Reservation::where('student_id', $student->id)->get();
@endphp

<h1>You reserved: </h1>
<ul>
    @foreach ($reserved_books as $reserved)
        <li>{{$reserved->book->title}}
            @ {{$reserved->book->created_at}})</li> 
    @endforeach
</ul>