@extends('layouts.dashboard')

@section('title', 'Categories')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Categories</li>
@endsection

@section('content')

    <div class="mb-5">
        @if(Auth::user()->can('categories.create'))
        <a href="{{ route('dashboard.categories.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
        @endif
    </div>

    <x-alert type="success" />
    <form action="{{ URL::current() }}" method="get" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2" :value="request('name')" />
        <select name="status" class="form-control mx-2">
            <option value="">All</option>
            <option value="active" @selected(request('status')=='active')>Active</option>
            <option value="archived" @selected(request('status')=='archived')>Archived</option>
        </select>
        <button class="btn btn-dark">Filter</button>
    </form>
    <table class="table text-center align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Producs #</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($categories as $category)
                <tr>
                    <td>{{ $categories->firstItem() + $loop->index }}</td>
                    <td><img src="{{ asset('storage/' . $category->image) }}" alt="" height="50px"></td>
                    <td><a href="{{route('dashboard.categories.show',$category)}}">{{ $category->name }}</a></td>
                    <td>{{ $category->parent?->name }}</td>
                    <td>{{ $category->products_count}}</td>
                    <td>{{ $category->status }}</td>
                    <td>{{ $category->created_at }}</td>
                    <td>
                        @can('categories.update')
                        <a href="{{ route('dashboard.categories.edit', ['category' => $category]) }}"
                            class="btn btn-sm btn-outline-success">Edit</a>
                        @endcan
                    </td>
                    <td>
                        @can('categoreis.delete')
                        <form action="{{ route('dashboard.categories.destroy', $category) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center bg-light text-secondary p-3">
                        <i class="fas fa-exclamation-circle"></i> No Categories Defined.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categories->withQueryString()->links() }}

@endsection
