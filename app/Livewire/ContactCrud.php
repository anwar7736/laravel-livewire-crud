<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;

class ContactCrud extends Component
{
    use WithFileUploads;

    public $contacts, $name, $email, $phone, $photo, $old_photo, $contact_id;
    public $isModalOpen = false;
    protected $listeners = ['delete'];


    public function render()
    {
        $this->contacts = Contact::latest()->get();
        return view('livewire.contact-crud')->layout('components.layouts.app');
    }

    public function openModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetFields()
    {
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->photo = null;
        $this->old_photo = null;
        $this->contact_id = null;
        $this->resetErrorBag();
    }

    // ✅ Create New Contact
    public function store()
    {
        $validated = $this->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required|unique:contacts,phone',
            'photo' => 'nullable|image|max:2048',
        ]);

        $imagePath = $this->photo ? $this->photo->store('photos', 'public') : null;

        Contact::create([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $imagePath,
        ]);

        $this->dispatch('swal:success', message: 'Contact Created Successfully');
        $this->closeModal();
        $this->resetFields();
    }

    // ✅ Update Existing Contact
    public function update()
    {
        $this->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:contacts,email,' . $this->contact_id,
            'phone' => 'required|unique:contacts,phone,' . $this->contact_id,
            'photo' => 'nullable|image|max:2048',
        ]);

        $contact = Contact::findOrFail($this->contact_id);
        $imagePath = $contact->photo;

        if ($this->photo) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $this->photo->store('photos', 'public');
        }

        $contact->update([
            'name'  => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'photo' => $imagePath,
        ]);

        $this->dispatch('swal:success', message: 'Contact Updated Successfully');
        $this->closeModal();
        $this->resetFields();
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $this->contact_id = $id;
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->old_photo = $contact->photo;
        $this->resetErrorBag();
        $this->isModalOpen = true;
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm-delete', id: $id);
    }

    public function delete($id)
    {
        $contact = Contact::findOrFail($id);
        if ($contact->photo && Storage::disk('public')->exists($contact->photo)) {
            Storage::disk('public')->delete($contact->photo);
        }
        $contact->delete();

        $this->dispatch('swal:success', message: 'Contact Deleted Successfully');
    }
}
