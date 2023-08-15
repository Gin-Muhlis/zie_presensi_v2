@php $editing = isset($student) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="name"
            label="Nama"
            :value="old('name', ($editing ? $student->name : ''))"
            maxlength="255"
            placeholder="Nama"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="nis"
            label="Nis"
            :value="old('nis', ($editing ? $student->nis : ''))"
            maxlength="9"
            placeholder="Nis"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <div
            x-data="imageViewer('{{ $editing && $student->image ? \Storage::url($student->image) : '' }}')"
        >
            <x-inputs.partials.label
                name="image"
                label="Gambar Profil"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input
                    type="file"
                    name="image"
                    id="image"
                    @change="fileChosen"
                />
            </div>

            @error('image') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="gender" label="Gender">
            @php $selected = old('gender', ($editing ? $student->gender : '')) @endphp
            <option value="laki-laki" {{ $selected == 'laki-laki' ? 'selected' : '' }} >Laki laki</option>
            <option value="perempuan" {{ $selected == 'perempuan' ? 'selected' : '' }} >Perempuan</option>
            <option value="lainnya" {{ $selected == 'lainnya' ? 'selected' : '' }} >Lainnya</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="passsword"
            label="Passsword"
            :value="old('passsword', ($editing ? $student->passsword : ''))"
            maxlength="255"
            placeholder="Passsword"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="class_student_id" label="Kelas Siswa" required>
            @php $selected = old('class_student_id', ($editing ? $student->class_student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Kelas Siswa</option>
            @foreach($classStudents as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
