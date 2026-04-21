<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use App\Models\Song;
// use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;

class SongController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $songs=Song::latest()->get();
        return view('songs.index',compact('songs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('songs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'title'=>'required|string',
            'artist'=>'required| string',
            'image'=>'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        $path= $request->file('image')->store('songs','public');

        Song::create([
            'artist'=>$request->artist,
            'title'=>$request->title,
            'image'=>$path,
        ]);
        return redirect()->route('songs.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Song $song)
    {
        //
        return view('songs.edit',compact('song'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Song $song)
    {
        //
        $request->validate([
               'title'=>'required|string',
            'artist'=>'required| string',
            'image'=>'required|image|mimes:jpg,png,jpeg|max:2048',
        ]);
        $date=[
            'title'=>$request->title,
            'artist'=>$request->artist,
        ];
        if($request->hasFile('image')){
            Storage::disk('public')->delete($song->image);
            $date['image']=$request->file('image')->store('songs','public');
        }
        $song->update($date);
        return redirect()->route('songs.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Song $song)
    {
        //
        Storage::disk('public')->delete($song->image);
        $song->delete();
        return back();
    }
}
