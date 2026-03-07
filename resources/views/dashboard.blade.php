@extends('layouts.app')

@section('title', 'Dashboard - Apotekku')
@section('page_title', 'Dashboard Overview')

@section('styles')
<style>
    .welcome-card {
        background: linear-gradient(135deg, var(--card-bg) 0%, #f8fafc 100%);
        border-radius: 1.25rem;
        padding: 2.5rem;
        box-shadow: 0 10px 25px rgba(13, 148, 136, 0.08);
        margin-bottom: 2.5rem;
        border-top: 4px solid var(--primary-color);
        position: relative;
        overflow: hidden;
    }

    .welcome-card::after {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(13, 148, 136, 0.1) 0%, rgba(255,255,255,0) 70%);
        border-radius: 50%;
    }

    .welcome-card h3 {
        margin-top: 0;
        color: var(--primary-color);
        font-size: 1.75rem;
        font-weight: 800;
    }

    .welcome-card p {
        color: #4b5563;
        margin-bottom: 0;
        font-size: 1.05rem;
        line-height: 1.6;
        max-width: 800px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 1.75rem;
    }

    .stat-card {
        background-color: var(--card-bg);
        border-radius: 1.25rem;
        padding: 1.75rem;
        box-shadow: 0 10px 20px rgba(13, 148, 136, 0.05);
        display: flex;
        align-items: center;
        transition: transform 0.2s, box-shadow 0.2s;
        border: 1px solid transparent;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(13, 148, 136, 0.1);
        border-color: var(--primary-light);
    }

    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 1rem;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 1.25rem;
        color: white;
        font-size: 1.75rem;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .stat-icon.blue { background: linear-gradient(135deg, #60a5fa, #3b82f6); }
    .stat-icon.green { background: linear-gradient(135deg, #34d399, #10b981); }
    .stat-icon.orange { background: linear-gradient(135deg, #fbbf24, #f59e0b); }
    .stat-icon.purple { background: linear-gradient(135deg, #a78bfa, #8b5cf6); }

    .stat-details h4 {
        margin: 0;
        color: #6b7280;
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .stat-details .stat-value {
        margin: 0.35rem 0 0 0;
        font-size: 1.75rem;
        font-weight: 800;
        color: var(--text-color);
    }
</style>
@endsection

@section('content')
<div class="welcome-card">
    <h3>Selamat Datang, {{ Auth::user()->name ?? 'Pengguna' }}!</h3>
    <p style="color: #4b5563; margin-bottom: 0;">Sistem Informasi Manajemen Apotekku. Pantau stok obat dan transaksi harian Anda di sini.</p>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon blue">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
        </div>
        <div class="stat-details">
            <h4>Total Obat</h4>
            <p class="stat-value">124</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
        </div>
        <div class="stat-details">
            <h4>Transaksi Hari Ini</h4>
            <p class="stat-value">45</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        </div>
        <div class="stat-details">
            <h4>Pendapatan Hari Ini</h4>
            <p class="stat-value">Rp 1.2M</p>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon purple">
            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
        </div>
        <div class="stat-details">
            <h4>Stok Menipis</h4>
            <p class="stat-value">8</p>
        </div>
    </div>
</div>
@endsection
