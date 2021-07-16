@extends('layouts.app')

@section('content')
    <div class="container-fluid all_courses">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-7">
                            <h1 class="page-title reload-btn">
                                {{ translate('coursesList') }}
                            </h1>
                        </div>
                        <div class="col-2">
                            <button
                                class="new-category btn btn-outline-success"
                                data-toggle="modal" data-target="#new-item-modal">
                                {{translate('newCourse')}}
                            </button>
                        </div>
                        <div class="col-3">
                            <div class="row">
                                <label class="col-4">{{translate('page')}}</label>
                                <select  class="col-8 form-control paginate-input" ></select>
                                <hr class="col-12">
                                <label class="col-4">{{translate('activeStatus')}}</label>
                                <select  class="col-8 form-control active_status" >
                                    <option value="1">{{translate('active')}}</option>
                                    <option value="0">{{translate('disabled')}}</option>
                                </select>
                                <hr class="col-12">
                                <label class="col-4">{{translate('deleteStatus')}}</label>
                                <select  class="col-8 form-control delete_status" >
                                    <option value="">{{translate('notDeleted')}}</option>
                                    <option value="deleted">{{translate('softDeleted')}}</option>
                                </select>
                            </div>
                        </div>

                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <div class="table-container">
                            <table class="table table-bordered table-hover">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{translate('image')}}</th>
                                    <th>{{translate('name')}}</th>
                                    <th>{{translate('description')}}</th>
                                    <th>{{translate('level')}}</th>
                                    <th>{{translate('rates')}}</th>
                                    <th>{{translate('hours')}}</th>
                                    <th>{{translate('control')}}</th>
                                </tr>
                                </thead>
                                <tbody class="t-body">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal"  id="new-item-modal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" >
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">{{translate('newCourse')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="insert-form ajax-form" action="{{route('courses.insert')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group ">
                            <label for="new-category-title">{{translate('name')}}</label>
                            <input required type="text" class="form-control" id="new-category-title" name="name">
                        </div>
                        <div class="form-group ">
                            <label for="new-category-description">{{translate('description')}}</label>
                            <textarea required type="text" rows="5" class="form-control" id="new-course-description" name="description"></textarea>
                        </div>

                        <div class="form-group ">
                            <label for="new-course-hours">{{translate('hours')}}</label>
                            <input required type="number" min="0" class="form-control" id="new-course-hours" name="hours">
                        </div>

                        <div class="form-group ">
                            <label for="new-course-category">{{translate('category')}}</label>
                            <select required class="form-control" id="new-course-category" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="new-course-category">{{translate('level')}}</label>
                            <select required class="form-control" id="new-course-category" name="level">
                                    <option value="beginner">beginner</option>
                                    <option value="immediate">immediate</option>
                                    <option value="high">high</option>
                            </select>
                        </div>

                        <div class="form-group ">
                            <img src="" class="d-block img-fluid selected-image">
                            <label for="new-course-hours">{{translate('image')}}</label>
                            <input required type="file" class="form-control selected-image-input" id="new-course-image" name="image">
                        </div>

                        <div class="form-group ">
                            <label for="new-course-hours">{{translate('tags')}}</label>

                            <input type="text" class="form-control tags-search" id="tags-search" >
                            <div class="position-relative">
                                <div class="dropdown-menu tags-dropdown" aria-labelledby="tags-dropdown">
                                </div>
                            </div>
                            <div class="tags-container mt-2">

                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('cancel')}}</button>
                        <button type="submit" class="btn btn-success">{{translate('insert')}}</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <div class="modal"  id="edit-item-modal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" >
                <!-- Modal Header -->
                <div class="modal-header" dir="{{app()->getLocale()=='ar'?'rtl':'ltr'}}">
                    <h5 class="modal-title">{{translate('editCategory')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="update-form ajax-form" action="{{route('courses.update')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <input required type="hidden" class="form-control item-id" id="course-id" name="course_id">

                        <div class="form-group ">
                            <label for="course-name">{{translate('name')}}</label>
                            <input required type="text" class="form-control" id="course-name" name="name">
                        </div>
                        <div class="form-group ">
                            <label for="course-description">{{translate('description')}}</label>
                            <textarea required rows="5" type="text" class="form-control" id="course-description" name="description"></textarea>
                        </div>

                        <div class="form-group ">
                            <label for="course-hours">{{translate('hours')}}</label>
                            <input required type="number" min="0" class="form-control" id="course-hours" name="hours">
                        </div>

                        <div class="form-group ">
                            <label for="course-category">{{translate('category')}}</label>
                            <select required class="form-control" id="course-category" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">
                            <label for="course-level">{{translate('level')}}</label>
                            <select required class="form-control" id="course-level" name="level">
                                <option value="beginner">beginner</option>
                                <option value="immediate">immediate</option>
                                <option value="high">high</option>
                            </select>
                        </div>

                        <div class="form-group ">
                            <img src="" class="d-block img-fluid selected-image">
                            <label for="course-image">{{translate('image')}}</label>
                            <input type="file" class="selected-image-input form-control" id="course-image" name="image">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('cancel')}}</button>
                        <button type="submit" class="btn btn-success">{{translate('update')}}</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <div class="modal"  id="delete-item-modal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" >
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">{{translate('deleteConfirm')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="update-form ajax-form" action="{{route('courses.delete')}}" method="post">
                    <div class="modal-body">
                        @csrf

                        <div class="row">
                            <h5 class="text-danger col-12">
                                {{translate('deleteConfirmMsg')}}
                            </h5>
                            <label class="col-4 text-right">{{translate('deleteStatus')}} : </label>
                            <div class="col-8">
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="softDelete" value="soft" checked name="deleteStatus" class="custom-control-input">
                                    <label class="custom-control-label" for="softDelete">{{translate('softDeleted')}}</label>
                                </div>
                                <div class="custom-control custom-radio custom-control-inline">
                                    <input type="radio" id="fullDelete" value="full" name="deleteStatus" class="custom-control-input">
                                    <label class="custom-control-label" for="fullDelete">{{translate('fullDeleted')}}</label>
                                </div>
                            </div>
                        </div>
                        <input required type="hidden" class="form-control item-id" id="item-id" name="course_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('cancel')}}</button>
                        <button type="submit" class="btn btn-success">{{translate('confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="modal"  id="restore-item-modal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" >
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title">{{translate('restoreConfirm')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="update-form ajax-form" action="{{route('courses.restore')}}" method="post">
                    <div class="modal-body">
                        @csrf

                        <div class="row">
                            <h5 class="text-success col-12">
                                {{translate('restoreConfirmMsg')}}
                            </h5>
                        </div>
                        <input required type="hidden" class="form-control item-id" id="item-id" name="course_id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{translate('cancel')}}</button>
                        <button type="submit" class="btn btn-success">{{translate('confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="text-center position">
        <img src="{{asset('img/loading.gif')}}" class="loading-spinner img-fluid">
    </div>
@endsection
@section('js')
    <script>
        let page = 1;
        let index = 0;
        let lastPage=1;
        let canReload=true;



        $(document).ready(function () {
            getCourses(page);
            $(document).on('change', '.selected-image-input', function () {
                let image = $(this).closest('form').find('.selected-image');
                let url = window.URL.createObjectURL(this.files[0]);
                image.attr('src', url);
            });
            $(document).on('keyup', '.tags-search', function () {
                searchTags($(this).val());
            });

            $(document).on('change', '.paginate-input', function () {
                getCourses($(this).val());
            });
            $(document).on('change', '.active_status', function () {
                $(".paginate-input").val(1).trigger('change');
            });
            $(document).on('change', '.delete_status', function () {
                $(".paginate-input").val(1).trigger('change');
            });
            $(document).on('click', '.edit-item', function () {
                getCourseDetails($(this).attr("item_id"));
            });
            $(document).on('click', '.delete-item', function () {
                $('#delete-item-modal .item-id').val($(this).attr("item_id"));
            });
            $(document).on('click', '.restore-item', function () {
                $('#restore-item-modal .item-id').val($(this).attr("item_id"));
            });
            $(document).on('click', '.hide-active-item', function () {
                changeVisible($(this).attr("item_id"));
            });
            $(document).on('click', '.reload-btn', function () {
                $(".paginate-input").trigger("change");
            });
            $(document).on('click', '.remove-tag', function () {
                $(this).closest('.tag-input-container').remove();
            });
            /*$(".tags-search").focus(function () {
                if ($(this).val().trim().length > 0)
                    $('.tags-dropdown').dropdown('show');
            });*/
        });
        function getCourses(page) {
            let active_status=$(".active_status").val();
            let delete_status=$(".delete_status").val();
            showLoadingSpinner();
            if(lastPage>=page)
            $.ajax({
                url: "{{route('courses.listAjax')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    page:page,
                    active_status:active_status,
                    delete_status:delete_status,
                },
                type:'post',
                success: function(result){
                    let courses=result.list.data;
                    let output='';
                    lastPage=result.list.last_page;
                    $(".paginate-input").html('');
                    for(i=1;i<=lastPage;i++){
                        $(".paginate-input").append(`
                        <option value="${i}" ${page==i?'selected':''}>${i}</option>
                        `)
                    }
                    if(courses.length<1 && page==1) {
                        hideLoadingSpinner();

                        $('.t-body').html(`
                        <tr>
                            <td colspan="7">{{translate('noData')}}</td>
                        </tr>
                    `);
                    }
                    else {
                        $('.t-body').html(``);
                        courses.forEach(function (course,index) {
                            $('.t-body').append(`
                                <tr>
                                    <td>${index+1}</td>
                                    <td><img src="{{asset('/')}}${course.image}" class="course_img img-fluid"></td>
                                    <td><a href="{{route('courses.details')}}?course_id=${course.id}"> ${course.name}</a></td>
                                    <td>${course.description}</td>
                                    <td>${course.level}</td>
                                    <td>${course.rating}</td>
                                    <td>${course.hours}</td>
                                    <td>
                                    <button
                                        class="d-block btn btn-outline-primary edit-item"
                                        data-toggle="modal" data-target="#edit-item-modal"
                                        item_id="${course.id}">
                                            {{translate('edit')}}
                                    </button>

                                    <button
                                        class="d-block btn btn-outline-success hide-active-item"
                                        item_id="${course.id}">
                                            ${course.active?"{{translate('hide')}}":"{{translate('view')}}"}
                                    </button>

                                    <button
                                        class="d-block btn btn-outline-danger delete-item"
                                        data-toggle="modal" data-target="#delete-item-modal"
                                        index="${index}" item_id="${course.id}">
                                            {{translate('delete')}}
                                    </button>
                                    <button
                                        class="${course.deleted_at?'d-block':'d-none'} btn btn-outline-success restore-item"
                                        data-toggle="modal" data-target="#restore-item-modal"
                                        index="${index}" item_id="${course.id}">
                                            {{translate('restore')}}
                                    </button>
                                </td>
                            </tr>
                            `);
                        });
                        hideLoadingSpinner();
                    }
                }
            });
        }
        function getCourseDetails(course_id) {
            showLoadingSpinner();

            $.ajax({
                url: "{{route('courses.details')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    course_id:course_id,
                },
                type:'post',
                success: function(result){
                    let course=result.course;
                    $('#edit-item-modal #course-id').val(course.id);
                    $('#edit-item-modal #course-category').val(course.category_id);
                    $('#edit-item-modal #course-name').val(course.name);
                    $('#edit-item-modal #course-description').text(course.description);
                    $('#edit-item-modal #course-hours').val(course.hours);
                    $('#edit-item-modal .selected-image').attr('src',"{{asset('/')}}"+course.image);
                    $('#edit-item-modal #course-level').val(course.level);
                    hideLoadingSpinner();
                }
            });
        }
        function changeVisible(course_id) {
            showLoadingSpinner();
            $.ajax({
                url: "{{route('courses.changeVisible')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    course_id:course_id,
                },
                type:'post',
                success: function(result){
                    $(".reload-btn").click();
                }
            });
        }
        function searchTags(text) {
            if(text.trim().length>0)
                $.ajax({
                    url: "{{route('tags.search')}}",
                    data:{
                        "_token":"{{csrf_token()}}",
                        text:text,
                    },
                    type:'post',
                    success: function(result){
                        let tags=result.list;
                        $('.tags-dropdown').html('');
                        tags.forEach(function (tag) {
                            $('.tags-dropdown').append(`
                                <div class="dropdown-item tag-item"  onclick="selectTag($(this).attr('value'),$(this).text())" value="${tag.id}">${tag.name}</div>
                            `);
                        });
                        $('.tags-dropdown').dropdown('show');

                    }
                });
            else
                $('.tags-dropdown').dropdown('hide');

        }
        function selectTag(tag_id,tag_title) {
            let selected=$(`.tags-container #selected_tag_${tag_id}`).length;
            if(selected<1){
                $(".tags-container").append(`
                <div class="tag-input-container row justify-content-around">
                    <input type="hidden" name="tags[]" id="selected_tag_${tag_id}" value="${tag_id}" >
                    <span class="col-10">${tag_title} </span> <button class="col-1 remove-tag btn btn-outline-danger" type="button"> <i class="fa fa-window-close"></i> </button>
                    <hr class="col-12">
                </div>
                `);
            }
            //$('.tags-dropdown').removeClass('show').closest('div').removeClass('show');


        }
        function showLoadingSpinner() {
            $(".loading-spinner").show()
        }
        function hideLoadingSpinner() {
            $(".loading-spinner").hide()
        }
        $(".search-input").hide();

    </script>
@endsection
