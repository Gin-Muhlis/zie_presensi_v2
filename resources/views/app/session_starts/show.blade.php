@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-body">
            <h4 class="card-title">
                <a href="{{ route('session-starts.index') }}" class="mr-4"
                    ><i class="icon ion-md-arrow-back"></i
                ></a>
                @lang('crud.session_mulai.show_title')
            </h4>

            <div class="mt-4">
                <div class="mb-4">
                    <h5>@lang('crud.session_mulai.inputs.date')</h5>
                    <span>{{ $sessionStart->date ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.session_mulai.inputs.time')</h5>
                    <span>{{ $sessionStart->time ?? '-' }}</span>
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.session_mulai.inputs.teacher_id')</h5>
                    <span
                        >{{ optional($sessionStart->teacher)->name ?? '-'
                        }}</span
                    >
                </div>
                <div class="mb-4">
                    <h5>@lang('crud.session_mulai.inputs.class_student_id')</h5>
                    <span
                        >{{ optional($sessionStart->classStudent)->name ?? '-'
                        }}</span
                    >
                </div>
            </div>

            <div class="mt-4">
                <a
                    href="{{ route('session-starts.index') }}"
                    class="btn btn-light"
                >
                    <i class="icon ion-md-return-left"></i>
                    @lang('crud.common.back')
                </a>

                @can('create', App\Models\SessionStart::class)
                <a
                    href="{{ route('session-starts.create') }}"
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
