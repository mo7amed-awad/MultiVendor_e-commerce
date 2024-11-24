@extends('layouts.dashboard')

@section('title', $category->name)

@section('breadcrumb')
    @parent
    <li class="breadcrumb-item active"><a href="{{route('dashboard.categories.index')}}">Categories</a></li>
    <li class="breadcrumb-item active">{{$category->name}}</li>
@endsection

@section('content')
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
            <th>Name</th>
            <th>Image</th>
            <th>Store</th>
            <th>Status</th>
            <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @php
            $products=$category->products()->with('store')->paginate(5)
        @endphp
        @forelse ($products as $product)
            <tr>
                <td>{{ $product->name }}</td>
                <td><img src="{{ asset('storage/' . $product->image) }}" alt="" height="50px"></td>
                <td>{{ $product->store->name }}</td>
                <td>{{ $product->status }}</td>
                <td>{{ $product->created_at }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center bg-light text-secondary p-3">
                    <i class="fas fa-exclamation-circle"></i> No Products Defined.
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $products->withQueryString()->links() }}

@endsection
