@extends('layouts.app')

@section('title', 'Terjadi Kesalahan Server - Apotekku')
@section('page_title', 'Error 500')

@section('content')
<div class="card" style="padding: 4rem 2rem;">
    <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;">
        <svg width="120" height="120" fill="none" stroke="#ef4444" viewBox="0 0 24 24" style="margin-bottom: 1.5rem; opacity: 0.9;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
        </svg>
        <h1 style="font-size: 4rem; color: var(--text-color); margin-bottom: 0.5rem; font-weight: 800; line-height: 1;">500</h1>
        <h2 style="font-size: 1.5rem; color: #4b5563; margin-bottom: 1rem;">Terjadi Kesalahan Sistem</h2>
        <p style="color: #6b7280; margin-bottom: 2.5rem; max-width: 450px; line-height: 1.6;">
            Maaf, sistem sedang mengalami kendala internal dan tidak dapat memproses permintaan Anda saat ini. Tim kami telah mencatat masalah ini.
        </p>
        <div style="display: flex; gap: 1rem;">
            <button onclick="window.history.back()" class="btn btn-secondary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin-right: 0.5rem;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali
            </button>
            <a href="{{ route('dashboard') ?? url('/') }}" class="btn btn-primary" style="padding: 0.75rem 2rem; font-size: 1rem;">
                Ke Dashboard Utama
            </a>
        </div>
    </div>
</div>
@endsection
