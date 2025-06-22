
<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color:var(--nexus-red);">
  <div class="container">
    <a class="navbar-brand text-white fw-bold" href="{{ url('/') }}">
        Nexus Pc <img src="{{ asset("assets/img/icon _pc_desktop.svg")}}" style="width: 37.45px; height: 33.86px" alt="" srcset="">
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" style="margin-left: 25%" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link text-white" href="{{ url('/') }}">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('prebuilt') }}">Pre-built PCs</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('components') }}">Components</a></li>
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('builder') }}">PC Builder</a></li>
      </ul>
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link text-white position-relative" href="{{ route('cart') }}">
            <i class="fas fa-shopping-cart"></i>
            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-light text-nexus-red" id="cartCount">{{$cartCount}}</span>
          </a>
        </li>
        @guest
        <li class="nav-item"><a class="nav-link text-white" href="{{ route('login') }}"><i class="fa-solid fa-user"></i></a></li>
        @else
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown" data-bs-toggle="dropdown">{{ Auth::user()->email }}</a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="{{route('orders.index')}}">My Orders</a></li>
            <li><a class="dropdown-item" href="#" onclick="event.preventDefault();document.getElementById('logoutForm').submit();">Logout</a></li>
          </ul>
          <form id="logoutForm" method="POST" action="{{ route('logout') }}">@csrf</form>
        </li>
            @if(Auth::user()->role === 'admin')
                  <li class="nav-item"><a class="nav-link text-white" href="{{ route('admin.dashboard.index') }}"><i class="fa-solid fa-gauge"></i> Admin Console</a></li>
            @endif
        @endguest
      </ul>
    </div>
  </div>
</nav>
