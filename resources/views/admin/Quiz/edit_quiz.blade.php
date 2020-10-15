@extends('layouts.app')

@section('heading')
    <div class="alert alert-default">
        <h3><strong>Edit Quiz</strong></h3>
    </div>
@endsection
@section('content')
    {{--@if(session()->has('message'))--}}
    {{--<div class="alert alert-danger">--}}
    {{--<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>--}}
    {{--<strong>Error!</strong> {{session()->get('message')}} ...--}}
    {{--</div>--}}
    {{--@endif--}}
    <form action="{{route('update.quiz',[$quiz->id])}}" id="quiz-form-data" method="post" class="form-horizontal"
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
                                    <option value="{{$cat->id}}"@if($quizCategory->id==$cat->id){{'selected'}} @endif >{{$cat->title}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('sub_category_id') ? ' has-error' : '' }}"> {{-- quiz subcategory --}}
                        <span class="col-lg-3 control-span">SubCategory</span>
                        <div class="col-lg-9" id="subcat">
                            <select name="sub_category_id" id="sub_category_id" class="form-control">
                                <option value="{{$quizSubCategory->id}}"> {{$quizSubCategory->title}} </option>
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
                                    <input type="radio" name="type" id="type"
                                           value="1" @if($quiz->type == 1) {{'checked'}} @endif>
                                    Radio Button
                                </label>
                            </div>
                            <div class="radio" id="radio2">
                                <label>
                                    <input type="radio" name="type" id="type"
                                           value="2" @if($quiz->type == 2) {{'checked'}} @endif>
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
                                   value="{{$quiz->description}}">
                        </div>
                    </div>
                    <div class="form-group {{$errors->has('question') ? 'has-error' : ''}}">    {{-- question --}}
                        <span class="col-lg-3 control-span">Question</span>
                        <div class="col-lg-9">
                            <textarea name="question" style="resize: none; height: 170px" id="question"
                                      class="form-control" rows="5"
                                      placeholder="Write Question here..."> {{$quiz->question}} </textarea>
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
                            <input type="number" class="form-control" name="points" placeholder="Points"
                                   value="{{$quiz->points}}">
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
                                           placeholder="Option 1" value="{{$quizOptions[$x]->option_desc}}">
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
                            @if(isset($quizAnswers))
                                @for($i=0,$j=1; $i<4; $i++, $j++)
                                    <div class="checkbox" style="margin-bottom: 13px">
                                        <label>
                                            <input type="hidden" name="cbox[{{$i}}]" value="ans{{$i+1}}">
                                            @if($quizAnswers[$i]->cBox_index == 'ans'.$j)
                                                <input type="checkbox" name="ans[{{$i}}]"
                                                       value="{{$quizAnswers[$i]->answer_desc}}" id="ans{{$i+1}}"
                                                       checked> Option {{$i+1}}
                                            @else
                                                <input type="checkbox" name="ans[{{$i}}]" value="" id="ans{{$i+1}}">
                                                Option {{$i+1}}
                                            @endif
                                        </label>
                                    </div>
                                @endfor
                                @if(session()->has('message'))
                                    <div class="has-error">
                                            <span class="help-block">
                                                <strong> {{session()->get('message')}} </strong>
                                            </span>
                                    </div>
                                @endif
                            @elseif(isset($singleOption))
                                @for($i=0,$j=1; $i<4; $i++, $j++)
                                    <div class="checkbox" style="margin-bottom: 13px">
                                        <label>
                                            <input type="hidden" name="cbox[{{$i}}]" value="ans{{$i+1}}">
                                            @if($singleOption->cBox_index == 'ans'.$j)
                                                <input type="checkbox" name="ans[{{$i}}]"
                                                       value="{{$singleOption->answer_desc}}" id="ans{{$i+1}}"
                                                       checked> Option {{$i+1}}
                                            @else
                                                <input type="checkbox" name="ans[{{$i}}]" value="" id="ans{{$i+1}}">
                                                Option {{$i+1}}
                                            @endif
                                        </label>
                                    </div>
                                @endfor
                                @if(session()->has('message'))
                                    <div class="has-error">
                                            <span class="help-block">
                                                <strong> {{session()->get('message')}} </strong>
                                            </span>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">
            <a href="{{route('quiz.manager')}}" class="btn btn-info"> <i class="fa fa-arrow-left"></i> </a>
            <button class="btn btn-warning pull-right"><i class="fa fa-save"></i></button>
        </div>
    </form>
@endsection
@section('js')
    <script>
        function getSubCats() {
            var jsonData = [];
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
