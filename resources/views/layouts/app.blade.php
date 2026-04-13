<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'E-Ticket Pro')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=DM+Mono:wght@400;500&display=swap"
        rel="stylesheet">

    <style>
        /* ═══════════════════════════════════════════
           DESIGN TOKENS
        ═══════════════════════════════════════════ */
        :root {
            --red: #e11d48;
            --red-soft: #f43f5e;
            --red-muted: #ffe4e6;
            --red-faint: #fff1f2;

            --ink: #0f0f0f;
            --ink-2: #1c1c1c;
            --ink-3: #3d3d3d;
            --ink-4: #6b6b6b;
            --ink-5: #9e9e9e;

            --stone-1: #fafaf9;
            --stone-2: #f5f5f4;
            --stone-3: #e7e5e4;
            --stone-4: #d6d3d1;

            --white: #ffffff;

            --ok: #16a34a;
            --ok-bg: #f0fdf4;
            --ok-border: #bbf7d0;
            --warn: #b45309;
            --warn-bg: #fffbeb;
            --warn-border: #fde68a;
            --info: #1d4ed8;
            --info-bg: #eff6ff;
            --info-border: #bfdbfe;
            --danger: #e11d48;
            --danger-bg: #fff1f2;
            --danger-border: #fecdd3;

            --r-sm: 6px;
            --r-md: 10px;
            --r-lg: 16px;
            --r-xl: 22px;

            --nav-h: 58px;
            --content-w: 1180px;

            --shadow-xs: 0 1px 2px rgba(0, 0, 0, .06);
            --shadow-sm: 0 2px 8px rgba(0, 0, 0, .08);
            --shadow-md: 0 4px 16px rgba(0, 0, 0, .10);
            --shadow-red: 0 4px 16px rgba(225, 29, 72, .18);

            /* Compatibility tokens for refreshed customer/admin views */
            --r-50: var(--red-faint);
            --r-100: var(--red-muted);
            --r-200: #fecdd3;
            --r-300: #fda4af;
            --r-400: var(--red-soft);
            --r-500: #f43f5e;
            --r-600: var(--red);
            --r-700: #be123c;

            --n-50: var(--stone-1);
            --n-100: var(--stone-2);
            --n-200: var(--stone-3);
            --n-300: var(--stone-4);
            --n-400: #a3a3a3;
            --n-500: #737373;
            --n-600: #525252;
            --n-700: #404040;
            --n-800: #262626;
            --n-900: var(--ink);

            --surface: var(--white);
            --surface-alt: var(--stone-1);
            --border: var(--stone-3);
            --border-md: var(--stone-4);

            --success-bg: var(--ok-bg);
            --success-border: var(--ok-border);
            --success-text: var(--ok);
            --warning-bg: var(--warn-bg);
            --warning-border: var(--warn-border);
            --warning-text: var(--warn);
            --info-text: var(--info);
            --danger-text: var(--danger);
        }

        /* ═══════════════════════════════════════════
           RESET & BASE
        ═══════════════════════════════════════════ */
        *,
        *::before,
        *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--stone-1);
            color: var(--ink);
            font-size: 13.5px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
            min-height: 100vh;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        button,
        input,
        select,
        textarea {
            font-family: inherit;
        }

        /* ═══════════════════════════════════════════
           TOPBAR / NAV
        ═══════════════════════════════════════════ */
        .topbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--white);
            border-bottom: 1px solid var(--stone-3);
            box-shadow: var(--shadow-xs);
            height: var(--nav-h);
        }

        .topbar-inner {
            max-width: var(--content-w);
            margin: 0 auto;
            padding: 0 1.5rem;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        /* Brand */
        .topbar-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            font-size: 15px;
            letter-spacing: -0.03em;
            color: var(--ink);
            white-space: nowrap;
        }

        .brand-mark {
            width: 32px;
            height: 32px;
            background: var(--red);
            border-radius: var(--r-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: var(--shadow-red);
        }

        .brand-mark svg {
            width: 14px;
            height: 14px;
            color: white;
        }

        .brand-text em {
            font-style: normal;
            color: var(--red);
        }

        /* Nav links */
        .topbar-nav {
            display: flex;
            align-items: center;
            gap: 1px;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 11px;
            border-radius: var(--r-md);
            font-size: 13px;
            font-weight: 500;
            color: var(--ink-4);
            transition: background .15s, color .15s;
        }

        .nav-link:hover {
            background: var(--stone-2);
            color: var(--ink);
        }

        .nav-link.active {
            background: var(--red-faint);
            color: var(--red);
            font-weight: 600;
        }

        .nav-sep {
            width: 1px;
            height: 16px;
            background: var(--stone-3);
            margin: 0 6px;
        }

        .nav-greeting {
            font-size: 13px;
            color: var(--ink-5);
            padding: 0 6px;
            font-weight: 500;
            white-space: nowrap;
        }

        /* ═══════════════════════════════════════════
           BUTTONS
        ═══════════════════════════════════════════ */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            padding: 7px 14px;
            border-radius: var(--r-md);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            white-space: nowrap;
            line-height: 1;
            transition: all .15s;
            border: 1.5px solid var(--stone-4);
            background: var(--white);
            color: var(--ink);
        }

        .btn:hover {
            background: var(--stone-2);
        }

        .btn:active {
            transform: scale(.98);
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
        }

        .btn-primary {
            background: var(--red);
            border-color: var(--red);
            color: white;
            box-shadow: var(--shadow-red);
        }

        .btn-primary:hover {
            background: var(--r-700);
            border-color: var(--r-700);
            color: white;
        }

        .btn-secondary {
            background: var(--white);
            border-color: var(--stone-4);
            color: var(--ink);
        }

        .btn-secondary:hover {
            background: var(--stone-2);
        }

        .btn-danger {
            background: var(--danger-bg);
            border-color: var(--danger-border);
            color: var(--danger);
        }

        .btn-danger:hover {
            background: #fff1f2;
        }

        /* ═══════════════════════════════════════════
           LAYOUT
        ═══════════════════════════════════════════ */
        .main-content {
            max-width: var(--content-w);
            margin: 0 auto;
            padding: 2rem 1.5rem;
        }

        /* ═══════════════════════════════════════════
           ALERTS
        ═══════════════════════════════════════════ */
        .alert {
            display: flex;
            gap: 10px;
            align-items: flex-start;
            border-radius: var(--r-lg);
            padding: 12px 14px;
            margin-bottom: 1rem;
            border: 1.5px solid;
            font-size: 13px;
            line-height: 1.6;
        }

        .alert-icon {
            flex-shrink: 0;
            width: 15px;
            height: 15px;
            margin-top: 1px;
        }

        .alert-body {
            flex: 1;
        }

        .alert-title {
            font-weight: 600;
            margin-bottom: 2px;
        }

        .alert-success {
            background: var(--ok-bg);
            border-color: var(--ok-border);
            color: var(--ok);
        }

        .alert-danger {
            background: var(--danger-bg);
            border-color: var(--danger-border);
            color: var(--danger);
        }

        .alert ul {
            list-style: none;
            padding: 0;
        }

        .alert ul li+li {
            margin-top: 2px;
        }

        /* ═══════════════════════════════════════════
           PAGE HEADER
        ═══════════════════════════════════════════ */
        .page-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 1rem;
            flex-wrap: wrap;
            margin-bottom: 1.5rem;
        }

        .page-title {
            font-size: 20px;
            font-weight: 700;
            letter-spacing: -0.03em;
            margin: 0;
        }

        .page-subtitle {
            font-size: 13px;
            color: var(--ink-5);
            margin: 3px 0 0;
        }

        /* ═══════════════════════════════════════════
           STAT CARDS
        ═══════════════════════════════════════════ */
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: var(--white);
            border: 1.5px solid var(--stone-3);
            border-radius: var(--r-xl);
            padding: 1.25rem 1.375rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: border-color .15s, box-shadow .15s;
        }

        .stat-card:hover {
            border-color: var(--stone-4);
            box-shadow: var(--shadow-sm);
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: var(--r-md);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .stat-icon--blue {
            background: #dbeafe;
            color: #1d4ed8;
        }

        .stat-icon--amber {
            background: #fef3c7;
            color: #d97706;
        }

        .stat-icon--green {
            background: #dcfce7;
            color: #16a34a;
        }

        .stat-icon--red {
            background: var(--red-muted);
            color: var(--red);
        }

        .stat-icon svg {
            width: 16px;
            height: 16px;
        }

        .stat-info {}

        .stat-label {
            font-size: 11px;
            font-weight: 600;
            color: var(--ink-5);
            text-transform: uppercase;
            letter-spacing: .05em;
            margin-bottom: 4px;
        }

        .stat-value {
            font-size: 26px;
            font-weight: 700;
            line-height: 1;
            letter-spacing: -0.04em;
        }

        /* ═══════════════════════════════════════════
           CARD
        ═══════════════════════════════════════════ */
        .card {
            background: var(--white);
            border: 1.5px solid var(--stone-3);
            border-radius: var(--r-xl);
            overflow: hidden;
        }

        .card-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--stone-3);
        }

        .card-title {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: -0.01em;
        }

        /* ═══════════════════════════════════════════
           TABLE
        ═══════════════════════════════════════════ */
        .table-wrap {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .table th {
            text-align: left;
            padding: 9px 14px;
            font-size: 11px;
            font-weight: 600;
            color: var(--ink-5);
            text-transform: uppercase;
            letter-spacing: .05em;
            border-bottom: 1px solid var(--stone-3);
            background: var(--stone-1);
            white-space: nowrap;
        }

        .table td {
            padding: 11px 14px;
            border-bottom: 1px solid var(--stone-2);
            vertical-align: middle;
        }

        .table tbody tr:last-child td {
            border-bottom: none;
        }

        .table tbody tr:hover td {
            background: var(--stone-1);
        }

        /* Table helpers */
        .td-main {
            display: block;
            font-weight: 600;
            color: var(--ink);
        }

        .td-sub {
            display: block;
            font-size: 11.5px;
            color: var(--ink-5);
            margin-top: 2px;
        }

        .td-price {
            font-weight: 600;
            color: var(--red);
            font-family: 'DM Mono', monospace;
        }

        .route-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-weight: 600;
            font-size: 12px;
            background: var(--stone-2);
            border: 1px solid var(--stone-3);
            border-radius: 20px;
            padding: 3px 10px;
            font-family: 'DM Mono', monospace;
            letter-spacing: .02em;
        }

        .route-pill svg {
            color: var(--ink-5);
            flex-shrink: 0;
        }

        .action-group {
            display: flex;
            gap: 6px;
        }

        /* ═══════════════════════════════════════════
           BADGES
        ═══════════════════════════════════════════ */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 2px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            white-space: nowrap;
            border: 1.5px solid transparent;
        }

        .badge-success {
            background: var(--ok-bg);
            color: var(--ok);
            border-color: var(--ok-border);
        }

        .badge-warning {
            background: var(--warn-bg);
            color: var(--warn);
            border-color: var(--warn-border);
        }

        .badge-danger {
            background: var(--danger-bg);
            color: var(--danger);
            border-color: var(--danger-border);
        }

        .badge-info {
            background: var(--info-bg);
            color: var(--info);
            border-color: var(--info-border);
        }

        .badge-gray {
            background: var(--stone-2);
            color: var(--ink-4);
            border-color: var(--stone-3);
        }

        .badge-primary {
            background: var(--red-faint);
            color: var(--red);
            border-color: var(--red-muted);
        }

        /* ═══════════════════════════════════════════
           TOOLBAR
        ═══════════════════════════════════════════ */
        .toolbar {
            padding: .75rem 1.25rem;
            border-bottom: 1px solid var(--stone-3);
            display: flex;
            align-items: center;
            gap: .5rem;
        }

        .toolbar .form-control {
            max-width: 280px;
            height: 34px;
            font-size: 13px;
            padding: 0 10px;
        }

        .toolbar .btn {
            height: 34px;
            padding: 0 14px;
        }

        /* ═══════════════════════════════════════════
           FORMS
        ═══════════════════════════════════════════ */
        .form-card {
            background: var(--white);
            border: 1.5px solid var(--stone-3);
            border-radius: var(--r-xl);
            max-width: 700px;
            margin: 0 auto;
            overflow: hidden;
        }

        .form-body {
            padding: 1.5rem;
            display: flex;
            flex-direction: column;
            gap: 1.125rem;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
        }

        .form-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--ink-3);
            margin-bottom: 6px;
            letter-spacing: .01em;
        }

        .form-control {
            width: 100%;
            padding: 8px 11px;
            font-size: 13px;
            color: var(--ink);
            background: var(--stone-1);
            border: 1.5px solid var(--stone-3);
            border-radius: var(--r-md);
            transition: border-color .15s, box-shadow .15s;
            line-height: 1.5;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--red-soft);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, .10);
        }

        .form-control::placeholder {
            color: var(--ink-5);
        }

        .input-prefix-wrap {
            position: relative;
        }

        .input-prefix {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 12px;
            color: var(--ink-4);
            pointer-events: none;
            font-weight: 600;
            font-family: 'DM Mono', monospace;
        }

        .input-has-prefix {
            padding-left: 30px;
        }

        .form-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--stone-3);
        }

        .form-footer-actions {
            display: flex;
            gap: 8px;
        }

        /* ═══════════════════════════════════════════
           BACK LINK
        ═══════════════════════════════════════════ */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            color: var(--ink-5);
            margin-bottom: 1.25rem;
            font-weight: 500;
            transition: color .15s;
        }

        .back-link:hover {
            color: var(--red);
        }

        /* ═══════════════════════════════════════════
           EMPTY STATE
        ═══════════════════════════════════════════ */
        .empty-state {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            padding: 3rem 1rem;
            color: var(--ink-5);
            font-size: 13px;
            text-align: center;
        }

        .empty-icon {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: var(--stone-2);
            border: 1.5px solid var(--stone-3);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--ink-5);
            margin-bottom: 4px;
        }

        /* ═══════════════════════════════════════════
           PAGINATION
        ═══════════════════════════════════════════ */
        .pager {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
            padding: .75rem 1.25rem;
            border-top: 1px solid var(--stone-3);
        }

        .pager__info {
            color: var(--ink-5);
            font-size: 12.5px;
        }

        .pager__actions {
            display: flex;
            align-items: center;
            gap: .375rem;
            flex-wrap: wrap;
        }

        .pager__page {
            min-width: 32px;
            height: 32px;
            border-radius: var(--r-md);
            border: 1.5px solid var(--stone-3);
            background: var(--white);
            color: var(--ink);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 .625rem;
            font-size: 13px;
            font-weight: 500;
            transition: all .15s;
        }

        .pager__page:hover {
            border-color: var(--red-muted);
            color: var(--red);
        }

        .pager__page.is-active {
            background: var(--red);
            border-color: var(--red);
            color: white;
            font-weight: 600;
        }

        .paginator-wrap {
            display: flex;
            justify-content: flex-end;
            padding: .75rem 1.25rem;
            border-top: 1px solid var(--stone-3);
        }

        /* ═══════════════════════════════════════════
           ADMIN SPECIFIC
        ═══════════════════════════════════════════ */
        .btn-icon-edit {
            background: var(--info-bg);
            border-color: var(--info-border);
            color: var(--info);
        }

        .btn-icon-edit:hover {
            background: #dbeafe;
            color: var(--info);
        }

        .btn-icon-del {
            background: var(--danger-bg);
            border-color: var(--danger-border);
            color: var(--danger);
        }

        .btn-icon-del:hover {
            background: var(--r-100);
            color: var(--danger);
        }

        .proof-link {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 11px;
            color: var(--info);
            padding: 3px 8px;
            background: var(--info-bg);
            border: 1.5px solid var(--info-border);
            border-radius: var(--r-sm);
        }

        .section-gap {
            margin-top: 1.5rem;
        }

        .user-name {
            font-weight: 600;
            font-size: 13px;
        }

        .user-meta {
            font-size: 11.5px;
            color: var(--ink-5);
            margin-top: 2px;
        }

        .departure-date {
            font-size: 13px;
            font-weight: 600;
        }

        .departure-meta {
            font-size: 11.5px;
            color: var(--ink-5);
            margin-top: 2px;
        }

        .price-tag {
            font-weight: 600;
            color: var(--red);
            font-family: 'DM Mono', monospace;
            font-size: 13px;
        }

        .actions {
            display: flex;
            gap: 6px;
        }

        /* ═══════════════════════════════════════════
           UTILITIES
        ═══════════════════════════════════════════ */
        .text-sm {
            font-size: 12px;
        }

        .text-secondary {
            color: var(--ink-5) !important;
        }

        .text-muted {
            color: var(--ink-5) !important;
        }

        .fw-medium {
            font-weight: 600;
        }

        .text-center {
            text-align: center;
        }

        .mt-1 {
            margin-top: .25rem;
        }

        .mt-2 {
            margin-top: .5rem;
        }

        .mt-4 {
            margin-top: 1rem;
        }

        .mb-2 {
            margin-bottom: .5rem;
        }

        .mb-4 {
            margin-bottom: 1rem;
        }

        .d-flex {
            display: flex;
        }

        .d-none {
            display: none !important;
        }

        .align-items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .justify-center {
            justify-content: center;
        }

        .flex-wrap {
            flex-wrap: wrap;
        }

        .gap-2 {
            gap: .5rem;
        }

        .gap-3 {
            gap: .75rem;
        }

        /* ═══════════════════════════════════════════
           ID CHIP
        ═══════════════════════════════════════════ */
        .id-chip {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            background: var(--stone-2);
            border: 1.5px solid var(--stone-3);
            border-radius: 99px;
            padding: 2px 10px;
            font-size: 11px;
            color: var(--ink-5);
            font-weight: 500;
            font-family: 'DM Mono', monospace;
        }

        /* ═══════════════════════════════════════════
           BADGE-STACK
        ═══════════════════════════════════════════ */
        .badge-stack {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        @media (max-width: 768px) {
            .stat-grid {
                grid-template-columns: 1fr 1fr;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    @yield('styles')
</head>

<body>

    <header class="topbar">
        <div class="topbar-inner">
            <a href="{{ url('/') }}" class="topbar-brand">
                <div class="brand-mark">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path
                            d="M17.8 19.2 16 11l3.5-3.5C21 6 21.5 4 21 3c-1-.5-3 0-4.5 1.5L13 8 4.8 6.2c-.5-.1-.9.2-1.1.5l-1 2c-.1.3-.1.6.1.8l6.8 5.6-2.5 2.5-4.2-1.3c-.3-.1-.6 0-.8.2l-1 1c-.3.3-.3.7 0 .9l3.5 1.8 1.8 3.5c.2.3.6.3.9 0l1-1c.2-.2.3-.5.2-.8L6.4 17l2.5-2.5 5.6 6.8c.2.2.5.2.8.1l2-1c.3-.2.6-.6.5-1.1z" />
                    </svg>
                </div>
                <span class="brand-text">E-Ticket <em>Pro</em></span>
            </a>

            <nav class="topbar-nav">
                @auth
                    @if(Auth::user()->isAdmin())
                        <a href="{{ url('/dashboard') }}"
                            class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">Dashboard</a>
                        <a href="{{ url('/admin/schedules/create') }}"
                            class="nav-link {{ Request::is('admin/schedules/create') ? 'active' : '' }}">Tambah Jadwal</a>
                    @else
                        <a href="{{ url('/dashboard') }}"
                            class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">Jadwal</a>
                        <a href="{{ url('/history') }}"
                            class="nav-link {{ Request::is('history') ? 'active' : '' }}">Riwayat</a>
                    @endif
                    <div class="nav-sep"></div>
                    <span class="nav-greeting">{{ Auth::user()->name ?? 'Customer' }}</span>
                    <a href="{{ url('/logout') }}" class="btn btn-secondary btn-sm" style="margin-left:4px;">Keluar</a>
                @else
                    <a href="{{ url('/login') }}" class="nav-link">Masuk</a>
                    <a href="{{ url('/register') }}" class="btn btn-primary btn-sm" style="margin-left:4px;">Daftar</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success" role="alert">
                <svg class="alert-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                        clip-rule="evenodd" />
                </svg>
                <div class="alert-body">
                    <p class="alert-title">Berhasil</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger" role="alert">
                <svg class="alert-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div class="alert-body">
                    <p class="alert-title">Terjadi kesalahan</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <svg class="alert-icon" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                        clip-rule="evenodd" />
                </svg>
                <div class="alert-body">
                    <p class="alert-title">Mohon perbaiki kesalahan berikut:</p>
                    <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            </div>
        @endif

        @yield('content')
    </main>

    @yield('scripts')
</body>

</html>
