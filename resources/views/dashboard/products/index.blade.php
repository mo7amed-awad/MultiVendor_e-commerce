@extends('layouts.dashboard')

@section('title', 'Products')

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active">Products</li>
@endsection

@section('content')

    <div class="mb-5">
        <a href="{{ route('dashboard.products.create') }}" class="btn btn-sm btn-outline-primary">Create</a>
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
                <th>Category</th>
                <th>Store</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2"></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($products as $product)
                <tr>
                    <td>{{ $products->firstItem() + $loop->index }}</td>
                    <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50px"></td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category_id }}</td>
                    <td>{{ $product->store_id }}</td>
                    <td>{{ $product->status }}</td>
                    <td>{{ $product->created_at }}</td>
                    <td>
                        <a href="{{ route('dashboard.products.edit', ['product' => $product]) }}"
                            class="btn btn-sm btn-outline-success">Edit</a>
                    </td>
                    <td>
                        <form action="{{ route('dashboard.products.destroy', $product) }}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" class="text-center bg-light text-secondary p-3">
                        <i class="fas fa-exclamation-circle"></i> No Products Defined.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $products->withQueryString()->links() }}

@endsection
