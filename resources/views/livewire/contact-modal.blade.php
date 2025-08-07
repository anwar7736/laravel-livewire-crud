<div class="modal fade show d-block" tabindex="-1" style="background-color: rgba(0,0,0,0.5);">
    <div class="modal-dialog">
        <div class="modal-content">
            <form wire:submit.prevent="{{ $contact_id ? 'update' : 'store' }}">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $contact_id ? 'Edit' : 'Create' }} Contact</h5>
                    <button type="button" class="btn-close" wire:click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group mb-2">
                        <label>Name</label>
                        <input type="text" class="form-control" wire:model="name">
                        @error('name')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label>Email</label>
                        <input type="email" class="form-control" wire:model="email">
                        @error('email')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group mb-2">
                        <label>Phone</label>
                        <input type="text" class="form-control" wire:model="phone">
                        @error('phone')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="form-group mb-2">
                        <label>Gender</label>
                        <label> <input type="radio" value="Male" class="" wire:model="gender" name="gender">
                            Male</label>
                        <label> <input type="radio" value="Female" class="ml-2" wire:model="gender" name="gender">
                            Female</label>
                        @error('gender')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="mb-2">
                        <label>Photo</label>
                        <input type="file" class="form-control" wire:model="photo">
                        @error('photo')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror

                        @if ($photo)
                            <div class="mt-2">
                                <img src="{{ $photo->temporaryUrl() }}" class="rounded" width="100">
                            </div>
                        @elseif ($old_photo)
                            <div class="mt-2">
                                <img src="{{ asset('storage/' . $old_photo) }}" class="rounded" width="100">
                            </div>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" wire:click="closeModal" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">{{ $contact_id ? 'Update' : 'Save' }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
