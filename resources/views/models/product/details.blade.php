@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Product details') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('products') }}" class="btn btn-link">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
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
                        <div class="row">
                            <div class="col-sm-12 col-lg-6">
                                <p class="fw-bold">NAME</p>
                                <p>{{ $product->name }}</p>
                                <p class="fw-bold">MODEL YEAR</p>
                                <p>{{ $product->model_year }}</p>
                                <p class="fw-bold">PRICE</p>
                                <p>{{ $product->price }}</p>
                                <p class="fw-bold">STATUS</p>
                                <p>{{ $product->status }}</p>
                                <p class="fw-bold">CATEGORY</p>
                                <p>{{ $product->category->name }}</p>
                            </div>
                            <div class="col-sm-12 col-lg-6">
                                <div class="row">
                                    @foreach ($product->resource_product as $row)
                                        @if ($row['resource']['cat_resource_types_id'] === 2)
                                            <div class="col-4 d-flex flex-column">
                                                <img class="img-thumbnail"
                                                    src="{{ $row['resource']['url'] . '' . $row['resource']['name'] }}"
                                                    alt="">
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('products.resource.delete', ['id' => $row['id']]) }}"
                                                    class="btn btn-link">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                </a>
                                            </div>
                                        @endif
                                        @if ($row['resource']['cat_resource_types_id'] === 1)
                                            <div class="col-4 d-flex flex-column">
                                                <video src="{{ $row['resource']['url'] . '' . $row['resource']['name'] }}"
                                                    class="object-fit-contain" autoplay></video>
                                                <a onclick="return confirm('Are you sure?')"
                                                    href="{{ route('products.resource.delete', ['id' => $row['id']]) }}"
                                                    class="btn btn-link">
                                                    <i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </a>
                                                </a>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
