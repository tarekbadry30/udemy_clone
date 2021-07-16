@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('frontend.welcomeBack') }}</div>

                <div class="card-body">
                    <h4 class="text-center">{{$message}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
