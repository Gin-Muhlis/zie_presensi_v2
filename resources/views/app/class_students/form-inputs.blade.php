@php $editing = isset($classStudent) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nama Kelas"
            :value="old('name', ($editing ? $classStudent->name : ''))"
            maxlength="255"
            placeholder="Nama Kelas"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="code"
            label="Kode Kelas"
            :value="old('code', ($editing ? $classStudent->code : ''))"
            maxlength="255"
            placeholder="Kode Kelas"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
