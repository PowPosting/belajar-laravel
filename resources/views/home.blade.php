@extends('layouts.app')

@section('content')
    <div class="container content-flex d-flex flex-row align-items-center justify-content-between">
        <!-- Welcome Section -->
        <div class="content-welcome text-start" style="width: 50%;">
            <p class="text-muted">{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM YYYY') }}</p>
            <h2>Selamat Datang, <span class="text-primary">{{ Auth::user()->username }}</span>!</h2>
            <p>Sistem Informasi Terintegrasi untuk Layanan Kesehatan Terbaik<br>
                Revolusi layanan kesehatan di era digital. Konektivitas tanpa batas antara pasien dan penyedia layanan
                kesehatan untuk pengalaman medis yang lebih baik.</p>
        </div>

        <!-- Icon Grid Section -->
        <div class="content-grafik d-flex flex-wrap justify-content-center gap-3 p-3" style="width: 50%;">
            <div class="card shadow-sm p-3" style="width: 100px; height: 100px; border-radius: 10px;">
                <i class="fa-solid fa-chart-bar text-primary" style="font-size: 2rem;"></i>
            </div>
            <div class="card shadow-sm p-3" style="width: 100px; height: 100px; border-radius: 10px;">
                <i class="fa-solid fa-flask text-danger" style="font-size: 2rem;"></i>
            </div>
            <div class="card shadow-sm p-3" style="width: 100px; height: 100px; border-radius: 10px;">
                <i class="fa-solid fa-heart text-warning" style="font-size: 2rem;"></i>
            </div>
            <div class="card shadow-sm p-3" style="width: 100px; height: 100px; border-radius: 10px;">
                <i class="fa-solid fa-book text-secondary" style="font-size: 2rem;"></i>
            </div>
            <div class="card shadow-sm p-3" style="width: 100px; height: 100px; border-radius: 10px;">
                <i class="fa-solid fa-chart-line text-primary" style="font-size: 2rem;"></i>
            </div>
            <div class="card shadow-sm p-3" style="width: 100px; height: 100px; border-radius: 10px;">
                <i class="fa-solid fa-sliders text-info" style="font-size: 2rem;"></i>
            </div>
        </div>
    </div>
@endsection