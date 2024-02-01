@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">{{ __('Create') }}</div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <a href="{{ route('products') }}" class="btn btn-link">
                                    <i class="fa fa-arrow-left" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data"
                                id="form">
                                @csrf
                                @if ($product?->id)
                                    <input type="hidden" class="form-control" name="id"
                                        value="{{ $product ? $product->id : old('id') }}">
                                @endif
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            name="name" placeholder="name"
                                            value="{{ $product ? $product->name : old('name') }}">
                                        @error('name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="model_year" class="form-label">year</label>
                                        <input type="text" class="form-control @error('model_year') is-invalid @enderror"
                                            name="model_year" minlength="4" maxlength="4"
                                            value="{{ $product ? $product->model_year : date('Y') }}" placeholder="2024">
                                        @error('model_year')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="price" class="form-label">price</label>
                                        <input type="number" step="0.01"
                                            class="form-control @error('price') is-invalid @enderror" name="price"
                                            value="{{ $product ? $product->price : old('price') }}">
                                        @error('price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    @if ($product?->id)
                                        <div class="mb-3">
                                            <label for="status" class="form-label">status</label>
                                            <select class="form-select @error('status') is-invalid @enderror" name="status"
                                                ria-label="Default select example">
                                                <option selected value="">Open this select menu</option>

                                                <option value="0"
                                                    {{ 0 == $product?->status ? 'selected' : old('selected') }}>
                                                    Intactive
                                                </option>
                                                <option value="1"
                                                    {{ 1 == $product?->status ? 'selected' : old('selected') }}>
                                                    Active
                                                </option>
                                            </select>
                                            @error('status')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="mb-3">
                                        <label for="categories_id" class="form-label">category</label>
                                        <select class="form-select @error('categories_id') is-invalid @enderror"
                                            name="categories_id" aria-label="Default select example">
                                            <option selected value="">Open this select menu</option>
                                            @foreach ($category as $row)
                                                @if ($row['id'] === $product?->categories_id)
                                                    <option selected value="{{ $row['id'] }}">{{ $row['name'] }}
                                                    </option>
                                                @else
                                                    <option value="{{ $row['id'] }}">{{ $row['name'] }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                        @error('categories_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Select Files:</label>
                                        <input type="file" name="photos[]" id="photos" multiple
                                            accept="image/jpg, image/jpeg, , image/png"
                                            class="form-control @error('photos') is-invalid @enderror">
                                        <span class="text-black">Select only images (three images)</span>
                                        @error('photos')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Select Files:</label>
                                        <input type="file" name="videos[]" id="videos"
                                            accept="video/mp4,video/x-m4v,video/*"
                                            class="form-control @error('videos') is-invalid @enderror">
                                        <span class="text-black">Select only video </span>
                                        @error('videos')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary m-1">save</button>
                                    <a href="{{ route('products') }}" class="btn btn-danger m-1">
                                        cancel
                                    </a>
                                </div>

                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
