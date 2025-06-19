
<footer class="bg-nexus-dark text-white mt-5 pt-5 pb-3">
  <div class="container">
    <div class="row gy-4">
      <div class="col-md-3">
        <h5> Nexus Pc <img src="{{ asset("assets/img/icon _pc_desktop.svg")}}" style="width: 37.45px; height: 33.86px" alt="" srcset=""></h5>
        <p>Your trusted destination for premium custom PCs and high‑quality components. Building dreams, one PC at a time.</p>
        <div class="d-flex gap-2">
          <a href="{{$config[0]->twitter}}" target="_blank"  class="text-white"><i class="fab fa-x-twitter"></i></a>
          <a href="{{$config[0]->instagram}}" target="_blank" class="text-white"><i class="fab fa-instagram"></i></a>
          <a href="{{$config[0]->facebook}}" target="_blank" class="text-white"><i class="fab fa-facebook"></i></a>
          <a href="{{$config[0]->youtube}}" target="_blank" class="text-white"><i class="fab fa-youtube"></i></a>
        </div>
      </div>
      <div class="col-md-3">
        <h6 class="fw-bold">Quick Links</h6>
        <ul class="list-unstyled">
          <li><a href="{{ route('prebuilt') }}" class="text-white text-decoration-none">Pre-built PCs</a></li>
          <li><a href="{{ route('components') }}" class="text-white text-decoration-none">Components</a></li>
          <li><a href="{{ route('builder') }}" class="text-white text-decoration-none">PC Builder</a></li>
          <li><a href="#" class="text-white text-decoration-none">Deals & Promotions</a></li>
          <li><a href="#" class="text-white text-decoration-none">Support</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h6 class="fw-bold">Help & Information</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="text-white text-decoration-none">FAQs</a></li>
          <li><a href="#" class="text-white text-decoration-none">Shipping Information</a></li>
          <li><a href="#" class="text-white text-decoration-none">Returns Policy</a></li>
          <li><a href="#" class="text-white text-decoration-none">Warranty</a></li>
          <li><a href="#" class="text-white text-decoration-none">Privacy Policy</a></li>
          <li><a href="#" class="text-white text-decoration-none">Terms of Service</a></li>
        </ul>
      </div>
      <div class="col-md-3">
        <h6 class="fw-bold">Contact Us</h6>
        <p class="mb-1"> {{$config[0]->adresse}}, {{$config[0]->city}}, {{$config[0]->country}}</p>
        <p class="mb-1">{{$config[0]->phone}}</p>
        <p class="mb-0">{{$config[0]->email}}</p>
      </div>
    </div>
    <hr class="border-secondary mt-4">
    <p class="mb-0 text-center">&copy; {{ date('Y') }} Nexus PC. All rights reserved.</p>
  </div>
</footer>
