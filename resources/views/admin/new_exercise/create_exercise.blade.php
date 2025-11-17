@extends('admin.layouts.master')
@section('admin_title')
    {{$title}}
@endsection


@section('content')
    <div class="container-fluid mb-4">
        <div class="page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('admin.new.exercise.manage') }}">Exercise Programs</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">{{$title}}</a></li>
            </ol>

        </div>
       @livewire('exercise-builder', ['exerciseId' => request()->id])

    </div>
@endsection
