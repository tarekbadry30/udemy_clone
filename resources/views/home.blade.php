@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center courses_container">
    </div>
</div>
@endsection
@section('js')
    <script>
        let page=1;
        let lastPage=1;
        let canReload=true;
        $(document).ready(function () {

            getCourses(page);
            $(window).scroll(function() {
                var windowsHeight = $(document).height() - $(window).height();
                var currentScroll = $(document).scrollTop();

                //if I scroll more than 80%
                if( ((currentScroll *100) / windowsHeight) > 80){
                    page++;
                    if(canReload)
                        getCourses(page);
                }
            });
        });
        function getCourses(page) {
            canReload=false;
            $.ajax({
                url: "{{route('courses.listAjax')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    'page':page
                },
                type:'post',
                success: function(result){
                    console.log(result);
                    let courses=result.list.data;
                    lastPage=result.list.last_page;
                    if(courses.length<1&&page==1)
                        $('.courses_container').html(`
                            <h3 class="text-center">{{translate('noData')}}</h3>
                        `);
                    else
                        courses.forEach(function (course) {
                            $('.courses_container').append(`
                                <div class="col-md-3 col-sm-4 col-12 p-1">
                                    <div class="course_item">
                                        <div class="image_container">
                                            <img src="${course.image}" class="img-fluid course_img">
                                        </div>
                                        <div class="details_container">
                                            <a href="#!">
                                                <h3 class="course_name">${course.name}</h3>
                                            </a>
                                            <p class="course_details">${course.description}</p>
                                            <div class="rating">
                                                ${course.rating}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    canReload=true;
                }
            });
        }

    </script>
@endsection
