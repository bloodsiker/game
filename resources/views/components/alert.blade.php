@if (session('error'))
    <div class="alert alert-danger" role="alert">
        <span>{{ session('error') }}</span>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success" role="alert">
        <span>{{ session('success') }}</span>
    </div>
@endif
