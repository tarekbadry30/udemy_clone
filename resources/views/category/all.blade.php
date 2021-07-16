@extends('layouts.app')

@section('content')
    <div class="container-fluid all_categories">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-6">
                            <h1 class="page-title reload-btn">
                                {{ translate('categoriesList') }}
                            </h1>
                        </div>
                        <div class="col-3">
                            <button
                                class="new-category btn btn-outline-success"
                                data-toggle="modal" data-target="#new-category-modal">
                                {{translate('newCat')}}
                            </button>
                        </div>
                        <div class="col-2">
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
                                <label class="col-4 ">{{translate('deleteStatus')}}</label>
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
                                    <th>{{translate('courses')}}</th>
                                    <th>{{translate('control')}}</th>
                                </tr>
                                </thead>
                                <tbody class="t-body">
                                <tr>
                                    <td colspan="4">{{translate('noData')}}</td>
                                </tr>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal"  id="new-category-modal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" >

                <!-- Modal Header -->
                <div class="modal-header" dir="{{app()->getLocale()=='ar'?'rtl':'ltr'}}">
                    <h5 class="modal-title">{{translate('newCat')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="insert-form ajax-form" action="{{route('category.insert')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group ">
                            <label for="new-category-name">{{translate('name')}}</label>
                            <input required type="text" class="form-control" id="new-category-name" name="name">
                        </div>
                        <div class="form-group ">
                            <img src="" class="d-block img-fluid selected-image">
                            <label for="new-category-hours">{{translate('image')}}</label>
                            <input required type="file" class="form-control selected-image-input" id="new-category-image" name="image">
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

                <form class="update-form ajax-form" action="{{route('category.update')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group ">
                            <label for="new-category-title">{{translate('name')}}</label>
                            <input required type="text" class="form-control item_name" id="item_name" name="name">
                            <input required type="hidden" class="form-control item-id" id="item-id" name="category_id">
                        </div>
                        <div class="form-group ">
                            <img src="" class="d-block img-fluid selected-image">
                            <label for="category-hours">{{translate('image')}}</label>
                            <input type="file" class="form-control selected-image-input" id="category-image" name="image">
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

                <form class="update-form ajax-form" action="{{route('category.delete')}}" method="post">
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
                        <input required type="hidden" class="form-control item-id" id="item-id" name="category_id">
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

                <form class="update-form ajax-form" action="{{route('category.restore')}}" method="post">
                    <div class="modal-body">
                        @csrf

                        <div class="row">
                            <h5 class="text-success col-12">
                                {{translate('restoreConfirmMsg')}}
                            </h5>
                        </div>
                        <input required type="hidden" class="form-control item-id" id="item-id" name="category_id">
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
        let lastPage = 1;
        $(document).ready(function () {
            getCategories(page);
            $(document).on('click','.reload-btn',function () {
                getCategories(page);
            });
            $(document).on('click','.edit-item',function () {
                $('#edit-item-modal .item-id').val($(this).attr("item_id"));
                $('#edit-item-modal .item_name').val($(this).attr("item_name"));
                $('#edit-item-modal .selected-image').attr('src',"{{asset('/')}}"+$(this).attr("item_image"));
            });
            $(document).on('click','.delete-item',function () {
                $('#delete-item-modal .item-id').val($(this).attr("item_id"));
            });
            $(document).on('click','.restore-item',function () {
                $('#restore-item-modal .item-id').val($(this).attr("item_id"));
            });
            $(document).on('change','.selected-image-input',function () {
                let image=$(this).closest('form').find('.selected-image');
                let url = window.URL.createObjectURL(this.files[0]);
                image.attr('src',url);
            });
            $(document).on('change','.paginate-input',function () {
                getCategories($(this).val());
            });
            $(document).on('change','.active_status',function () {
                $(".paginate-input").val(1).trigger('change');
            });
            $(document).on('change','.delete_status',function () {
                $(".paginate-input").val(1).trigger('change');
            });
            $(document).on('click','.hide-active-item',function () {
                changeVisible($(this).attr("item_id"),$(this));
            });
        });
        function getCategories(page) {
            showLoadingSpinner();
            let active_status=$(".active_status").val();
            let delete_status=$(".delete_status").val();
            if(lastPage>=page)
                $.ajax({
                    url: "{{route('category.listAjax')}}",
                    data:{
                        "_token":"{{csrf_token()}}",
                        page:page,
                        active_status:active_status,
                        delete_status:delete_status,
                    },
                    type:'post',
                    success: function(result){
                        let categories=result.list.data;
                        lastPage=result.list.last_page;
                        $(".paginate-input").html('');
                        for(i=1;i<=lastPage;i++){
                            $(".paginate-input").append(`
                        <option value="${i}" ${page==i?'selected':''}>${i}</option>
                        `)
                        }
                        if(categories.length<1 && page==1) {
                            hideLoadingSpinner();

                            $('.t-body').html(`
                        <tr>
                            <td colspan="7">{{translate('noData')}}</td>
                        </tr>
                    `);
                        }
                        else {
                            $('.t-body').html(``);
                            categories.forEach(function (category,index) {
                                $('.t-body').append(`
                                <tr>
                                    <td>${index+1}</td>
                                    <td><img src="{{asset('/')}}${category.image}" class="category_img img-fluid"></td>
                                    <td> ${category.name}</td>
                                    <td><a href="{{route('courses.list')}}?category_id=${category.id}"> ${category.courses_count}</a></td>
                                    <td>
                                    <button
                                        class="d-block btn btn-outline-primary edit-item"
                                        data-toggle="modal" data-target="#edit-item-modal"
                                        item_id="${category.id}"
                                        item_name="${category.name}"
                                        item_image="${category.image}"
                                        >
                                            {{translate('edit')}}
                                </button>

                                <button
                                    class="d-block btn btn-outline-success hide-active-item"
                                    item_id="${category.id}">
                                            ${category.active?"{{translate('hide')}}":"{{translate('view')}}"}
                                    </button>

                                <button
                                    class="d-block btn btn-outline-danger delete-item"
                                    data-toggle="modal" data-target="#delete-item-modal"
                                    index="${index}" item_id="${category.id}">
                                            {{translate('delete')}}
                                </button>
                                <button
                                        class="${category.deleted_at?'d-block':'d-none'} btn btn-outline-success restore-item"
                                        data-toggle="modal" data-target="#restore-item-modal"
                                        index="${index}" item_id="${category.id}">
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
        function changeVisible(category_id) {
            showLoadingSpinner();
            $.ajax({
                url: "{{route('category.changeVisible')}}",
                data:{
                    "_token":"{{csrf_token()}}",
                    category_id:category_id,
                },
                type:'post',
                success: function(result){
                    $(".reload-btn").click();
                }
            });
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
