@extends('layouts.app')

@section('heading')
    <h3><strong>Create Category</strong></h3>
@endsection
@section('content')
    <form id="form-data" style="margin-top: 20px">
        {{--<input type="hidden" value="{{$cat->id}}">--}}
        <div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 content-settings">
            <div class="form-group">
                <label class="col-lg-1 control-label">Title</label>
                <div class="col-lg-10">
                    <input type="text" name="title" id="title" class="form-control" value="{{$cat->title}}" placeholder="Title">
                </div>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">
            <a href="{{route('category.manager')}}" class="btn btn-info"> <i class="fa fa-arrow-left"></i> </a>
            <button class="btn btn-warning pull-right" onclick="submitForm()"><i class="fa fa-save"></i></button>
        </div>
    </form>
@endsection
@section('js')
    <script>
        function submitForm() {
            $.validator.setDefaults({
                errorClass: 'help-block',
                highlight:function (element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight:function (element) {
                    $(element).closest('.form-group').removeClass('has-error');
                }
            });

            $( "#form-data" ).validate( {
                rules: {
                    title:{
                        required:true,
                        minlength:5,
                    },
                },
                messages: {
                    title:{
                        required:'this field is required',
                        minlength:'text length should be greater than or equal to 5',
                    },
                },
            });
            if($('#form-data').valid())
            {
                $('#form-data').on('submit', function (e) {
                    e.preventDefault();
                    var data = $('#form-data').serialize();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        type: 'post',
                        url: '{{route('update.category',[$cat->id])}}',
                        data: data,
                        success:function (data) {
                            // console.log(data);
                            window.location = '{{route('category.manager')}}';
                        }
                    })
                })
            }
        }
    </script>
@endsection


{{------------------------------------------front end jquery validation plugin code----------------------------------------}}

{{--<script>--}}

    {{--$.validator.setDefaults( {--}}
        {{--submitHandler: function () {--}}
            {{--alert( "submitted!" );--}}
        {{--}--}}
    {{--} );--}}

    {{--$( document ).ready( function () {--}}
        {{--$( "#validateForm" ).validate( {--}}
            {{--rules: {--}}
                {{--title: "required",--}}
                {{--lastname: "required",--}}
                {{--username: {--}}
                    {{--required: true,--}}
                    {{--minlength: 2--}}
                {{--},--}}
                {{--password: {--}}
                    {{--required: true,--}}
                    {{--minlength: 5--}}
                {{--},--}}
                {{--confirm_password: {--}}
                    {{--required: true,--}}
                    {{--minlength: 5,--}}
                    {{--equalTo: "#password"--}}
                {{--},--}}
                {{--email: {--}}
                    {{--required: true,--}}
                    {{--email: true--}}
                {{--},--}}
                {{--agree: "required"--}}
            {{--},--}}


            {{--messages: {--}}
                {{--firstname: "Please enter your firstname",--}}
                {{--lastname: "Please enter your lastname",--}}
                {{--username: {--}}
                    {{--required: "Please enter a username",--}}
                    {{--minlength: "Your username must consist of at least 2 characters"--}}
                {{--},--}}
                {{--password: {--}}
                    {{--required: "Please provide a password",--}}
                    {{--minlength: "Your password must be at least 5 characters long"--}}
                {{--},--}}
                {{--confirm_password: {--}}
                    {{--required: "Please provide a password",--}}
                    {{--minlength: "Your password must be at least 5 characters long",--}}
                    {{--equalTo: "Please enter the same password as above"--}}
                {{--},--}}
                {{--email: "Please enter a valid email address",--}}
                {{--agree: "Please accept our policy"--}}
            {{--},--}}
            {{--errorElement: "em",--}}
            {{--errorPlacement: function ( error, element ) {--}}
                {{--// Add the `help-block` class to the error element--}}
                {{--error.addClass( "help-block" );--}}

                {{--if ( element.prop( "type" ) === "checkbox" ) {--}}
                    {{--error.insertAfter( element.parent( "label" ) );--}}
                {{--} else {--}}
                    {{--error.insertAfter( element );--}}
                {{--}--}}
            {{--},--}}
            {{--highlight: function ( element, errorClass, validClass ) {--}}
                {{--$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );--}}
            {{--},--}}
            {{--unhighlight: function (element, errorClass, validClass) {--}}
                {{--$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );--}}
            {{--}--}}
        {{--} );--}}

        {{--$( "#signupForm1" ).validate( {--}}
            {{--rules: {--}}
                {{--firstname1: "required",--}}
                {{--lastname1: "required",--}}
                {{--username1: {--}}
                    {{--required: true,--}}
                    {{--minlength: 2--}}
                {{--},--}}
                {{--password1: {--}}
                    {{--required: true,--}}
                    {{--minlength: 5--}}
                {{--},--}}
                {{--confirm_password1: {--}}
                    {{--required: true,--}}
                    {{--minlength: 5,--}}
                    {{--equalTo: "#password1"--}}
                {{--},--}}
                {{--email1: {--}}
                    {{--required: true,--}}
                    {{--email: true--}}
                {{--},--}}
                {{--agree1: "required"--}}
            {{--},--}}
            {{--messages: {--}}
                {{--firstname1: "Please enter your firstname",--}}
                {{--lastname1: "Please enter your lastname",--}}
                {{--username1: {--}}
                    {{--required: "Please enter a username",--}}
                    {{--minlength: "Your username must consist of at least 2 characters"--}}
                {{--},--}}
                {{--password1: {--}}
                    {{--required: "Please provide a password",--}}
                    {{--minlength: "Your password must be at least 5 characters long"--}}
                {{--},--}}
                {{--confirm_password1: {--}}
                    {{--required: "Please provide a password",--}}
                    {{--minlength: "Your password must be at least 5 characters long",--}}
                    {{--equalTo: "Please enter the same password as above"--}}
                {{--},--}}
                {{--email1: "Please enter a valid email address",--}}
                {{--agree1: "Please accept our policy"--}}
            {{--},--}}
            {{--errorElement: "em",--}}
            {{--errorPlacement: function ( error, element ) {--}}
                {{--// Add the `help-block` class to the error element--}}
                {{--error.addClass( "help-block" );--}}

                {{--// Add `has-feedback` class to the parent div.form-group--}}
                {{--// in order to add icons to inputs--}}
                {{--element.parents( ".col-sm-5" ).addClass( "has-feedback" );--}}

                {{--if ( element.prop( "type" ) === "checkbox" ) {--}}
                    {{--error.insertAfter( element.parent( "label" ) );--}}
                {{--} else {--}}
                    {{--error.insertAfter( element );--}}
                {{--}--}}

                {{--// Add the span element, if doesn't exists, and apply the icon classes to it.--}}
                {{--if ( !element.next( "span" )[ 0 ] ) {--}}
                    {{--$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );--}}
                {{--}--}}
            {{--},--}}
            {{--success: function ( label, element ) {--}}
                {{--// Add the span element, if doesn't exists, and apply the icon classes to it.--}}
                {{--if ( !$( element ).next( "span" )[ 0 ] ) {--}}
                    {{--$( "<span class='glyphicon glyphicon-ok form-control-feedback'></span>" ).insertAfter( $( element ) );--}}
                {{--}--}}
            {{--},--}}
            {{--highlight: function ( element, errorClass, validClass ) {--}}
                {{--$( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );--}}
                {{--$( element ).next( "span" ).addClass( "glyphicon-remove" ).removeClass( "glyphicon-ok" );--}}
            {{--},--}}
            {{--unhighlight: function ( element, errorClass, validClass ) {--}}
                {{--$( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );--}}
                {{--$( element ).next( "span" ).addClass( "glyphicon-ok" ).removeClass( "glyphicon-remove" );--}}
            {{--}--}}
        {{--} );--}}
    {{--} );--}}

{{--</script>--}}

{{------------------------------------------front end jquery validation plugin code----------------------------------------}}


{{--<form action="{{route('store.category')}}" method="post" style="margin-top: 20px">--}}
    {{--{{ csrf_field() }}--}}
    {{--<div class="col-md-6 col-sm-6 col-xs-6 col-md-offset-3 col-sm-offset-3 col-xs-offset-3 content-settings">--}}
        {{--<div class="form-group">--}}
            {{--<label class="col-lg-1 control-label">Title</label>--}}
            {{--<div class="col-lg-10">--}}
                {{--<input type="text" name="title" id="title" class="form-control" placeholder="Title">--}}
                {{--<div style="margin: 3px">--}}
                    {{--<p class="text-danger">{{$errors->first('title')}}</p>--}}
                {{--</div>--}}
            {{--</div>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--<div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">--}}
        {{--<a href="{{route('admin.category')}}" class="btn btn-info"> <i class="fa fa-arrow-left"></i> </a>--}}
        {{--<button class="btn btn-warning pull-right" id="scat"><i class="fa fa-save"></i></button>--}}
    {{--</div>--}}
{{--</form>--}}


