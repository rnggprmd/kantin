<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Login') — Kantin Maria</title>

    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-container': '#15173d',
                        'secondary': '#9d2a9d',
                        'secondary-fixed': '#ffd7f6',
                        'surface': '#f8f9fa',
                        'surface-container': '#edeeef',
                        'on-surface': '#191c1d',
                        'on-surface-variant': '#46464e',
                        'outline': '#77767f',
                        'outline-variant': '#c7c5cf',
                        'error': '#ba1a1a',
                        'error-container': '#ffdad6',
                    },
                    fontFamily: {
                        'headline': ['Plus Jakarta Sans', 'sans-serif'],
                        'sans': ['Inter', 'ui-sans-serif', 'system-ui'],
                    }
                }
            }
        }
    </script>

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700;800&family=Inter:wght@400;500;600&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        @keyframes float {
            0%   { transform: translate(0, 0) rotate(0deg); }
            33%  { transform: translate(20px, -30px) rotate(15deg); }
            66%  { transform: translate(-15px, 15px) rotate(-10deg); }
            100% { transform: translate(0, 0) rotate(0deg); }
        }
        .floating-icon {
            position: absolute;
            opacity: 0.04;
            pointer-events: none;
            animation: float 25s infinite ease-in-out;
            z-index: 0;
            user-select: none;
        }
        .float-1 { top: 15%; left: 10%; font-size: 80px; animation-delay: 0s; }
        .float-2 { top: 60%; right: 10%; font-size: 96px; animation-delay: -8s; }
        .float-3 { bottom: 18%; left: 12%; font-size: 68px; animation-delay: -16s; }

        .btn-liquid {
            position: relative;
            overflow: hidden;
            z-index: 1;
        }
        .btn-liquid::before {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 0;
            width: 100%;
            height: 0%;
            background-color: #6a0170;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 50% 50% 0 0;
            z-index: -1;
        }
        .btn-liquid:hover::before {
            height: 160%;
            border-radius: 0;
        }

        @keyframes breath {
            0%, 100% { transform: scale(1); }
            50%       { transform: scale(1.012); }
        }
        .animate-breath { animation: breath 8s infinite ease-in-out; }

        @keyframes slideIn {
            from { transform: translateX(-24px); opacity: 0; }
            to   { transform: translateX(0);     opacity: 1; }
        }
        .animate-slide-in { animation: slideIn 0.7s ease-out forwards; }

        @keyframes fadeInUp {
            from { transform: translateY(20px); opacity: 0; }
            to   { transform: translateY(0); opacity: 1; }
        }
        .animate-fade-in-up { animation: fadeInUp 0.8s ease-out forwards; }

        @keyframes slowZoom {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        .animate-slow-zoom { animation: slowZoom 20s infinite ease-in-out; }

        input:focus {
            border-color: #9d2a9d !important;
            box-shadow: 0 0 0 3px rgba(157, 42, 157, 0.15) !important;
        }
    </style>
</head>
<body class="min-h-screen overflow-hidden font-sans" style="background:#f8f9fa;color:#191c1d;">
    @yield('content')
</body>
</html>
