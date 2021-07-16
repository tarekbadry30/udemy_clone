@extends('layouts.app')

@section('content')
<div class="container dashboard">
    <h2 >
        {{translate('dashboard')}}
        <br>
    </h2>
    <div class="row dashboard_container">
        <div class="col-md-4 col-sm-6 col-12 ">
            <div class="card_item">
                <a href="{{route('category.all')}}">
                    <h5 class="text-center">{{translate('categories')}}</h5>
                    <h6>{{$categoryCount}}</h6>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 ">
            <div class="card_item">
                <a href="{{route('courses.all')}}">
                    <h5 class="text-center">{{translate('courses')}}</h5>
                    <h6>{{$coursesCount}}</h6>
                </a>
            </div>
        </div>
        <div class="col-md-4 col-sm-6 col-12 ">
            <div class="card_item">
                <a href="{{route('tags.list')}}">
                    <h5 class="text-center">{{translate('tags')}}</h5>
                    <h6>{{$tagsCount}}</h6>
                </a>
            </div>
        </div>

    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            $(".search-input").hide();

        });

    </script>
@endsection
