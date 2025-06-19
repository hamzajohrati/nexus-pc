<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nexus PC - @yield('title', 'Home')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap 5 via CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome 6 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap');

        body{
            font-family: "Inter", sans-serif;
            font-optical-sizing: auto;
            font-weight : normal;
            font-style: normal;
        }
        :root{
            --nexus-red:#FF0004;
            --nexus-dark:#3A0000;
        }
        .bg-nexus-dark{background-color:var(--nexus-dark)!important;}
        .text-nexus-red{color:var(--nexus-red)!important;}
        .btn-nexus-red{background-color:var(--nexus-red);color:#fff;}
        .btn-nexus-red:hover{opacity:.9;color:#fff;}
        .hero{background:url('{{asset("assets/img/hero_bg.jpg")}}') center/cover no-repeat;height:380px;position:relative;}
        .hero-overlay{position:absolute;inset:0;background:rgba(0,0,0,.4);}
        /* From Uiverse.io by G4b413l */
        .group {
            position: relative;
        }

        .input {
            font-size: 16px;
            padding: 10px 10px 10px 5px;
            display: block;
            width: 100%;
            border: none;
            border-bottom: 1px solid #515151;
            background: transparent;
        }

        .input:focus {
            outline: none;
        }

        label {
            color: #999;
            font-size: 18px;
            font-weight: normal;
            position: absolute;
            pointer-events: none;
            left: 5px;
            top: 10px;
            transition: 0.2s ease all;
            -moz-transition: 0.2s ease all;
            -webkit-transition: 0.2s ease all;
        }

        .input:focus ~ label, .input:valid ~ label {
            top: -20px;
            font-size: 14px;
            color: #dc3545;
        }

        .bar {
            position: relative;
            display: block;
            width: 100%;
        }

        .bar:before, .bar:after {
            content: '';
            height: 2px;
            width: 0;
            bottom: 1px;
            position: absolute;
            background: #dc3545;
            transition: 0.2s ease all;
            -moz-transition: 0.2s ease all;
            -webkit-transition: 0.2s ease all;
        }

        .bar:before {
            left: 50%;
        }

        .bar:after {
            right: 50%;
        }

        .input:focus ~ .bar:before, .input:focus ~ .bar:after {
            width: 50%;
        }

        .highlight {
            position: absolute;
            height: 60%;
            width: 100px;
            top: 25%;
            left: 0;
            pointer-events: none;
            opacity: 0.5;
        }

        .input:focus ~ .highlight {
            animation: inputHighlighter 0.3s ease;
        }

        @keyframes inputHighlighter {
            from {
                background: #dc3545;
            }

            to {
                width: 0;
                background: transparent;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
@include('partials.navbar')

<main class="flex-shrink-0">
    @yield('content')
</main>

@include('partials.footer')

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets/js/cart.js') }}"></script>
@stack('scripts')
</body>
</html>
