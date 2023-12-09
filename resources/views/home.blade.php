@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    @if (\Session::has('uploadMessage'))
                        <div class="alert alert-success alert-dismissible fade show d-flex justify-content-between align-items-center" role="alert">
                            <p class="mb-0">{{ \Session::get('uploadMessage') }}</p>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                </div>
                <a href="{{ route('uploadFile') }}" class="btn btn-primary">Go to Upload File Page</a>
            </div>
        </div>
    </div>
</div>
@endsection
