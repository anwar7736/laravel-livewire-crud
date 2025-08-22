
<tr wire:key="{{ $contact->id }}">
    <td>{{ $loop->iteration }}</td>
    <td>
        <img src="{{ getFile($contact->photo, "contacts") }}" width="40" height="40"
            class="rounded-circle">
    </td>
    <td>{{ $contact->name }}</td>
    <td>{{ $contact->email }}</td>
    <td>{{ $contact->phone }}</td>
    <td>
        <button type="button" wire:click="edit({{ $contact->id }})"
            class="btn btn-sm btn-success"><i class="fa fa-edit"></i></button>
        <button type="button" wire:click="$dispatch('swal:delete-confirm', {id: {{ $contact->id}} })"
            class="btn btn-sm btn-danger">
            <i class="fa fa-trash"></i>
        </button>
    </td>
</tr>

