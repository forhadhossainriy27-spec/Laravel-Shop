@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<x-admin.card class="p-6">


    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">

        <x-admin.stat-card
            title="Total Products"
            :value="$totalProducts"
            color="blue" />

        <x-admin.stat-card
            title="Active"
            :value="$activeProducts"
            color="green" />

        <x-admin.stat-card
            title="Inactive"
            :value="$inactiveProducts"
            color="red" />

        <x-admin.stat-card
            title="Featured"
            :value="$featuredProducts"
            color="yellow" />

        <x-admin.stat-card
            title="Low Stock"
            :value="$lowStockProducts"
            color="orange" />

        <x-admin.stat-card
            title="Out Of Stock"
            :value="$outOfStockProducts"
            color="rose" />

        <x-admin.stat-card
            title="Inventory Value"
            :value="'৳ '.number_format($totalInventoryValue,2)"
            color="indigo" />

        <x-admin.stat-card
            title="Added (30 Days)"
            :value="$recentProducts"
            color="cyan" />

    </div>

    <div class="mt-8 bg-white rounded-2xl border shadow p-6">

        <h2 class="text-xl font-bold mb-6">
            Products by Category
        </h2>

        <canvas id="categoryChart" height="120"></canvas>
        

    </div>

</x-admin.card>

@endsection