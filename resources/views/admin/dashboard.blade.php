@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<x-admin.card class="p-6">

    <div class="flex items-center justify-between">

        <div>

            <h2 class="text-2xl font-bold">
                Welcome Back
            </h2>

            <p class="text-slate-500 mt-1">
                {{ auth()->user()->name }}
            </p>

        </div>

        <div class="space-x-2">

            <x-admin.badge variant="success">
                Active
            </x-admin.badge>

            <x-admin.button>
                Add Product
            </x-admin.button>

        </div>

    </div>

</x-admin.card>

@endsection