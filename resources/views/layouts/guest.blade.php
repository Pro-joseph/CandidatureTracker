<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Authentification') — CandidatureTracker</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:opsz,wght@9..40,300;9..40,400;9..40,500&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --bg-base:      #0c0e14;
            --bg-surface:   #13161f;
            --bg-raised:    #1a1e2b;
            --border:       #2a2f42;
            --border-light: #353c56;
            --text-primary: #eef0f8;
            --text-secondary:#8b91ad;
            --text-muted:   #555c7a;
            --accent:       #4f7cff;
            --accent-glow:  rgba(79,124,255,0.18);
            --accent-hover: #6b94ff;
            --danger:       #f25f5c;
            --font-display: 'Syne', sans-serif;
            --font-body:    'DM Sans', sans-serif;
            --radius-sm:    6px;
            --radius-md:    10px;
            --radius-lg:    16px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--font-body);
            background: var(--bg-base);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            -webkit-font-smoothing: antialiased;
            position: relative;
            overflow: hidden;
        }

        /* Decorative background blobs */
        body::before {
            content: '';
            position: fixed;
            top: -20%;
            right: -10%;
            width: 600px; height: 600px;
            background: radial-gradient(circle, rgba(79,124,255,.08) 0%, transparent 70%);
            pointer-events: none;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -20%;
            left: -10%;
            width: 500px; height: 500px;
            background: radial-gradient(circle, rgba(62,207,142,.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .auth-container {
            width: 100%;
            max-width: 440px;
            padding: 24px;
            position: relative;
            z-index: 1;
            animation: fadeUp .4s ease forwards;
        }

        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 32px;
        }

        .auth-logo-icon {
            width: 52px; height: 52px;
            background: var(--accent);
            border-radius: 14px;
            display: flex; align-items: center; justify-content: center;
            font-size: 24px;
            margin: 0 auto 14px;
            box-shadow: 0 0 40px rgba(79,124,255,.3);
        }

        .auth-logo h1 {
            font-family: var(--font-display);
            font-size: 22px;
            font-weight: 700;
            color: var(--text-primary);
        }

        .auth-logo h1 span { color: var(--accent); }

        .auth-logo p {
            font-size: 14px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .auth-card {
            background: var(--bg-surface);
            border: 1px solid var(--border);
            border-radius: var(--radius-lg);
            padding: 32px;
            box-shadow: 0 20px 60px rgba(0,0,0,.5);
        }

        .auth-card h2 {
            font-family: var(--font-display);
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 6px;
        }

        .auth-card .auth-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin-bottom: 28px;
        }

        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: var(--text-secondary);
            margin-bottom: 7px;
        }

        .form-control {
            width: 100%;
            padding: 11px 14px;
            background: var(--bg-raised);
            border: 1px solid var(--border);
            border-radius: var(--radius-sm);
            color: var(--text-primary);
            font-family: var(--font-body);
            font-size: 14px;
            transition: border-color .15s, box-shadow .15s;
            outline: none;
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px var(--accent-glow);
        }

        .form-control::placeholder { color: var(--text-muted); }

        .form-error {
            font-size: 12px;
            color: var(--danger);
            margin-top: 5px;
        }

        .btn-auth {
            width: 100%;
            padding: 12px;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: var(--font-display);
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all .2s;
            letter-spacing: .02em;
            margin-top: 8px;
        }

        .btn-auth:hover {
            background: var(--accent-hover);
            box-shadow: 0 4px 20px rgba(79,124,255,.35);
            transform: translateY(-1px);
        }

        .auth-link {
            text-align: center;
            margin-top: 20px;
            font-size: 14px;
            color: var(--text-muted);
        }

        .auth-link a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .auth-link a:hover { text-decoration: underline; }

        .divider-text {
            text-align: center;
            font-size: 12px;
            color: var(--text-muted);
            position: relative;
            margin: 20px 0;
        }

        .divider-text::before, .divider-text::after {
            content: '';
            position: absolute;
            top: 50%;
            width: 38%;
            height: 1px;
            background: var(--border);
        }
        .divider-text::before { left: 0; }
        .divider-text::after  { right: 0; }

        .alert-error {
            background: rgba(242,95,92,.1);
            border: 1px solid rgba(242,95,92,.2);
            border-radius: var(--radius-sm);
            padding: 11px 14px;
            font-size: 13px;
            color: var(--danger);
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <div class="auth-logo">
            <div class="auth-logo-icon">📋</div>
            <h1>Candidature<span>Tracker</span></h1>
            <p>Gérez vos candidatures en toute sérénité</p>
        </div>
        @yield('content')
    </div>
</body>
</html>