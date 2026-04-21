use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Song;

class Manager extends Component
{
    use WithFileUploads;

    public $title, $artist, $image;
    public $songs;
    public $editId = null;

    public function mount()
    {
        $this->songs = Song::latest()->get();
    }

    public function save()
    {
        $this->validate([
            'title' => 'required',
            'artist' => 'required',
            'image' => $this->editId ? 'nullable|image' : 'required|image',
        ]);

        if ($this->image) {
            $imagePath = $this->image->store('songs', 'public');
        }

        if ($this->editId) {
            $song = Song::find($this->editId);
            $song->update([
                'title' => $this->title,
                'artist' => $this->artist,
                'image' => $imagePath ?? $song->image,
            ]);
        } else {
            Song::create([
                'title' => $this->title,
                'artist' => $this->artist,
                'image' => $imagePath,
            ]);
        }

        $this->reset(['title', 'artist', 'image', 'editId']);
        $this->songs = Song::latest()->get();
    }

    public function edit($id)
    {
        $song = Song::find($id);
        $this->title = $song->title;
        $this->artist = $song->artist;
        $this->editId = $id;
    }

    public function delete($id)
    {
        Song::find($id)->delete();
        $this->songs = Song::latest()->get();
    }

    public function render()
    {
        return <<<'HTML'
<div class="p-6 max-w-6xl mx-auto">

    <!-- FORM -->
    <div class="bg-white shadow-xl rounded-2xl p-6 mb-6">
        <h2 class="text-xl font-bold mb-4">
            {{ $editId ? 'Edit Song' : 'Add Song' }}
        </h2>

        <input type="text" wire:model="title" placeholder="Song Name"
            class="w-full mb-3 p-2 border rounded">

        <input type="text" wire:model="artist" placeholder="Artist"
            class="w-full mb-3 p-2 border rounded">

        <input type="file" wire:model="image"
            class="mb-3">

        <button wire:click="save"
            class="bg-indigo-600 text-white px-4 py-2 rounded-lg">
            Save
        </button>
    </div>

    <!-- LIST -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($songs as $song)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                <img src="{{ asset('storage/'.$song->image) }}"
                     class="h-48 w-full object-cover">

                <div class="p-4">
                    <h3 class="font-bold">{{ $song->title }}</h3>
                    <p class="text-gray-500">{{ $song->artist }}</p>

                    <div class="flex gap-2 mt-3">
                        <button wire:click="edit({{ $song->id }})"
                            class="text-blue-500">Edit</button>

                        <button wire:click="delete({{ $song->id }})"
                            class="text-red-500">Delete</button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
HTML;
    }
}
