@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('student-absences.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.kehadiran_siswa.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.kehadiran_siswa.inputs.student_id')</h5>
                    <span
                        >{{ optional($studentAbsence->student)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.kehadiran_siswa.inputs.teacher_id')</h5>
                    <span
                        >{{ optional($studentAbsence->teacher)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.kehadiran_siswa.inputs.presence_id')</h5>
                    <span
                        >{{ optional($studentAbsence->presence)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.kehadiran_siswa.inputs.date')</h5>
                    <span>{{ $studentAbsence->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.kehadiran_siswa.inputs.time')</h5>
                    <span>{{ $studentAbsence->time ?? '-' }}</span>
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('student-absences.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\StudentAbsence::class)
                <a
                    href="{{ route('student-absences.create') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-add"></i> @lang('crud.common.create')
                </a>
                @endcan
            </div>
        </div>
    </div>
</div>
@endsection
