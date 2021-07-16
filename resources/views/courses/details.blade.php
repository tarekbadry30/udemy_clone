@extends('layouts.app')

@section('content')
<div class="container course_details_page">
    <div class="row course_details">
        <div class="image_container col-md-4">
            <img src="{{asset($course->image)}}" class="img-fluid course_img">
        </div>
        <div class=" details_container col-md-7">
            <h1>
                {{$course->name}}
            </h1>
            <p>{{$course->description}}</p>
            <div class="rating d-flex ">
                <span class="rating-stars col-4"></span>
                <div class="text-left col-3"><i class="fa fa-eye"></i> {{$course->views}}</div>
            </div>
            <h5  class="hours"><i class="far fa-clock"></i> {{$course->hours}} {{translate('hours')}}</h5>
            @if($course->tags->count()>0)
            <hr>
            <div class="tags-container">

                <h4 class="font-weight-bold" >{{translate('tags')}}</h4>
                @foreach($course->tags as $tag)
                    <a href="{{route('courses.list',['tag_name'=>$tag->name])}}" class="px-1"># {{$tag->name}}</a>
                @endforeach
            </div>
            @endif
            @auth()
            <hr>
            <div class="student-status">

            </div>
            @endauth
        </div>
        <div class="text-center position">
            <img src="{{asset('img/loading.gif')}}" class="loading-spinner img-fluid">
        </div>
    </div>
</div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            showLoadingSpinner();
            $(".search-input").hide();
            $(".rating-stars").html(getRate({{$course->rating}}));
            hideLoadingSpinner();
            checkStatus({{$course->getStudentStatus()}});
            $(document).on('click','.rate-icon',function () {
                let ratingValue = $(this).attr('value');
                giveRate(ratingValue);
            });
            $(document).on('click','.join-btn',function () {
                joinOrLeaveCourse();
            });
        });
        function getRate(rate) {
            let output=`${rate} `;
            for(i=1;i<6;i++){
                if(rate>=i){ //full or half star
                    output+=`<i value="${i}" class="@auth() rate-icon @endauth fas fa-star"></i>`;
                }else{
                    output+=`<i value="${i}" class="@auth() rate-icon @endauth far fa-star"></i>`;
                }
            }
            return output;
        }
        function giveRate(rate) {
            showLoadingSpinner();
            $.ajax({
                    url: "{{route('courses.giveRate')}}",
                    data:{
                        "_token":"{{csrf_token()}}",
                        'rate':rate,
                        'course_id':{{$course->id}}
                    },
                    type:'post',
                    success: function(data){
                        hideLoadingSpinner();
                        if(data.errorNum==200){
                            Swal.fire({
                                title: `${data.msg}`,
                                icon: "success",
                                showConfirmButton: true,
                                timer:1000,
                                confirmButtonText: '{{translate('ok')}}',
                            });
                        }
                        else if(data.errorNum==400){
                            let outputMessage='';
                            let errorMessage=data.msg;
                            for(i=0;i<data.errors.length;i++)
                                outputMessage+=`${data.errors[i]} \n  `;
                            Swal.fire({
                                title: `${errorMessage}`,
                                icon: "error",
                                text: `${outputMessage}`,
                                showConfirmButton: true,
                                confirmButtonText: '{{translate('ok')}}',
                            });
                        }
                        else{
                            Swal.fire({
                                title: `${data.msg}`,
                                icon: "error",
                                //timer: 1300,
                                showConfirmButton: true,
                                confirmButtonText: '{{translate('ok')}}',
                            });
                        }
                        $(".rating-stars").html(getRate(data.newRate));
                    }
                });

        }
        function joinOrLeaveCourse() {
            showLoadingSpinner();
            $.ajax({
                    url: "{{route('courses.join')}}",
                    data:{
                        "_token":"{{csrf_token()}}",
                        'course_id':{{$course->id}}
                    },
                    type:'post',
                    success: function(data){
                        hideLoadingSpinner();
                        if(data.errorNum==200){
                            Swal.fire({
                                title: `${data.msg}`,
                                icon: "success",
                                showConfirmButton: true,
                                confirmButtonText: '{{translate('ok')}}',
                            });
                            checkStatus(data.newStatus);
                        }
                        else if(data.errorNum==400){
                            let outputMessage='';
                            let errorMessage=data.msg;
                            for(i=0;i<data.errors.length;i++)
                                outputMessage+=`${data.errors[i]} \n  `;
                            Swal.fire({
                                title: `${errorMessage}`,
                                icon: "error",
                                text: `${outputMessage}`,
                                showConfirmButton: true,
                                confirmButtonText: '{{translate('ok')}}',
                            });
                        }
                        else{
                            Swal.fire({
                                title: `${data.msg}`,
                                icon: "error",
                                //timer: 1300,
                                showConfirmButton: true,
                                confirmButtonText: '{{translate('ok')}}',
                            });
                        }
                    }
                });
        }

        function checkStatus(status) {
            if(status)
            $(".student-status").html(`
                <p>{{translate('youAreJoined')}}
                </p>
                    <button class="btn join-btn btn-outline-danger"> <i class="text-dark fas fa-window-close"></i> {{translate('leave')}}</button>

            `);
        else
            $(".student-status").html(`
                <p>{{translate('youAreNotJoined')}}
                </p>
                   <button class="btn join-btn btn-outline-success"> <i class="text-dark fas fa-user-graduate"></i> {{translate('join')}}</button>
            `);
        }
        function showLoadingSpinner() {
            $(".loading-spinner").show()
        }
        function hideLoadingSpinner() {
            $(".loading-spinner").hide()
        }

    </script>
@endsection
