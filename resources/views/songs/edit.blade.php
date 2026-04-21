
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Song</title>
</head>
<body>

    <h1>Edit Song</h1>
    <form method="POST" enctype="multipart/form-data" action="{{ route('songs.update', $song->id) }}">
        @csrf
        @method('PUT')

        <div>
            <label>Title</label><br>
            <input type="text" name="title" value="{{ $song->title }}" required>
        </div>

        <br>

        <div>
            <label>Artist</label><br>
            <input type="text" name="artist" value="{{ $song->artist }}" required>
        </div>

        <br>

        <div>
            <label>Current Image</label><br>
            <img src="{{ asset('storage/'.$song->image) }}" width="150">
        </div>

        <br>

        <div>
            <label>Change Image</label><br>
            <input type="file" name="image">
        </div>

        <br>

        <button type="submit">Update Song</button>

    </form>

</body>
</html>
