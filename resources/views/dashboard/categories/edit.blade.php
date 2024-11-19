@extends('layouts.dashboard')

@section('title', 'Edite Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{route('dashboard.categories.index')}}">Categories</a></li>
    <li class="breadcrumb-item active">Edite Categories</li>
@endsection

@section('content')
    <form action="{{route('dashboard.categories.update',$category)}}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{$category->name}}">
        </div>

        <div class="form-group">
            <label for="parent_id">Parent</label>
            <select name="parent_id" id="parent_id" class="form-control form-select">
                <option value="">Primary Category</option>
                @foreach ( $parents as $parent )
                    <option value="{{ $parent->id }}" @selected($category->parent_id==$parent->id) >{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control">{{$category->description}}</textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="status" value="active" @checked($category->status=='active')>
                    <label for="status" class="form-check-label">Active</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="status" value="archived" @checked($category->status=='archived')>
                    <label for="status" class="form-check-label">Archived</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
