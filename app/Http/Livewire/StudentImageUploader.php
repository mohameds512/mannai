<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;

class StudentImageUploader extends Component
{
    use WithFileUploads;

    public $photo;
    public $user_id;
    public function upload($id){
        $this->user_id = $id;
    }
    public function savePhoto()
    {
        $this->validate([
            'photo' => 'required|image|max:1024', // max file size is 1MB
        ]);

        $filename = $this->photo->store('photos', 'public');
        $user = User::findOrFail($this->user_id);
        $user->photo = $filename;
        $user->save();
        // return $this->photo;


        session()->flash('message', 'Photo uploaded successfully!');
    }
    public function render()
    {
        return view('livewire.student-image-uploader');
    }
}
