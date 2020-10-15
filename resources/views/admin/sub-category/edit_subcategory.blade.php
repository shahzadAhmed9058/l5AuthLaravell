@extends('layouts.app')

@section('heading')
    <div id="msg">
    </div>
    <h3><strong>Create SubCategory</strong></h3>
@endsection
@section('content')

    <form action="{{route('store.subcategory')}}" method="post" class="form-horizontal" style="margin-top: 20px">
        {{csrf_field()}}
        <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 content-settings">
            <div class="form-group">
                <label class="col-lg-3 control-label">Select Category</label>
                <div class="col-lg-9">
                    <select name="category_id" id="category_id" class="form-control">
                        <option value="default"> Select Category</option>
                        @foreach($cats as $cat)
                            <option value="{{$cat->id}}">{{$cat->title}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg-3 control-label">Title</label>
                <div class="col-lg-9">
                    <input type="text" name="title" id="title" class="form-control" placeholder="Title">
                </div>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">
            <a href="{{route('subcategory.manager')}}" class="btn btn-info"> <i class="fa fa-arrow-left"></i> </a>
            <button class="btn btn-warning pull-right" type="submit"><i class="fa fa-save"></i></button>
        </div>
    </form>
@endsection
{{--@section('js')--}}
    {{--<script>--}}

        {{--function submitSubCatForm() {--}}
            {{--// alert('working');--}}
            {{--$.validator.setDefaults({--}}
                {{--errorClass: 'help-block',--}}
                {{--highlight: function (element) {--}}
                    {{--$(element).closest('.form-group').addClass('has-error');--}}
                {{--},--}}
                {{--unhighlight: function (element) {--}}
                    {{--$(element).closest('.form-group').removeClass('has-error');--}}
                {{--}--}}
            {{--});--}}

            {{--$.validator.addMethod("valueNotEquals", function (value, element, arg) {--}}
                {{--return arg !== value;--}}
            {{--}, "Value must not equal arg.");--}}

            {{--$("#subcat-form-data").validate({--}}
                {{--rules: {--}}
                    {{--category_id: {--}}
                        {{--valueNotEquals: "default"--}}
                    {{--},--}}
                    {{--title: {--}}
                        {{--required: true,--}}
                        {{--minlength: 5,--}}
                    {{--},--}}
                {{--},--}}
                {{--messages: {--}}
                    {{--title: {--}}
                        {{--required: 'this field is required',--}}
                        {{--minlength: 'text length should be greater than or equal to 5',--}}
                    {{--},--}}
                    {{--category_id: {--}}
                        {{--valueNotEquals: "Please select an item!"--}}
                    {{--}--}}
                {{--},--}}
            {{--});--}}
            {{--if ($('#subcat-form-data').valid()) {--}}
                {{--$('#subcat-form-data').on('submit', function (e) {--}}
                    {{--e.preventDefault();--}}
                    {{--var data = $('#subcat-form-data').serialize();--}}
                    {{--$.ajaxSetup({--}}
                        {{--headers: {--}}
                            {{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
                        {{--}--}}
                    {{--});--}}
                    {{--$.ajax({--}}
                        {{--type: 'post',--}}
                        {{--url: '{{route('store.subcategory')}}',--}}
                        {{--data: data,--}}
                        {{--success: function (data) {--}}
                            {{--$('#subcat-form-data')[0].reset();--}}
                            {{--$('#msg').html('<div class="alert alert-success">\n' +--}}
                                {{--'        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>\n' +--}}
                                {{--'        <strong>'+data.title+'</strong> '+data.message+'\n' +--}}
                                {{--'    </div>').fadeOut(5000);--}}

                            {{--// console.log(data.message);--}}
                            {{--window.location = '{{route('subcategory.manager')}}';--}}
                        {{--}--}}
                    {{--});--}}
                {{--});--}}
            {{--}--}}
        {{--}--}}
    {{--</script>--}}
{{--@endsection--}}



