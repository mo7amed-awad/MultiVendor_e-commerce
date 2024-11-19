@extends('layouts.dashboard')

@section('title', 'Edite Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{route('dashboard.categories.index')}}">Categories</a></li>
    <li class="breadcrumb-item active">Edite Categories</li>
@endsection

@section('content')
    <form action="{{route('dashboard.categories.update',$category)}}" method="POST" enctype="multipart/form-data" >
        @csrf
        @method('PUT')
        @include('dashboard.categories._form',[
            'button_label'=>'Update'
        ])
    </form>
@endsection
