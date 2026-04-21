<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
   <h1>Songs List</h1>
{{-- <a href="{{ route('songs.edit',$songs->id) }}">Edit Song</a> --}}
{{-- <a href="{{ route('songs.create') }}">Add Song</a>  --}}

<div style="display:flex; flex-wrap:wrap; gap:20px;">

@foreach($songs as $song)
    <div style="border:1px solid #ddd; padding:10px; width:200px;">
        
        <img src="{{ asset('storage/'.$song->image) }}" width="100%">

        <h3>{{ $song->title }}</h3>
        <p>{{ $song->artist }}</p>

        <a href="{{ route('songs.edit', $song->id) }}">Edit</a>

        <form method="POST" action="{{ route('songs.destroy', $song->id) }}">
            @csrf
            @method('DELETE')
            <button>Delete</button>
        </form>

    </div>
@endforeach

</div>

</body>
</html>