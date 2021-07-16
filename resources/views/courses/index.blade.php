@extends('layouts.app')

@section('content')
<div class="container">
    <div class="categories_container">
        <h2 >
            top categories
        </h2>
        <div class="owl-carousel ">
        </div>
    </div>

    <hr>
    <h2 class="courses_title_container">
        {{translate('topCourses')}}
    </h2>
    <div class="row courses_container">
    </div>
    <div class="text-center position">
        <img src="{{asset('img/loading.gif')}}" class="loading-spinner img-fluid">
    </div>
</div>
@endsection
@section('js')
    <script>
        let page=1;
        let lastPage=1;
        let canReload=true;
        $(document).ready(function () {
            getPopularCategories();
            getCourses(page);
            $(window).scroll(function() {
                var windowsHeight = $(document).height() - $(window).height();
                var currentScroll = $(document).scrollTop();

                //if I scroll more than 80%
                if( ((currentScroll *100) / windowsHeight) > 80){
                    if(canReload&& $('.search-input').val().trim().length<1){
                        page++;
                        getCourses(page);
                    }
                }
            });
            $(document).on('keyup','.search-input',function () {
                $('.courses_container').html(``);
                if($(this).val().trim().length>0)
                    searchCourses($(this).val());
                else{
                    page=1;
                    getCourses(page);
                }
            })
        });
        function getCourses(page) {
            $('.courses_title_container').text('{{translate('topCourses')}}');

            showLoadingSpinner();
            if(lastPage>=page)
                $.ajax({
                    url: "{{route('courses.listAjax')}}",
                    data:{
                        "_token":"{{csrf_token()}}",
                        'page':page
                    },
                    type:'post',
                    success: function(result){
                        let courses=result.list.data;
                        lastPage=result.list.last_page;
                        if(courses.length<1&&page==1)
                            $('.courses_container').html(`
                                <h3 class="text-center">{{translate('noData')}}</h3>
                            `);
                        else
                            courses.forEach(function (course) {
                                $('.courses_container').append(`
                                    <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                                        <div class="course_item">
                                            <div class="image_container">
                                                <img src="/${course.image}" class="img-fluid course_img">
                                            </div>
                                            <div class="details_container">
                                                <a href="{{route('courses.details')}}?course_id=${course.id}">
                                                    <h3 class="course_name">${course.name}</h3>
                                                </a>
                                                <p class="course_details">${course.description}</p>

                                                <div class="rating d-flex justify-content-around">
                                                    <div class="">${course.rating+ ' ' +getRate(course.rating)}</div>
                                                    <div class=""><i class="fa fa-eye"></i> ${ course.views}</div>
                                                </div>
                                                <h5  class="hours"><i class="far fa-clock"></i> ${course.hours} {{translate('hours')}}</h5>
                                            </div>
                                        </div>
                                    </div>
                                `);
                            });
                        hideLoadingSpinner();
                    }
                });
            else
                hideLoadingSpinner();

        }
        function getRate(rate) {
            let output='';
            for(i=1;i<6;i++){
                if(rate>=i){ //full or half star
                    output+=`<i class="fas fa-star"></i>`;
                }else{
                    output+=`<i class="far fa-star"></i>`;
                }
            }
            return output;
        }
        function getPopularCategories() {
            showLoadingSpinner();
                $.ajax({
                    url: "{{route('category.popular')}}",
                    data:{
                        "_token":"{{csrf_token()}}",
                    },
                    type:'post',
                    success: function(result){
                        let categories=result.list;
                        if(categories.length<1)
                            $('.categories_container').hide();
                        else
                            categories.forEach(function (category) {
                                $('.categories_container .owl-carousel').append(`
                                    <div class="category_item">
                                        <div class="image_container">
                                            <img src="/${category.image}" class="img-fluid category_image">
                                        </div>
                                        <div class="details_container">
                                            <a href="{{route('courses.list')}}?category_id=${category.id}">
                                                <h3 class="category_name">${category.name}</h3>
                                            </a>
                                            <p class="category_details">{{translate('courses')}} : ${category.courses_count}</p>
                                        </div>
                                    </div>
                                `);
                            });
                        $('.owl-carousel').owlCarousel({
                            loop:true,
                            margin:10,
                            responsiveClass:true,
                            responsive:{
                                0:{
                                    items:1,
                                    nav:true
                                },
                                600:{
                                    items:3,
                                    nav:true
                                },
                                1000:{
                                    items:4,
                                    nav:true,
                                }
                            }
                        });
                        hideLoadingSpinner();
                    }
                });


        }
        function searchCourses(text) {
            $('.courses_title_container').text('{{translate('searchResult')}}');
            showLoadingSpinner();
            $.ajax({
                url: "{{route('courses.search')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    'text':text
                },
                type:'post',
                success: function(result){
                    let courses=result.list;
                    $('.courses_container').html(``);

                    if(courses.length<1)
                        $('.courses_container').html(`
                            <h3 class="text-center">{{translate('noData')}}</h3>
                        `);
                    else
                        courses.forEach(function (course) {
                            $('.courses_container').append(`
                                <div class="col-lg-3 col-md-4 col-sm-6 col-12 p-1">
                                    <div class="course_item">
                                        <div class="image_container">
                                            <img src="/${course.image}" class="img-fluid course_img">
                                        </div>
                                        <div class="details_container">
                                            <a href="{{route('courses.details')}}?course_id=${course.id}">
                                                <h3 class="course_name">${course.name}</h3>
                                            </a>
                                            <p class="course_details">${course.description}</p>

                                                <div class="rating d-flex justify-content-around">
                                                    <div class="">${course.rating+ ' ' +getRate(course.rating)}</div>
                                                    <div class=""><i class="fa fa-eye"></i> ${ course.views}</div>
                                                </div>
                                            <h5  class="hours"><i class="far fa-clock"></i> ${course.hours} {{translate('hours')}}</h5>
                                        </div>
                                    </div>
                                </div>
                            `);
                        });
                    hideLoadingSpinner();
                }
            });
        }
        function showLoadingSpinner() {
            canReload=false;
            $(".loading-spinner").show()
        }
        function hideLoadingSpinner() {
            canReload=true;
            $(".loading-spinner").hide()
        }

    </script>
@endsection
