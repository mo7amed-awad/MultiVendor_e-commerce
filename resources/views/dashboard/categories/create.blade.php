@extends('layouts.dashboard')

@section('title', 'Create Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{route('dashboard.categories.index')}}">Categories</a></li>
    <li class="breadcrumb-item active">Create Categories</li>
@endsection

@section('content')
    <form action="{{route('dashboard.categories.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('dashboard.categories._form')
    </form>
@endsection
