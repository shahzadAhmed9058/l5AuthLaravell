@extends('layouts.app')

@section('heading')
    <div class="alert alert-default">
        <h3><strong>Create Quiz</strong></h3>
    </div>
@endsection
@section('content')
    @if(session()->has('message'))
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <strong>Error!</strong> {{session()->get('message')}} ...
        </div>
    @endif
    <form action="{{route('store.quiz')}}" id="quiz-form-data" method="post" class="form-horizontal"
          style="margin-top: 20px">
        {{csrf_field()}}
        <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
            <div class="form-group row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group"> {{-- quiz category --}}
                        <span class="col-lg-3 control-span">Category</span>
                        <div class="col-lg-9">
                            <select name="category_id" id="category_id" class="form-control" onchange="getSubCats()">
                                <option value="default"> Select Category</option>
                                @foreach($cats as $cat)
                                    <option value="{{$cat->id}}">{{$cat->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('sub_category_id') ? ' has-error' : '' }}"> {{-- quiz subcategory --}}
                        <span class="col-lg-3 control-span">SubCategory</span>
                        <div class="col-lg-9" id="subcat">
                            <select name="sub_category_id" id="sub_category_id" class="form-control">
                                <option value="default"> Select SubCategory</option>
                            </select>
                            @if($errors->has('sub_category_id'))
                                <span class="help-block">
                                    <strong>{{$errors->first('sub_category_id')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('type') ? 'has-error' : ''}}">
                        <span class="col-lg-3 control-span">Type</span>
                        <div class="col-lg-9" id="pradio">
                            <div class="radio" id="radio1">
                                <label>
                                    <input type="radio" name="type" id="type" value="1">
                                    Radio Button
                                </label>
                            </div>
                            <div class="radio" id="radio2">
                                <label>
                                    <input type="radio" name="type" id="type" value="2">
                                    CheckBoxes
                                </label>
                            </div>
                            @if($errors->has('type'))
                                <span class="help-block">
                                    <strong>{{$errors->first('type')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">    {{-- quiz description --}}
                        <span class="col-lg-3 control-span">Description</span>
                        <div class="col-lg-9">
                            <input type="text" name="description" class="form-control" placeholder="description"
                                   value="{{old('description')}}">
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('question') ? 'has-error' : ''}}">    {{-- question --}}
                        <span class="col-lg-3 control-span">Question</span>
                        <div class="col-lg-9">
                            <textarea name="question" style="resize: none; height: 170px" id="question"
                                      class="form-control" rows="5"
                                      placeholder="Write Question here..."> {{old('question')}} </textarea>
                            @if($errors->has('question'))
                                <span class="help-block">
                                    <strong>{{$errors->first('question')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('points') ? 'has-error' : ''}}">
                        <span class="col-lg-3 control-span">Points</span>
                        <div class="col-lg-9">
                            <input type="number" class="form-control" name="points" placeholder="Points">
                            @if($errors->has('points'))
                                <span class="help-block">
                                    <strong>{{$errors->first('points')}}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="form-group">
                        <label class="col-lg-3 control-span">Options:</label>
                    </div>
                    <div class="form-group">
                        @foreach(range(0,3) as $x)
                            <div class="form-group {{$errors->has('option.'. $x)? 'has-error' : ''}}">
                                <span class="col-lg-3 control-span" style="text-align: right">Option {{$x+1}}:</span>
                                <div class="col-lg-9">
                                    <input type="text" class="form-control" id="opt{{$x+1}}" name="option[]"
                                           placeholder="Option 1" value="{{old('option.' .$x)}}">

                                    @if($errors->has('option.'.$x))
                                        <span class="help-block">
                                        <strong> {{$errors->first('option.'.$x)}} </strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="form-group">
                        <label class="col-lg-3 control-span">Answers:</label>
                        <div class="col-lg-9 col-lg-offset-3">
                            <div class="checkbox" style="margin-bottom: 13px">
                                <label>
                                    <input type="hidden" name="cbox[0]" value="ans1">
                                    <input type="checkbox" name="ans[0]" value="" id="ans1"> Option 1
                                </label>
                            </div>
                            <div class="checkbox" style="margin-bottom: 13px">
                                <label>
                                    <input type="hidden" name="cbox[1]" value="ans2">
                                    <input type="checkbox" name="ans[1]" value="" id="ans2"> Option 2
                                </label>
                            </div>
                            <div class="checkbox" style="margin-bottom: 13px">
                                <label>
                                    <input type="hidden" name="cbox[2]" value="ans3">
                                    <input type="checkbox" name="ans[2]" value="" id="ans3"> Option 3
                                </label>
                            </div>
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="cbox[3]" value="ans4">
                                    <input type="checkbox" name="ans[3]" value="" id="ans4"> Option 4
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">
            <a href="{{route('quiz.manager')}}" class="btn btn-info"> <i class="fa fa-arrow-left"></i> </a>
            <button class="btn btn-warning pull-right"><i class="fa fa-save"></i></button>
            {{--<button class="btn btn-warning pull-right" onclick="submitQuizForm()"><i class="fa fa-save"></i></button>--}}
        </div>
    </form>
@endsection
@section('js')
    <script>
        function getSubCats() {
            var value = $('#category_id').val();
            if (value == 'default') {
                $('#subcat').html('<select name="sub_category_id" id="subcategory_id" class="form-control">\n' +
                    '                                <option value="default"> Select SubCategory </option>\n' +
                    '                            </select>');
            }
            else {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    method: 'get',
                    url: '/admin/' + value + '/get/subcategories',
                    datatype: 'json',
                    success: function (data) {
                        // console.log(data.subcats);
                        $('#subcat').html('<select name="sub_category_id" id="subcategory_id" class="form-control">\n' +
                            '                                <option value="default"> Select SubCategory</option>\n' +
                            '                                ' + data.subcats + ' \n' +
                            '                            </select>');
                    }
                });
            }
        }

        $('#quiz-form-data :checkbox').change(function () {
                var id = "";
                var value = "";
                if (this.checked) {
                    id = $(this).prop('id');
                    value = "";
                    switch (id) {
                        case 'ans1': {
                            value = $('#opt1').val();
                            $('#ans1').val(value);
                        }
                            break;
                        case 'ans2': {
                            value = $('#opt2').val();
                            $('#ans2').val(value);
                        }
                            break;
                        case 'ans3': {
                            value = $('#opt3').val();
                            $('#ans3').val(value);
                        }
                            break;
                        case 'ans4': {
                            value = $('#opt4').val();
                            $('#ans4').val(value);
                        }
                            break;
                    }
                } else {
                    id = $(this).prop('id');
                    value = "";
                    switch (id) {
                        case 'ans1': {
                            $('#ans1').val('');
                        }
                            break;
                        case 'ans2': {
                            $('#ans2').val('');
                        }
                            break;
                        case 'ans3': {
                            $('#ans3').val('');
                        }
                            break;
                        case 'ans4': {
                            $('#ans4').val('');
                        }
                            break;
                    }
                }
            }
        );
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
{{--error.insertAfter( element.parent( "span" ) );--}}
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
{{--error.insertAfter( element.parent( "span" ) );--}}
{{--} else {--}}
{{--error.insertAfter( element );--}}
{{--}--}}

{{--// Add the span element, if doesn't exists, and apply the icon classes to it.--}}
{{--if ( !element.next( "span" )[ 0 ] ) {--}}
{{--$( "<span class='glyphicon glyphicon-remove form-control-feedback'></span>" ).insertAfter( element );--}}
{{--}--}}
{{--},--}}
{{--success: function ( span, element ) {--}}
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
{{--<span class="col-lg-1 control-span">Title</span>--}}
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


{{--function submitQuizForm() {--}}
{{--$.validator.setDefaults({--}}
{{--errorClass: 'help-block',--}}
{{--highlight: function (element) {--}}
{{--$(element).closest('.form-group').addClass('has-error');--}}
{{--},--}}
{{--unhighlight: function (element) {--}}
{{--$(element).closest('.form-group').removeClass('has-error');--}}
{{--},--}}
{{--errorPlacement: function (error, element) {--}}
{{--if (element.prop('type') === 'radio') {--}}
{{--error.insertAfter(element.parent().parent().parent().children().last());--}}
{{--} else {--}}
{{--error.insertAfter(element);--}}
{{--}--}}
{{--}--}}
{{--});--}}

{{--$.validator.addMethod("valueNotEquals", function (value, element, arg) {--}}
{{--return arg !== value;--}}
{{--}, "Value must not equal arg.");--}}

{{--$("#quiz-form-data").validate({--}}
{{--rules: {--}}
{{--category_id: {--}}
{{--valueNotEquals: "default"--}}
{{--},--}}
{{--subcategory_id: {--}}
{{--valueNotEquals: "default"--}}
{{--},--}}
{{--question: {--}}
{{--required: true,--}}
{{--},--}}
{{--type: {--}}
{{--required: true,--}}
{{--},--}}
{{--points: {--}}
{{--required: true,--}}
{{--minlength: 5,--}}
{{--}--}}
{{--},--}}
{{--messages: {--}}
{{--question: {--}}
{{--required: 'this field is required',--}}
{{--},--}}
{{--category_id: {--}}
{{--valueNotEquals: "Please select an item!"--}}
{{--},--}}
{{--subcategory_id: {--}}
{{--valueNotEquals: "please select an item!"--}}
{{--},--}}
{{--type: {--}}
{{--required: "please select one option!"--}}
{{--},--}}
{{--points: {--}}
{{--required: "This field is required",--}}
{{--minlength: "points should be equal to greater than 5",--}}
{{--}--}}
{{--},--}}
{{--});--}}

{{--// function setCheckBox() {--}}
{{--//     alert('working');--}}
{{--// }--}}

{{--if ($('#form-data').valid()) {--}}
{{--$('#form-data').on('submit', function (e) {--}}
{{--e.preventDefault();--}}
{{--var data = $('#form-data').serialize();--}}
{{--$.ajaxSetup({--}}
{{--headers: {--}}
{{--'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')--}}
{{--}--}}
{{--});--}}
{{--$.ajax({--}}
{{--type: 'post',--}}
{{--url: '{{route('store.category')}}',--}}
{{--data: data,--}}
{{--success: function (data) {--}}
{{--console.log(data.message);--}}
{{--window.location = '{{route('category.manager')}}';--}}
{{--}--}}
{{--})--}}
{{--})--}}
{{--}--}}
}