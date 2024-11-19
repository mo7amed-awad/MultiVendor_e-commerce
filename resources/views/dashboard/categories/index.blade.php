@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
    </div>

    @if(session()->has('success'))
    <div class="alert alert-success">
        {{session('success')}}
    </div>
    @endif
    <table class="table">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Created At</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td></td>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->parent_id }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.categories.edit', ['category'=>$category]) }}" class="btn btn-sm btn-outline-success">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.categories.destroy',$category) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center bg-light text-secondary p-3">
                    <i class="fas fa-exclamation-circle"></i> No Categories Defined.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

@endsection
