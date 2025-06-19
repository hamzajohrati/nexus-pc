<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>@yield('title','Admin')</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
  <style>
    body{min-height:100vh;display:flex;}
    aside{width:240px;background:#343a40;}
    aside a{color:#adb5bd;text-decoration:none;display:block;padding:.75rem 1rem;}
    aside a.active,aside a:hover{background:#495057;color:#fff;}
    main{flex:1;}
  </style>
</head>
<body>
<aside class="d-flex flex-column flex-shrink-0 p-0 text-white">
  <a href="{{ route('admin.dashboard.index') }}" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none px-3 py-2">
    <span class="fs-4"><i class="fa fa-cogs me-2"></i>Admin</span>
  </a>
  @php
    $links = [
      'dashboard'  => ['icon'=>'tachometer-alt','label'=>'Dashboard'],
      'categories' => ['icon'=>'tags','label'=>'Categories'],
      'components' => ['icon'=>'microchip','label'=>'Components'],
      'pcs'        => ['icon'=>'desktop','label'=>'PCs'],
      'requests'   => ['icon'=>'shopping-cart','label'=>'Requests'],
      'users'      => ['icon'=>'users','label'=>'Users'],
      'config'     => ['icon'=>'gear','label'=>'Site Config'],
    ];
  @endphp
  @foreach($links as $k=>$l)
    <a href="{{ route('admin.'.$k.'.index') }}"
       class="@if(request()->routeIs('admin.'.$k.'.*')) active @endif">
       <i class="fa fa-{{ $l['icon'] }} me-2"></i>{{ $l['label'] }}
    </a>
  @endforeach
  <a href="{{ url('/') }}" class="mt-auto border-top border-secondary text-center py-2">
    <i class="fa fa-home me-2"></i>Back to store
  </a>
</aside>

<main class="p-4">
  <h1 class="h4 mb-4">@yield('title','Admin Area')</h1>
  @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
