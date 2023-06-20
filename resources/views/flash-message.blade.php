@if ($message = Session::get('success'))
    <div class="alert alert-success fade show" role="alert">
        <strong>{{ $message }}</strong>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
    </div>
@endif

@if ($message = Session::get('error'))
    <div class="alert alert-danger fade show" role="alert">
        <strong>{{ $message }}</strong>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
    </div>
@endif

@if ($message = Session::get('warning'))
    <div class="alert alert-warning fade show" role="alert">
        <strong>{{ $message }}</strong>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
    </div>
@endif

@if ($message = Session::get('info'))
    <div class="alert alert-info fade show" role="alert">
        <strong>{{ $message }}</strong>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger fade show" role="alert">
        <strong>Please check the form below for errors</strong>
        {{-- <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button> --}}
    </div>
@endif
