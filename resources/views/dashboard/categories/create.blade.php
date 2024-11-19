@extends('layouts.dashboard')

@section('title', 'Create Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{route('dashboard.categories.index')}}">Categories</a></li>
    <li class="breadcrumb-item active">Create Categories</li>
@endsection

@section('content')
    <form action="{{route('dashboard.categories.store')}}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name" class="form-control">
        </div>

        <div class="form-group">
            <label for="parent_id">Parent</label>
            <select name="parent_id" id="parent_id" class="form-control form-select">
                <option value="">Primary Category</option>
                @foreach ( $parents as $parent )
                    <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="status" value="active" checked>
                    <label for="status" class="form-check-label">Active</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="status" value="archived">
                    <label for="status" class="form-check-label">Archived</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
        </div>
    </form>
@endsection
