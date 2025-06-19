@extends('admin.layouts.app')

@section('title','Update Category')

@section('content')
   <div class="card">
       <div class="card-title">
           <h4>{{$category->category}}</h4>
       </div>
       <div class="card-body w-25 mx-auto">
           <form action="{{ route('admin.categories.update', $category->id)}}" method="POST" class="">
               @csrf
               @method('PATCH')
               <div class="row g-3 align-items-center">
                   <div class="com-md-3">
                       <label for="category" class="col-form-label">Category Name</label>
                   </div>
                   <div class="com-md-3">
                       <input type="text" id="category" name="category" class="form-control" value="{{$category->category}}" aria-describedby="categoryHelpInline">
                   </div>
                   <div class="com-md-3">
                   </div>
               </div>
               <div class="row g-3 align-items-center mt-1">
                   <div class="com-md-3">
                       <label for="description" class="col-form-label">Description</label>
                   </div>
                   <div class="com-md-3">
                       <textarea id="description" name="description"  maxlength="255" class="form-control">{{$category->description}}</textarea>
                   </div>
                   <div class="com-md-3">
                   </div>
               </div>
               <div class="row g-3 align-items-center mt-1">
                   @php
                       // currently selected value (fallback to a sensible default)
                       $current = old('icon', $category->icon ?? 'fa-solid fa-user');
                   @endphp

                   <div class="mb-3">


                       <input type="hidden" id="icon" name="icon" value="{{ $current }}">
                       <label for="iconDropdown" class="col-form-label">icon</label>

                       <button class="btn btn-outline-secondary dropdown-toggle"
                               type="button"
                               id="iconDropdown"
                               data-bs-toggle="dropdown"
                               aria-expanded="false">
                           <i id="iconPreview" class="{{ $current }}"></i>
                       </button>


                       <ul class="dropdown-menu p-2" aria-labelledby="iconDropdown"
                           style="width: 280px; max-height: 240px; overflow-y: auto;">
                           <li class="mb-2 px-2">

                               <input type="text" class="form-control form-control-sm" placeholder="Search…"
                                      id="iconFilter">
                           </li>

                           <div class="row row-cols-4 g-2 px-2" id="iconGrid">
                               @foreach ($icons as $label => $class)
                                   <div class="col">
                                       <a href="#"
                                          class="icon-option btn btn-light w-100 py-2"
                                          data-value="{{ $class }}"
                                          data-search="{{ $label }}">
                                           <i class="{{ $class }} fa-fw fs-5"></i>
                                       </a>
                                   </div>
                               @endforeach
                           </div>
                       </ul>
                   </div>

               </div>
               <div class="row g-3 align-items-center mt-1">
                   <div class="com-md-3">
                       <label for="color" class="col-form-label"> Background Color</label>
                   </div>
                   <div class="com-md-3">
                       <input  id="color"
                               name="color"
                               type="color"
                               class="form-control form-control-color"
                               value="{{ old('color', $category->color ?? '#000000') }}"
                               title="Pick a colour">
                   </div>
                   <div class="com-md-3">
                   </div>
               </div>
               @if ($errors->any())
                   <div class="alert alert-danger">
                       <h5 class="mb-2">Whoops! Something went wrong…</h5>

                       <ul class="mb-0">
                           @foreach ($errors->all() as $error)
                               <li>{{ $error }}</li>
                           @endforeach
                       </ul>
                   </div>
           @endif
       </div>
       <div class="card-footer">
            <div class="d-flex justify-content-center align-items-center">
                <button type="submit" class="btn btn-primary"><i class="fa-solid fa-pencil me-2"></i> Save</button>
            </div>
       </div>
   </div>
</form>
   @push('scripts')
       <script>
           document.addEventListener('DOMContentLoaded', () => {

               // update hidden input + preview when the user picks an icon
               document.querySelectorAll('.icon-option').forEach(el => {
                   el.addEventListener('click', e => {
                       e.preventDefault();

                       const value   = el.dataset.value;
                       document.getElementById('icon').value           = value;   // <input type="hidden">
                       document.getElementById('iconPreview').className = value;  // live icon on button

                       bootstrap.Dropdown.getInstance(
                           document.getElementById('iconDropdown')
                       ).hide();
                   });
               });

               // simple client-side filter
               const filter = document.getElementById('iconFilter');
               if (filter) {
                   filter.addEventListener('input', () => {
                       const q = filter.value.toLowerCase();
                       document.querySelectorAll('#iconGrid .icon-option').forEach(opt => {
                           const hit = opt.dataset.value.toLowerCase().includes(q);
                           opt.parentElement.classList.toggle('d-none', !hit);
                       });
                   });
               }
           });
       </script>
   @endpush

@endsection
