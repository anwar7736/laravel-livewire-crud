<?php

namespace App\Livewire;

use App\Helpers\Toastr;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use App\Models\Contact;
use Livewire\Attributes\On;

class ContactCrud extends Component
{
    use WithFileUploads;

    public $contacts, $name, $email, $phone, $gender, $photo, $old_photo, $contact_id;
    public $isModalOpen = false;


    public function render()
    {
        $this->contacts = Contact::latest()->get();
        return view('livewire.contact-crud');
    }

    public function openModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        deleteTempImages();
        $this->isModalOpen = false;
    }

    public function resetFields()
    {
        $this->reset([
            'name',
            'email',
            'phone',
            'gender',
            'photo',
            'old_photo',
            'contact_id'
        ]);
        $this->resetErrorBag();
    }

    // ✅ Create New Contact
    public function store()
    {
        $inputs = $this->validate([
            'name'  => 'required',
            'email' => 'required|email|unique:contacts,email',
            'phone' => 'required|unique:contacts,phone',
            'gender' => 'required',
            'photo' => 'nullable|image|max:2048',
        ]);

        if ($this->photo) {
            $inputs['photo'] = uploadFile($this->photo, 'contacts');
        }
        Contact::create($inputs);
        $this->closeModal();
        $this->resetFields();
        flash()->success('Contact Created Successfully!');
    }

    // ✅ Update Existing Contact
    public function update()
    {
        $inputs = $this->validate([
            'name'   => 'required',
            'email'  => 'required|email|unique:contacts,email,' . $this->contact_id,
            'phone'  => 'required|unique:contacts,phone,' . $this->contact_id,
            'gender' => 'required',
            'photo'  => 'nullable|image|max:2048',
        ]);

        $contact = Contact::findOrFail($this->contact_id);
        $inputs['photo'] = $this->old_photo;
        if ($this->photo) {
            deleteFile($this->old_photo, "contacts");
            $inputs['photo'] = uploadFile($this->photo, 'contacts');
        }

        $contact->update($inputs);
        $this->closeModal();
        $this->resetFields();
        flash()->success('Contact Updated Successfully!');
    }

    public function edit($id)
    {
        $contact = Contact::findOrFail($id);
        $this->contact_id = $id;
        $this->name = $contact->name;
        $this->email = $contact->email;
        $this->phone = $contact->phone;
        $this->gender = "Male";
        $this->old_photo = $contact->photo;
        $this->resetErrorBag();
        $this->isModalOpen = true;
    }

    #[On('delete')]
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        deleteFile($contact->photo, "contacts");
        $contact->delete();
        flash()->success('Contact Deleted Successfully!');
    }
}
