<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Media;
use Illuminate\Support\Facades\Storage;

class MediaManager extends Component
{
    use WithFileUploads;

    public $file;
    protected $rules=[
        'file'=>'required|mimes:mp3,mp4,wav|max:10240',

    ];
    public function upload(){
        $this->validated();

        $path=$this->file->store('media','public');

        Media::create([
            'title'=>$this->file->getClientOriginName(),
            'file_path'=>$path,
            'type'=>str_contains($this->file->getMimeType(),
            
            'audio')? 'audio': 'video',
        ]);

        $this->reset('file');
    }
    public function delete($id){
        $media = Media::findOrFail($id);

        Storage::disk('public')->delete($media->file_path);
        $media->delete();
    }
    public function render(){
        return view('livewire.media-manager',[
            'medias'=>::latest()->get()
        ])
    }
   



    
}

