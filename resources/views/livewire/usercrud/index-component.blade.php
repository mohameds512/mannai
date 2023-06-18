
<div>
    @if(session()->has('message'))
        <div class="bg-green-200 text-green-700 py-3 px-4 rounded">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-end my-2">
        <button wire:click="create()" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create User
        </button>
    </div>

    <table class="table-fixed w-full">
        <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 w-20">#</th>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">grade</th>
                <th class="px-4 py-2">Dept</th>
                <th class="px-4 py-2">photo</th>
                <th class="px-4 py-2 w-20"></th>
            </tr>
        </thead>
        <tbody style="width: 100%">
            @foreach($users as $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->id }}</td>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->grade }}</td>
                <td class="border px-4 py-2">{{ $user->department }}</td>
                <td class="border px-4 py-2">
                    @if ($user->photo != null)
                    <img src="{{ Storage::url($user->photo) }}" alt="{{ $user->name }}" class="h-12 w-12 object-cover rounded-full">
                    @else
                    <span class="text-gray-400">No photo</span>
                    @endif
                </td>
                <td class="border px-4 py-2">
                    <button wire:click="edit({{ $user->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        Edit
                    </button>
                    <button wire:click="upload({{ $user->id }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                        upload
                    </button>
                    <button wire:click="delete({{ $user->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        Delete
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal -->
    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left"  style="display: {{ $isOpen ? 'block' : 'none' }}">
        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
            {{ $user_id ? 'Edit User' : 'Create User' }}
        </h3>
        <div class="mt-2">
            <form>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Name
                    </label>
                    <input wire:model="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="name" type="text" placeholder="Enter name">
                    @error('name') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="grade">
                        grade
                    </label>
                    <input wire:model="grade" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="grade" type="grade" placeholder="Enter grade">
                    @error('grade') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="department">
                        department
                    </label>
                    <input wire:model="department" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" id="department" type="department" placeholder="Enter department">
                    @error('department') <span class="text-red-500">{{ $message }}</span>@enderror
                </div>
            </form>
        </div>
        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
            <button wire:click="store()" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue">store</button>
        </div>
    </div>


<div x-data="{photoPreview: null}" x-init="FilePond.registerPlugin(FilePondPluginFileValidateSize, FilePondPluginImagePreview)"
style="display: {{ $uploadImg ? 'block' : 'none' }}" >
    <form wire:submit.prevent="savePhoto" enctype="multipart/form-data">
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2" for="photo">
                Select a photo:
            </label>
            <input type="file" wire:model="photo" id="photo" name="photo" x-ref="photo" class="hidden"
                @change="photoPreview = URL.createObjectURL($refs.photo.files[0])">
            <div class="flex items-center justify-center w-full h-64 bg-gray-100 hover:bg-gray-200 cursor-pointer"
                x-on:click="$refs.photo.click()" x-bind:class="{'border-dashed border-2 border-gray-400': !photoPreview}">
                <template x-if="photoPreview">
                    <img x-bind:src="photoPreview" class="h-full object-contain">
                </template>
                <template x-if="!photoPreview">
                    <span class="text-gray-500 font-bold">Click to select a photo</span>
                </template>
            </div>
            @error('photo')
            <p class="text-red-500 mt-2">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Upload Photo
        </button>
    </form>
</div>

<div>
    <strong> the employee who made
        the most valuable sale is {{ $employeeName }}</strong>
</div>
{{$ranks}}
<div>
    <table>
        <thead>
            <tr>
                <th>Team</th>
                <th>Score</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($ranks as $rank): ?>
            <tr>
                <td><?php echo $rank['team']; ?></td>
                <td><?php echo $rank['score']; ?></td>
                <td><?php echo $rank['rank']; ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
</div>

