<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Apotekku')</title>
    <!-- Include Inter font -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <style>
        :root {
            --primary-color: #0d9488;
            --primary-hover: #0f766e;
            --primary-light: #ccfbf1;
            --bg-color: #f0fdfa; /* matched to login */
            --sidebar-bg: #ffffff; /* modern light sidebar */
            --sidebar-text: #4b5563; /* grey text */
            --sidebar-hover: #f3f4f6;
            --sidebar-active: #0d9488;
            --sidebar-active-bg: #ccfbf1;
            --text-color: #1f2937;
            --card-bg: #ffffff;
            --border-color: #e5e7eb;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styles */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: var(--sidebar-text);
            display: flex;
            flex-direction: column;
            transition: width 0.3s;
            border-right: 1px solid var(--border-color);
            box-shadow: 2px 0 10px rgba(13, 148, 136, 0.05);
        }

        .sidebar-header {
            padding: 1.5rem;
            text-align: center;
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-header h2 {
            color: var(--primary-color);
            margin: 0;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .nav-menu {
            list-style: none;
            padding: 1.5rem 1rem;
            margin: 0;
            flex-grow: 1;
        }

        .nav-item {
            margin-bottom: 0.5rem;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 0.85rem 1rem;
            color: var(--sidebar-text);
            text-decoration: none;
            border-radius: 0.75rem;
            transition: all 0.2s ease-in-out;
            font-weight: 500;
        }

        .nav-link:hover {
            background-color: var(--sidebar-hover);
            color: var(--text-color);
            transform: translateX(4px);
        }

        .nav-link.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active);
            font-weight: 600;
        }

        .nav-link span {
            flex-grow: 1;
        }

        .chevron {
            width: 16px;
            height: 16px;
            transition: transform 0.3s;
        }

        .nav-link.active .chevron {
            transform: rotate(180deg);
        }

        .dropdown-menu {
            list-style: none;
            padding: 0;
            margin: 0;
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out, opacity 0.3s ease-out;
            opacity: 0;
            background-color: #f9fafb;
            border-radius: 0 0 0.75rem 0.75rem;
        }

        .dropdown-item {
            display: block;
            padding: 0.6rem 1rem 0.6rem 3rem;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.9rem;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background-color: var(--sidebar-hover);
            color: var(--primary-color);
        }

        .nav-icon {
            margin-right: 0.85rem;
            width: 20px;
            height: 20px;
        }

        .user-profile {
            padding: 1.25rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(243,244,246,0.5) 100%);
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-avatar {
            width: 42px;
            height: 42px;
            background-color: var(--primary-light);
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--primary-color);
            font-weight: bold;
            margin-right: 0.75rem;
            border: 2px solid var(--primary-color);
        }

        .user-name {
            color: var(--text-color);
            font-size: 0.95rem;
            font-weight: 600;
        }

        .user-role {
            font-size: 0.8rem;
            color: #6b7280;
        }

        .logout-btn {
            background: none;
            border: none;
            color: #9ca3af;
            cursor: pointer;
            padding: 0.5rem;
            transition: color 0.2s, background-color 0.2s;
            border-radius: 0.5rem;
            display: flex;
            align-items: center;
        }

        .logout-btn:hover {
            color: #ef4444;
            background-color: #fee2e2;
        }

        /* Main Content Styles */
        .main-content {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }

        .top-navbar {
            background-color: var(--sidebar-bg);
            padding: 1.25rem 2.5rem;
            box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid var(--border-color);
            z-index: 10;
        }

        .page-title {
            margin: 0;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-color);
        }

        .content-area {
            padding: 2.5rem;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(17, 24, 39, 0.5); /* semi-transparent dark bg */
            backdrop-filter: blur(4px);
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .modal.show {
            display: flex;
            opacity: 1;
        }

        .modal-content {
            background-color: var(--card-bg);
            border-radius: 1.25rem;
            padding: 2rem;
            width: 100%;
            max-width: 500px;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            transform: scale(0.95) translateY(20px);
            transition: transform 0.3s ease;
            position: relative;
            max-height: 90vh; /* Prevent modal from exceeding window height */
            overflow-y: auto;  /* Scroll entire modal content if needed */
        }
        
        /* Larger modal for Obat */
        .modal-lg {
            max-width: 800px;
        }

        .modal.show .modal-content {
            transform: scale(1) translateY(0);
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            margin: 0;
            color: var(--text-color);
            font-size: 1.25rem;
            font-weight: 700;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 1.5rem;
            color: #9ca3af;
            cursor: pointer;
            transition: color 0.2s;
            line-height: 1;
        }

        .close-btn:hover {
            color: #ef4444;
        }
        
        /* Modal Form Styles */
        .modal .form-group {
            margin-bottom: 1.25rem;
        }
        
        .modal label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
            font-size: 0.9rem;
        }
        
        .modal .form-control {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            font-family: inherit;
            font-size: 0.95rem;
            transition: border-color 0.2s, box-shadow 0.2s;
            box-sizing: border-box;
            background-color: white;
        }
        
        .modal .form-control:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px var(--primary-light);
        }

        .modal-footer {
            margin-top: 2rem;
            display: flex;
            justify-content: flex-end;
            gap: 0.75rem;
        }

        /* Global UI Components */
        .card { 
            background-color: var(--card-bg); 
            border-radius: 1rem; 
            box-shadow: 0 10px 15px -3px rgba(13, 148, 136, 0.1), 0 4px 6px -4px rgba(13, 148, 136, 0.05); 
            border: 1px solid rgba(229, 231, 235, 0.6); 
            overflow: hidden; 
            transition: all 0.3s ease;
        }

        .card-header { 
            padding: 1.5rem 2rem; 
            border-bottom: 1px solid var(--border-color); 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            background: linear-gradient(to right, #ffffff, #f0fdfa); 
        }

        .btn { 
            padding: 0.6rem 1.25rem; 
            border-radius: 0.5rem; 
            font-weight: 600; 
            text-decoration: none; 
            cursor: pointer; 
            display: inline-flex; 
            align-items: center; 
            justify-content: center;
            border: none; 
            font-size: 0.875rem; 
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1); 
            gap: 0.4rem;
        }

        .btn:active { transform: scale(0.97); }

        .btn-primary { 
            background-color: var(--primary-color); 
            color: white; 
            box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.2);
        }
        .btn-primary:hover { 
            background-color: var(--primary-hover); 
            box-shadow: 0 6px 8px -1px rgba(13, 148, 136, 0.3);
            transform: translateY(-1px);
        }

        .btn-secondary { background-color: #f3f4f6; color: #4b5563; border: 1px solid #e5e7eb; }
        .btn-secondary:hover { background-color: #e5e7eb; }

        .btn-edit { background-color: #f59e0b; color: white; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.2); }
        .btn-edit:hover { background-color: #d97706; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(245, 158, 11, 0.3); }

        .btn-delete { background-color: #ef4444; color: white; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.2); }
        .btn-delete:hover { background-color: #dc2626; transform: translateY(-1px); box-shadow: 0 4px 6px rgba(239, 68, 68, 0.3); }
        
        .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: 0.375rem; }

        /* Table Styling */
        .table-responsive { 
            overflow-x: auto; 
            padding: 1.5rem 2rem 2.5rem;
        }
        
        table { 
            width: 100%; 
            border-collapse: separate; 
            border-spacing: 0;
            border-radius: 0.75rem;
            overflow: hidden;
            border: 1px solid var(--border-color);
        }
        
        th { 
            background-color: #f8fafc; 
            padding: 1rem 1.5rem; 
            text-align: left; 
            font-size: 0.75rem; 
            text-transform: uppercase; 
            letter-spacing: 0.05em;
            color: #64748b; 
            font-weight: 700;
            border-bottom: 2px solid var(--border-color);
        }
        
        td { 
            padding: 1.125rem 1.5rem; 
            border-bottom: 1px solid var(--border-color); 
            color: var(--text-color); 
            font-size: 0.95rem;
            vertical-align: middle;
        }
        
        tr:last-child td { border-bottom: none; }
        tr:hover td { background-color: #f8fafc; cursor: default; }

        .text-danger { color: #ef4444; font-size: 0.85rem; margin-top: 0.35rem; font-weight: 500;}

        /* DataTables Custom Overrides */
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.4rem 0.75rem;
            margin-left: 0.5rem;
            outline: none;
        }
        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px var(--primary-light);
        }
        .dataTables_wrapper .dataTables_length select {
            border: 1px solid var(--border-color);
            border-radius: 0.5rem;
            padding: 0.3rem 1.5rem 0.3rem 0.5rem;
            outline: none;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-light) !important;
            border-color: var(--primary-color) !important;
            color: var(--primary-hover) !important;
            border-radius: 0.5rem;
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background: var(--primary-color) !important;
            color: white !important;
            border-color: var(--primary-hover) !important;
            border-radius: 0.5rem;
        }
        table.dataTable.no-footer {
            border-bottom: 1px solid var(--border-color) !important;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem; 
            border-radius: 0.75rem; 
            margin-bottom: 1.5rem; 
            display: flex;
            align-items: center;
            font-weight: 500;
            box-shadow: 0 2px 4px rgba(0,0,0,0.02);
        }
        .alert-success {
            background-color: #ecfdf5; 
            color: #065f46; 
            border: 1px solid #a7f3d0;
            border-left: 4px solid #10b981;
        }
        .alert-danger {
            background-color: #fef2f2; 
            color: #991b1b; 
            border: 1px solid #fecaca;
            border-left: 4px solid #ef4444;
        }
        
        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.025em;
        }
        .badge-teal { background-color: var(--primary-light); color: var(--primary-hover); }
        .badge-blue { background-color: #e0f2fe; color: #0369a1; }
        .badge-purple { background-color: #f3e8ff; color: #6b21a8; }
        .badge-gray { background-color: #f3f4f6; color: #4b5563; }
        
        /* Modals Extra styling */
        .grid-2-col { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
        @media (max-width: 640px) { .grid-2-col { grid-template-columns: 1fr; gap: 0; } }

        /* Common Custom Styles that can be overridden by views */
        @yield('styles')
    </style>
</head>
<body>

    <!-- Sidebar included from partial -->
    @include('partials.sidebar')

    <!-- Main Content -->
    <main class="main-content">
        <header class="top-navbar">
            <h1 class="page-title">@yield('page_title', 'Dashboard Overview')</h1>
            <div style="font-size: 0.875rem; color: #6b7280;">
                {{ \Carbon\Carbon::now()->format('l, d F Y') }}
            </div>
        </header>

        <div class="content-area">
            @yield('content')
        </div>
    </main>

    <!-- Modals Container -->
    <div id="modal-container">
        @stack('modals')
    </div>

    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            if ($('.datatable').length > 0) {
                $('.datatable').DataTable({
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/id.json"
                    },
                    "pageLength": 10,
                    "ordering": true,
                    "info": true,
                    "autoWidth": false
                });
            }
        });
    </script>

    <!-- Base Modal Scripts via Stack -->
    @stack('scripts')
</body>
</html>
