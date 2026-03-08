@extends('layouts.app')

@section('title', 'Akses Ditolak - Apotekku')
@section('page_title', 'Error 403')

@section('content')
<div class="card" style="padding: 4rem 2rem;">
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <svg width="120" height="120" fill="none" stroke="#f59e0b" viewBox="0 0 24 24" style="margin-bottom: 1.5rem; opacity: 0.9;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8V7z"></path>
        </svg>
        <h1 style="font-size: 4rem; color: var(--text-color); margin-bottom: 0.5rem; font-weight: 800; line-height: 1;">403</h1>
        <h2 style="font-size: 1.5rem; color: #4b5563; margin-bottom: 1rem;">Akses Dilarang</h2>
        <p style="color: #6b7280; margin-bottom: 2.5rem; max-width: 450px; line-height: 1.6;">
            Maaf, Anda tidak memiliki izin hak akses (role) yang diperlukan untuk masuk ke halaman ini. Silakan hubungi Administrator.
        </p>
        <button onclick="window.history.back()" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
            <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali Sebelumnya
        </button>
    </div>
</div>
@endsection
