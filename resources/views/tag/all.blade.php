@extends('layouts.app')

@section('content')
    <div class="container all_categories">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header row">
                        <div class="col-8">
                            <h1 class="page-title reload-btn">
                                {{ translate('tagsList') }}
                            </h1>
                        </div>
                        <div class="col-3">
                            <button
                                class="new-item btn btn-outline-success"
                                data-toggle="modal" data-target="#new-item-modal">
                                {{translate('newTag')}}
                            </button>
                        </div>
                        <select  class="col-1 form-control paginate-input" >
                        </select>
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

    <div class="modal"  id="new-item-modal" >
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" >

                <!-- Modal Header -->
                <div class="modal-header" dir="{{app()->getLocale()=='ar'?'rtl':'ltr'}}">
                    <h5 class="modal-title">{{translate('newTag')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="insert-form ajax-form" action="{{route('tags.insert')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group ">
                            <label for="new-item-name">{{translate('name')}}</label>
                            <input required type="text" class="form-control" id="new-item-name" name="name">
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
                    <h5 class="modal-title">{{translate('editTag')}}</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form class="update-form ajax-form" action="{{route('tags.update')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <div class="form-group ">
                            <label for="new-item-title">{{translate('name')}}</label>
                            <input required type="text" class="form-control item_name" id="item_name" name="name">
                            <input required type="hidden" class="form-control item-id" id="item-id" name="tag_id">
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

                <form class="update-form ajax-form" action="{{route('tags.delete')}}" method="post">
                    <div class="modal-body">
                        @csrf
                        <h5 class="text-center text-danger">
                            {{translate('deleteConfirmMsg')}}
                        </h5>
                        <input required type="hidden" class="form-control item-id" id="item-id" name="tag_id">
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
            getTags(page);
            $(document).on('click','.reload-btn',function () {
                getTags(page);
            });
            $(document).on('click','.edit-item',function () {
                $('#edit-item-modal .item-id').val($(this).attr("item_id"));
                $('#edit-item-modal .item_name').val($(this).attr("item_name"));
            });
            $(document).on('click','.delete-item',function () {
                $('#delete-item-modal .item-id').val($(this).attr("item_id"));
            });

            $(document).on('change','.paginate-input',function () {
                getTags($(this).val());
            });
        });
        function getTags(page) {
            showLoadingSpinner();
            if(lastPage>=page)
                $.ajax({
                    url: "{{route('tags.listAjax')}}",
                    data:{
                        "_token":"{{csrf_token()}}",
                        page:page,
                    },
                    type:'post',
                    success: function(result){
                        let tags=result.list.data;
                        lastPage=result.list.last_page;
                        $(".paginate-input").html('');
                        for(i=1;i<=lastPage;i++){
                            $(".paginate-input").append(`
                        <option value="${i}" ${page==i?'selected':''}>${i}</option>
                        `)
                        }
                        if(tags.length<1 && page==1) {
                            hideLoadingSpinner();

                            $('.t-body').html(`
                        <tr>
                            <td colspan="4">{{translate('noData')}}</td>
                        </tr>
                    `);
                        }
                        else {
                            $('.t-body').html(``);
                            tags.forEach(function (tag,index) {
                                $('.t-body').append(`
                                <tr>
                                    <td>${index+1}</td>
                                    <td> ${tag.name}</td>
                                    <td><a href="{{route('courses.list')}}?tag_name=${tag.name}"> ${tag.courses.length}</a></td>
                                    <td>
                                    <button
                                        class="d-block btn btn-outline-primary edit-item"
                                        data-toggle="modal" data-target="#edit-item-modal"
                                        item_id="${tag.id}"
                                        item_name="${tag.name}"
                                        >
                                            {{translate('edit')}}
                                </button>

                                <button
                                        class="d-block btn btn-outline-danger delete-item"
                                        data-toggle="modal" data-target="#delete-item-modal"
                                        index="${index}" item_id="${tag.id}">
                                            {{translate('delete')}}
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
        function showLoadingSpinner() {
            $(".loading-spinner").show()
        }
        function hideLoadingSpinner() {
            $(".loading-spinner").hide()
        }
        $(".search-input").hide();
    </script>
@endsection
