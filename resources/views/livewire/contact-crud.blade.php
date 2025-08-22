<div class="container mt-5">
    <h2 class="mb-4">Livewire Contact CRUD with Modal</h2>
    <div class="alert alert-danger alert-dismissible fade show w-25" role="alert" wire:offline>
      <strong>You are now offline.</strong>
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    @if (session()->has('message'))
        <div class="alert alert-success">{{ session('message') }}</div>
    @endif

    <button wire:click="openModal()" class="btn btn-primary mb-3">Create Contact</button>
    <a href="{{ route('purchase.create') }}" class="btn btn-success mb-3" wire:navigate>Create Purchase</a>

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
                @include('livewire.partials.contact-row')
            @empty
                @include('livewire.partials.no-items', ["message" => "contacts"])
            @endforelse
            </tbody>
        </table>
</div>
