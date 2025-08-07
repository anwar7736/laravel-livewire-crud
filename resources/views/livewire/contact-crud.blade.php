<div class="container mt-5">
    <h2 class="mb-4">Livewire Contact CRUD with Modal</h2>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <button wire:click="openModal()" class="btn btn-primary mb-3">Create Contact</button>
    <a href="/" wire:navigate class="btn btn-primary mb-3">Goto Home</a>

    @if ($isModalOpen)
        @include('livewire.contact-modal')
    @endif

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>Photo</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($contacts as $contact)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($contact->photo)
                            <img src="{{ asset('storage/' . $contact->photo) }}" width="40" height="40"
                                class="rounded-circle">
                        @else
                            <span class="text-muted">No Image</span>
                        @endif
                    </td>
                    <td>{{ $contact->name }}</td>
                    <td>{{ $contact->email }}</td>
                    <td>{{ $contact->phone }}</td>
                    <td>
                        <button type="button" wire:click="edit({{ $contact->id }})"
                            class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>
                        <button type="button" wire:click="confirmDelete({{ $contact->id }})"
                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-danger">No contacts found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>
