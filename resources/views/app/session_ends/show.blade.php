@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('session-ends.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.session_akhir.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.session_akhir.inputs.date')</h5>
                    <span>{{ $sessionEnd->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.session_akhir.inputs.time')</h5>
                    <span>{{ $sessionEnd->time ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.session_akhir.inputs.teacher_id')</h5>
                    <span
                        >{{ optional($sessionEnd->teacher)->name ?? '-' }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.session_akhir.inputs.class_student_id')</h5>
                    <span
                        >{{ optional($sessionEnd->classStudent)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('session-ends.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SessionEnd::class)
                <a
                    href="{{ route('session-ends.create') }}"
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
