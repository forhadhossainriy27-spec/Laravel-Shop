@extends('layouts.admin')

@section('title','Create Product')

@section('content')

<div class="max-w-7xl mx-auto">

    <h1 class="mb-6 text-3xl font-bold">
        Create Product
    </h1>

    <form
        action="{{ route('admin.products.store') }}"
        method="POST"
        enctype="multipart/form-data"
        class="rounded-xl border bg-white p-6 shadow-sm">

        @csrf

        @include('admin.products.form')

    </form>

</div>

@endsection