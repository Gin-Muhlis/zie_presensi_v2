@php $editing = isset($sessionStart) @endphp

<div class="row">
    <x-inputs.group class="col-sm-12">
        <x-inputs.date
            name="date"
            label="Tanggal"
            value="{{ old('date', ($editing ? optional($sessionStart->date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.text
            name="time"
            label="Jam"
            :value="old('time', ($editing ? $sessionStart->time : ''))"
            maxlength="255"
            placeholder="Time"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="teacher_id" label="Guru" required>
            @php $selected = old('teacher_id', ($editing ? $sessionStart->teacher_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahkan Pilih Guru</option>
            @foreach($teachers as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="col-sm-12">
        <x-inputs.select name="class_student_id" label="Kelas Siswa" required>
            @php $selected = old('class_student_id', ($editing ? $sessionStart->class_student_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Silahakn Pilih Kelas Siswa</option>
            @foreach($classStudents as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>
</div>
