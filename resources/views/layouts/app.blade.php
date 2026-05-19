<!DOCTYPE html>
<html lang="fr" data-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'CandidatureTracker') — CandidatureTracker</title>

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">

    {{-- Vite Assets --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [data-theme="dark"] {
            --bg-base:       #0c0e14;
            --bg-surface:    #13161f;
            --bg-raised:     #1a1e2b;
            --bg-overlay:    #222638;
            --border:        #2a2f42;
            --border-light:  #353c56;
            --text-primary:  #eef0f8;
            --text-secondary:#8b91ad;
            --text-muted:    #555c7a;
            --accent:        #4f7cff;
            --accent-glow:   rgba(79,124,255,0.18);
            --accent-hover:  #6b94ff;
            --success:       #3ecf8e;
            --warning:       #f5a623;
            --danger:        #f25f5c;
            --info:          #38bdf8;
            --shadow-sm:     0 1px 3px rgba(0,0,0,.4);
            --shadow-md:     0 4px 16px rgba(0,0,0,.5);
            --shadow-lg:     0 12px 40px rgba(0,0,0,.6);
        }

        [data-theme="light"] {
            --bg-base:       #f4f6fa;
            --bg-surface:    #ffffff;
            --bg-raised:     #eef1f6;
            --bg-overlay:    #e4e8f0;
            --border:        #d0d6e0;
            --border-light:  #b8bfcc;
            --text-primary:  #1a1d26;
            --text-secondary:#5a6072;
            --text-muted:    #8b92a5;
            --accent:        #4f7cff;
            --accent-glow:   rgba(79,124,255,0.12);
            --accent-hover:  #3b64d9;
            --success:       #16a34a;
            --warning:       #d97706;
            --danger:        #dc2626;
            --info:          #0284c7;
            --shadow-sm:     0 1px 3px rgba(0,0,0,.08);
            --shadow-md:     0 4px 16px rgba(0,0,0,.1);
            --shadow-lg:     0 12px 40px rgba(0,0,0,.13);
        }

        [data-theme="light"] body::before { opacity: 0; }

        :root {
            --font-display:  'Syne', sans-serif;
            --font-body:     'DM Sans', sans-serif;
            --radius-sm:     6px;
            --radius-md:     10px;
            --radius-lg:     16px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        html { scroll-behavior: smooth; }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── NOISE TEXTURE OVERLAY ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.03'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: .4;
        }

        /* ── SIDEBAR LAYOUT ── */
        .app-shell {
            display: flex;
            min-height: 100vh;
            position: relative;
            z-index: 1;
        }

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: var(--bg-surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
            transition: transform .25s ease;
        }

        .sidebar-logo {
            padding: 28px 24px 20px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo a {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .logo-icon {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: var(--radius-sm);
            display: flex; align-items: center; justify-content: center;
            font-size: 16px;
            box-shadow: 0 0 20px var(--accent-glow);
            flex-shrink: 0;
        }

        .logo-text {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 15px;
            color: var(--text-primary);
            letter-spacing: .02em;
        }

        .logo-text span {
            color: var(--accent);
        }

        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: .12em;
            text-transform: uppercase;
            color: var(--text-muted);
            padding: 12px 12px 6px;
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-sm);
            text-decoration: none;
            color: var(--text-secondary);
            font-size: 14px;
            font-weight: 400;
            transition: all .15s ease;
            position: relative;
        }

        .nav-link:hover {
            background: var(--bg-raised);
            color: var(--text-primary);
        }

        .nav-link.active {
            background: var(--accent-glow);
            color: var(--accent);
            font-weight: 500;
        }

        .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 50%;
            transform: translateY(-50%);
            width: 3px; height: 18px;
            background: var(--accent);
            border-radius: 0 2px 2px 0;
        }

        .nav-icon {
            width: 18px; height: 18px;
            flex-shrink: 0;
            opacity: .7;
        }

        .nav-link.active .nav-icon,
        .nav-link:hover .nav-icon { opacity: 1; }

        .sidebar-footer {
            padding: 16px 12px;
            border-top: 1px solid var(--border);
        }

        .user-card {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 8px 10px;
            border-radius: var(--radius-sm);
        }

        .user-avatar {
            width: 32px; height: 32px;
            border-radius: 50%;
            background: var(--accent);
            display: flex; align-items: center; justify-content: center;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 12px;
            color: #fff;
            flex-shrink: 0;
        }

        .user-info { flex: 1; min-width: 0; }
        .user-name {
            font-size: 13px;
            font-weight: 500;
            color: var(--text-primary);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .user-role {
            font-size: 11px;
            color: var(--text-muted);
        }

        .btn-logout {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: var(--radius-sm);
            background: none;
            border: none;
            color: var(--text-muted);
            font-size: 13px;
            cursor: pointer;
            transition: all .15s;
            width: 100%;
            margin-top: 4px;
            font-family: var(--font-body);
        }
        .btn-logout:hover { background: rgba(242,95,92,.1); color: var(--danger); }

        /* ── MAIN CONTENT ── */
        .main-content {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        .topbar {
            height: 60px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 32px;
            background: var(--bg-surface);
            position: sticky;
            top: 0;
            z-index: 50;
        }

        .page-breadcrumb {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 15px;
            color: var(--text-primary);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .page-body {
            padding: 32px;
            flex: 1;
        }

        /* ── BUTTONS ── */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 9px 18px;
            border-radius: var(--radius-sm);
            font-family: var(--font-body);
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all .15s ease;
            text-decoration: none;
            border: 1px solid transparent;
            line-height: 1.4;
        }

        .btn-primary {
            background: var(--accent);
            color: #fff;
            border-color: var(--accent);
            box-shadow: 0 0 0 0 var(--accent-glow);
        }
        .btn-primary:hover {
            background: var(--accent-hover);
            box-shadow: 0 0 20px var(--accent-glow);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: var(--bg-raised);
            color: var(--text-secondary);
            border-color: var(--border);
        }
        .btn-secondary:hover {
            background: var(--bg-overlay);
            color: var(--text-primary);
            border-color: var(--border-light);
        }

        .btn-danger {
            background: rgba(242,95,92,.1);
            color: var(--danger);
            border-color: rgba(242,95,92,.25);
        }
        .btn-danger:hover {
            background: rgba(242,95,92,.2);
            border-color: var(--danger);
        }

        .btn-success {
            background: rgba(62,207,142,.1);
            color: var(--success);
            border-color: rgba(62,207,142,.25);
        }
        .btn-success:hover {
            background: rgba(62,207,142,.2);
            border-color: var(--success);
        }

        .btn-sm { padding: 6px 12px; font-size: 13px; }
        .btn-icon { padding: 8px; }

        /* ── CARDS ── */
        .card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            overflow: hidden;
        }

        .card-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }

        .card-title {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 16px;
            color: var(--text-primary);
        }

        .card-body { padding: 24px; }

        /* ── BADGES / STATUS ── */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 3px 9px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            letter-spacing: .02em;
        }

        .badge-candidature  { background: rgba(79,124,255,.15); color: var(--accent); border: 1px solid rgba(79,124,255,.25); }
        .badge-entretien    { background: rgba(245,166,35,.15); color: var(--warning); border: 1px solid rgba(245,166,35,.25); }
        .badge-offre        { background: rgba(62,207,142,.15); color: var(--success); border: 1px solid rgba(62,207,142,.25); }
        .badge-relance      { background: rgba(56,189,248,.15); color: var(--info); border: 1px solid rgba(56,189,248,.25); }
        .badge-refus        { background: rgba(242,95,92,.15); color: var(--danger); border: 1px solid rgba(242,95,92,.25); }
        .badge-accepte      { background: rgba(62,207,142,.25); color: #22c55e; border: 1px solid rgba(62,207,142,.4); }
        .badge-neutre       { background: var(--bg-overlay); color: var(--text-secondary); border: 1px solid var(--border); }

        .badge-haute    { background: rgba(242,95,92,.15); color: var(--danger); border: 1px solid rgba(242,95,92,.2); }
        .badge-moyenne  { background: rgba(245,166,35,.15); color: var(--warning); border: 1px solid rgba(245,166,35,.2); }
        .badge-basse    { background: rgba(139,145,173,.1); color: var(--text-secondary); border: 1px solid var(--border); }

        /* ── FORMS ── */
        .form-group { margin-bottom: 20px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 7px;
            letter-spacing: .02em;
        }

        .form-control, .form-select, .form-textarea {
            width: 100%;
            padding: 10px 14px;
            background: var(--bg-raised);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-family: var(--font-body);
            font-size: 14px;
            transition: border-color .15s, box-shadow .15s;
            outline: none;
            appearance: none;
        }

        .form-control:focus, .form-select:focus, .form-textarea:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-control::placeholder, .form-textarea::placeholder {
            color: var(--text-muted);
        }

        .form-textarea {
            resize: vertical;
            min-height: 100px;
            line-height: 1.6;
        }

        .form-select {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%238b91ad' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
            padding-right: 36px;
        }

        .form-select option {
            background: var(--bg-raised);
            color: var(--text-primary);
        }

        .form-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .form-hint {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 5px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        @media (max-width: 600px) {
            .form-row { grid-template-columns: 1fr; }
        }

        /* ── ALERTS ── */
        .alert {
            padding: 12px 16px;
            border-radius: var(--radius-sm);
            font-size: 14px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
        }

        .alert-success { background: rgba(62,207,142,.1); border: 1px solid rgba(62,207,142,.2); color: var(--success); }
        .alert-error   { background: rgba(242,95,92,.1); border: 1px solid rgba(242,95,92,.2); color: var(--danger); }
        .alert-info    { background: rgba(79,124,255,.1); border: 1px solid rgba(79,124,255,.2); color: var(--accent); }
        .alert-warning { background: rgba(245,166,35,.1); border: 1px solid rgba(245,166,35,.2); color: var(--warning); }

        /* ── TABLES ── */
        .table-wrapper {
            overflow-x: auto;
            border-radius: var(--radius-md);
            border: 1px solid var(--border);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }

        thead tr {
            border-bottom: 1px solid var(--border);
            background: var(--bg-raised);
        }

        th {
            padding: 12px 16px;
            text-align: left;
            font-family: var(--font-display);
            font-size: 12px;
            font-weight: 600;
            letter-spacing: .06em;
            text-transform: uppercase;
            color: var(--text-muted);
            white-space: nowrap;
        }

        td {
            padding: 14px 16px;
            border-bottom: 1px solid var(--border);
            color: var(--text-secondary);
            vertical-align: middle;
        }

        tbody tr:last-child td { border-bottom: none; }

        tbody tr:hover td { background: var(--bg-raised); }

        td.td-primary { color: var(--text-primary); font-weight: 500; }

        /* ── PAGE HEADER ── */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        .page-title {
            font-family: var(--font-display);
            font-size: 26px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .page-subtitle {
            color: var(--text-muted);
            font-size: 14px;
            margin-top: 4px;
        }

        /* ── STATS GRID ── */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }

        .stat-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 8px;
            transition: border-color .2s;
        }

        .stat-card:hover { border-color: var(--border-light); }

        .stat-label {
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: .08em;
        }

        .stat-value {
            font-family: var(--font-display);
            font-size: 30px;
            font-weight: 700;
            color: var(--text-primary);
            line-height: 1;
        }

        .stat-sub {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ── EMPTY STATE ── */
        .empty-state {
            text-align: center;
            padding: 60px 24px;
        }

        .empty-icon {
            font-size: 40px;
            margin-bottom: 14px;
            opacity: .4;
        }

        .empty-title {
            font-family: var(--font-display);
            font-size: 17px;
            font-weight: 600;
            color: var(--text-secondary);
            margin-bottom: 6px;
        }

        .empty-desc {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 20px;
            max-width: 320px;
            margin-left: auto;
            margin-right: auto;
        }

        /* ── DIVIDER ── */
        .divider {
            height: 1px;
            background: var(--border);
            margin: 24px 0;
        }

        /* ── MODAL ── */
        .modal-backdrop {
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.7);
            backdrop-filter: blur(4px);
            z-index: 200;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .modal {
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: var(--radius-lg);
            width: 100%;
            max-width: 500px;
            box-shadow: var(--shadow-lg);
        }

        .modal-header {
            padding: 20px 24px;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .modal-title {
            font-family: var(--font-display);
            font-weight: 600;
            font-size: 16px;
        }

        .modal-body { padding: 24px; }
        .modal-footer {
            padding: 16px 24px;
            border-top: 1px solid var(--border);
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        /* ── SCROLLBAR ── */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-light); border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: var(--text-muted); }

        /* ── ANIMATIONS ── */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(8px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .animate-in {
            animation: fadeIn .3s ease forwards;
        }

        .stagger-1 { animation-delay: .05s; opacity: 0; }
        .stagger-2 { animation-delay: .1s;  opacity: 0; }
        .stagger-3 { animation-delay: .15s; opacity: 0; }
        .stagger-4 { animation-delay: .2s;  opacity: 0; }

        /* ── FILTER BAR ── */
        .filter-bar {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
            padding: 16px 20px;
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-md);
            margin-bottom: 20px;
        }

        .filter-bar label {
            font-size: 13px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .filter-bar .form-select {
            width: auto;
            min-width: 160px;
        }

        /* ── DETAIL META ── */
        .meta-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 16px;
        }

        .meta-item { display: flex; flex-direction: column; gap: 4px; }
        .meta-label { font-size: 11px; text-transform: uppercase; letter-spacing: .08em; color: var(--text-muted); font-weight: 600; }
        .meta-value { font-size: 14px; color: var(--text-primary); font-weight: 400; }

        /* ── FILE UPLOAD ── */
        .file-drop {
            border: 2px dashed var(--border-light);
            border-radius: var(--radius-md);
            padding: 32px 24px;
            text-align: center;
            cursor: pointer;
            transition: all .2s;
        }
        .file-drop:hover { border-color: var(--accent); background: var(--accent-glow); }
        .file-drop p { font-size: 14px; color: var(--text-muted); margin-top: 8px; }
        .file-drop span { font-size: 24px; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; }
            .page-body { padding: 20px 16px; }
            .topbar { padding: 0 16px; }
            .stats-grid { grid-template-columns: 1fr 1fr; }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="app-shell">

        {{-- ── SIDEBAR ── --}}
        <aside class="sidebar" id="sidebar">
            <div class="sidebar-logo">
                <a href="{{ route('dashboard') }}">
                    <div class="logo-icon">📋</div>
                    <div class="logo-text">Candidature<span>Tracker</span></div>
                </a>
            </div>

            <nav class="sidebar-nav">
                <span class="nav-section-label">Navigation</span>

                <a href="{{ route('dashboard') }}"
                   class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Tableau de bord
                </a>

                <a href="{{ route('candidatures.index') }}"
                   class="nav-link {{ request()->routeIs('candidatures.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Candidatures
                </a>

                <a href="{{ route('archives.index') }}"
                   class="nav-link {{ request()->routeIs('archives.*') ? 'active' : '' }}">
                    <svg class="nav-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                              d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                    </svg>
                    Archives
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="user-card">
                    <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div class="user-info">
                        <div class="user-name">{{ auth()->user()->name }}</div>
                        <div class="user-role">Candidat</div>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn-logout">
                        <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Déconnexion
                    </button>
                </form>
            </div>
        </aside>

        {{-- ── MAIN ── --}}
        <div class="main-content">
            <header class="topbar">
                <div class="page-breadcrumb">@yield('breadcrumb', 'Tableau de bord')</div>
                <div class="topbar-actions">
                    <button id="theme-toggle" class="btn btn-secondary btn-sm btn-icon" title="Changer le thème"
                            onclick="toggleTheme()">
                        <svg id="theme-icon-sun" width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <svg id="theme-icon-moon" width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display:none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
                        </svg>
                    </button>
                    <a href="{{ route('candidatures.create') }}" class="btn btn-primary btn-sm">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Nouvelle candidature
                    </a>
                </div>
            </header>

            <main class="page-body">

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success animate-in">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-error animate-in">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <script>
        // Mobile sidebar toggle
        const sidebar = document.getElementById('sidebar');
        document.addEventListener('keydown', e => {
            if (e.key === 'Escape') sidebar.classList.remove('open');
        });

        // Theme toggle
        const html = document.documentElement;
        const sun = document.getElementById('theme-icon-sun');
        const moon = document.getElementById('theme-icon-moon');

        function setTheme(theme) {
            html.setAttribute('data-theme', theme);
            localStorage.setItem('theme', theme);
            if (theme === 'light') {
                sun.style.display = 'none';
                moon.style.display = '';
            } else {
                sun.style.display = '';
                moon.style.display = 'none';
            }
        }

        function toggleTheme() {
            setTheme(html.getAttribute('data-theme') === 'dark' ? 'light' : 'dark');
        }

        // Restore saved theme
        const saved = localStorage.getItem('theme');
        if (saved) setTheme(saved);
    </script>
    @stack('scripts')
</body>
</html>