<?php

namespace App\Http\Livewire\usercrud;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Livewire\Component;
use App\Models\User;

use Livewire\WithFileUploads;

class IndexComponent extends Component
{

    public $isOpen = false;
    public $uploadImg = false;
    public $user_id;
    // public $photoPreview = 'ddddddddd';
    public $photo;
    use WithFileUploads;

    public $image;
    public $imageUrl;



    public function create()
    {

        $this->resetInputFields();
        $this->openModal();
    }
    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }
    private function resetInputFields(){
        $this->name = '';
        $this->grade = '';
        $this->department = '';
    }
    public function store()
    {
        $this->validate([
            'name' => 'required',
            'grade' => 'required',
        ]);

        User::updateOrCreate(['id' => $this->user_id], [
            'name' => $this->name,
            'grade' => $this->grade,
            'department' => $this->department,
        ]);

        session()->flash('message',
            $this->user_id ? 'User Updated Successfully.' : 'User Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }
    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->grade = $user->grade;
        $this->department = $user->department;

        $this->openModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User Deleted Successfully.');
    }

    public function upload($id){
        $this->user_id = $id;
        $this->uploadImg = true;
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

        $this->uploadImg =false;
        session()->flash('message', 'Photo uploaded successfully!');
    }

    private function getMostSales()
    {
        $data = $this->getEmployees();
        $salesByEmployee = $data
            ->flatMap(function ($employee) {
                return collect($employee['sales'])->map(function ($sale) use ($employee) {
                    return [
                        'name' => $employee['name'],
                        'order_total' => $sale['order_total'],
                    ];
                });
            })
            ->groupBy('name')
            ->map(function ($sales, $name) {
                $totalSales = $sales->sum('order_total');
                return [
                    'name' => $name,
                    'total_sales' => $totalSales,
                ];
            })
            ->sortByDesc('total_sales')
            ->first();
        return $salesByEmployee['name'];
    }

    private function getEmployees(): Collection {
        return collect([
            [
            'name' => 'John',
            'email' => 'john3@example.com',
            'sales' => [
            ['customer' => 'The Blue Rabbit Company', 'order_total' => 7444],
            ['customer' => 'Black Melon', 'order_total' => 1445],
            ['customer' => 'Foggy Toaster', 'order_total' => 700],
            ],
            ],
            [
            'name' => 'Jane',
            'email' => 'jane8@example.com',
            'sales' => [
            ['customer' => 'The Grey Apple Company', 'order_total' => 203],
            ['customer' => 'Yellow Cake', 'order_total' => 8730],
            ['customer' => 'The Piping Bull Company', 'order_total' => 3337],
            ['customer' => 'The Cloudy Dog Company', 'order_total' => 5310],
            ],
            ],
            [
            'name' => 'Dave',
            'email' => 'dave1@example.com',
            'sales' => [
            ['customer' => 'The Acute Toaster Company', 'order_total' => 1091],
            ['customer' => 'Green Mobile', 'order_total' => 2370],
            ],
            ],
            ]);

    }

    private function ranks() {
        $teams = $this->scores();
        $teams_rank = $teams->groupBy('score')
            ->sortByDesc(function ($group) {
                return $group->first()['score'];
            })
            ->map(function ($group, $score) use ($teams) {
                $rank = $teams->search(function ($team) use ($score) {
                    return $team['score'] === $score;
                }) + 1;
                return $group->map(function ($team) use ($rank) {
                    return array_merge($team, ['rank' => $rank]);
                });
            })

        ->flatten(1);
        return $teams_rank;
    }
    private function scores(): Collection {
        return collect ([
            ['score' => 76, 'team' => 'A'],
            ['score' => 62, 'team' => 'B'],
            ['score' => 82, 'team' => 'C'],
            ['score' => 86, 'team' => 'D'],
            ['score' => 91, 'team' => 'E'],
            ['score' => 67, 'team' => 'F'],
            ['score' => 67, 'team' => 'G'],
            ['score' => 82, 'team' => 'H'],
        ]);
    }
    public function render()
    {
        // $employees = $this->getEmployees();
        $users = Cache::remember('users', 60, function () {
                return User::all();
        });
        return view('livewire.usercrud.index-component', [
            'users' => $users,
            'isOpen' => $this->isOpen,
            'user_id' => $this->user_id,
            'employeeName' => $this->getMostSales(),
            'ranks' => $this->ranks(),
            ])->layout('livewire.layouts.base');
    }
}
