@php $editing = isset($presence) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nama Kehadiran"
            :value="old('name', ($editing ? $presence->name : ''))"
            maxlength="255"
            placeholder="Nama Kehadiran"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
