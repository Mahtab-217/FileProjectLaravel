<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h1>Add Song</h1>

<form method="POST" enctype="multipart/form-data" action="{{ route('songs.store') }}">
    @csrf

    <input type="text" name="title" placeholder="Title"><br><br>

    <input type="text" name="artist" placeholder="Artist"><br><br>

    <input type="file" name="image"><br><br>

    <button style="background-color: red" class="py-1 px-2 bg-blue-600 " type="submit">Save</button>
</form>

</body>
</html>