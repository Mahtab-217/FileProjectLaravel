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
            'medias'=>Media::latest()->get()
        ]);
    }
}

?>

<div class="p-8 max-w-6xl mx-auto">

    <h1 class="text-3xl font-bold mb-6 text-center">Media Manager</h1>

    <!-- Upload Box -->
    <div class="bg-white p-6 rounded-2xl shadow mb-6 text-center">
        
        <input type="file" wire:model="file" class="mb-4">

        <button wire:click="upload"
                wire:loading.attr="disabled"
                class="bg-blue-600 text-white px-6 py-2 rounded-xl">
            Upload
        </button>

        <div wire:loading wire:target="file" class="mt-2 text-gray-500">
            در حال آپلود...
        </div>
    </div>

    <!-- Media List -->
    <div class="grid grid-cols-2 gap-6">

        @foreach($medias as $media)
            <div class="bg-gray-100 p-4 rounded-xl shadow">

                <p class="font-bold mb-2">{{ $media->name }}</p>

                @if($media->type == 'audio')
                    <audio controls class="w-full">
                        <source src="{{ asset('storage/'.$media->file_path) }}">
                    </audio>
                @else
                    <video controls class="w-full">
                        <source src="{{ asset('storage/'.$media->file_path) }}">
                    </video>
                @endif

                <div class="flex justify-between mt-4">
                    
                    <a href="{{ asset('storage/'.$media->file_path) }}" download
                       class="text-green-600">
                        Download
                    </a>

                    <button wire:click="delete({{ $media->id }})"
                            class="text-red-600">
                        Delete
                    </button>

                </div>

            </div>
        @endforeach

    </div>

</div>



