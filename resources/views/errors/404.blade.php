@extends('layouts.app')

@section('title', 'Halaman Tidak Ditemukan - Apotekku')
@section('page_title', 'Error 404')

@section('content')
<div class="card" style="padding: 4rem 2rem;">
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <svg width="120" height="120" fill="none" stroke="var(--primary-color)" viewBox="0 0 24 24" style="margin-bottom: 1.5rem; opacity: 0.9;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <h1 style="font-size: 4rem; color: var(--text-color); margin-bottom: 0.5rem; font-weight: 800; line-height: 1;">404</h1>
        <h2 style="font-size: 1.5rem; color: #4b5563; margin-bottom: 1rem;">Halaman Tidak Ditemukan</h2>
        <p style="color: #6b7280; margin-bottom: 2.5rem; max-width: 450px; line-height: 1.6;">
            Maaf, halaman atau rute yang Anda cari tidak dapat ditemukan. Mungkin halaman tersebut telah dipindahkan, atau Anda mengetikkan tautan yang salah.
        </p>
        <a href="{{ route('dashboard') ?? url('/') }}" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
