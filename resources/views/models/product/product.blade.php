@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Products') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('products.create-edit') }}" class="btn btn-link">
                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                        @if (session('status') === 1)
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        @if (session('status') === 0)
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('message') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <div class="table-responsive">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>NAME</th>
                                        <th>MODEL YEAR</th>
                                        <th>PRICE</th>
                                        <th>STATUS</th>
                                        <th>CATEGORY</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($products as $row)
                                        <tr>
                                            <td> {{ $row['name'] }} </td>
                                            <td> {{ $row['model_year'] }} </td>
                                            <td> {{ $row['price'] }} </td>
                                            <td>
                                                @if ($row['status'] === 1)
                                                    <span class="badge text-bg-success">Active</span>
                                                @else
                                                    <span class="badge text-bg-danger">Inactive</span>
                                                @endif

                                            </td>
                                            <td> {{ $row['category']['name'] }} </td>
                                            <td class="d-flex justify-content-around">
                                                <a href="{{ route('products.details', ['id' => $row['id']]) }}"
                                                    class="btn btn-link">
                                                    <i class="fa fa-eye" aria-hidden="true"></i>
                                                </a>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('products.delete', ['id' => $row['id']]) }}"
                                                    class="btn btn-link">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                <a href="{{ route('products.create-edit', ['id' => $row['id']]) }}"
                                                    class="btn btn-link">
                                                    <i class="fa fa-pencil" aria-hidden="true"></i>
                                                </a>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
