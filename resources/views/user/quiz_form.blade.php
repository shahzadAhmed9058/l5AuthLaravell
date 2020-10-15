@extends('layouts.app')

@section('content')
    @if(count($data)>0)
        <div class="col-md-8 col-lg-offset-2 col-md-offset-2" id="parent" style="background: white">
            <div class="alert">
                <div class="pull-left">
                    <strong>Title!</strong>
                </div>
                <div class="pull-right">
                    <strong> <span id="timer"> </span> </strong>
                </div>
            </div>
            <form id="quiz">
                <div class="form-group">
                    <input type="hidden" value="{{$subcat_id}}" name="subcat_id">
                    @for($i=0; $i<count($data); $i++)
                        @php
                            $j = 0;
                        @endphp
                        <div>
                            <p class="bg-primary" style="margin-top: 30px; font-size: large; padding: 10px">
                                <span> <strong>Q:{{$i+1}}</strong> </span> {{$data[$i]['question']}}
                            </p>
                            <div class="bg-success" style="padding: 10px">
                                @if($data[$i]['type'] == 2)
                                    @foreach($data[$i]->optionModels as $opt)
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" name="check[{{$data[$i]['id']}}][{{$j++}}]"
                                                       value="{{$opt->option_desc}}"> {{$opt->option_desc}}
                                            </label>
                                        </div>
                                    @endforeach
                                @else
                                    @foreach($data[$i]->optionModels as $opt)
                                        <div class="radio">
                                            <label>
                                                <input type="radio" name="radio[{{$data[$i]['id']}}]"
                                                       value="{{$opt->option_desc}}"> {{$opt->option_desc}}
                                            </label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    @endfor
                </div>
                <div class="form-group">
                    <button class="btn btn-primary" type="submit" id="submitQuiz"> Submit </button>
                    <a href="{{url('/home')}}" class="btn btn-default"> Back To Home Page </a>
                </div>
            </form>
        </div>
    @else
        <div class="col-md-8 col-lg-offset-2 col-md-offset-2" id="parent" style="background: white">
            <p> Quiz Is Not Ready Yet </p>
            <a href="{{url('/home')}}" class="btn btn-primary"> Back To Home Page </a>
        </div>
    @endif
@endsection
@section('js')
    <script>
        $(document).ready(function () {
            if ('{{count($data) > 0}}') {
                var sec = 30;
                clearInterval(timer);
                timer = setInterval(function () {
                    $('#timer').text(sec-- + ' sec');
                    if (sec == -1) {
                        clearInterval(timer);
                    }
                }, 1000);
                setTimeout(function () {
                    var form_data = $('#quiz').serialize();
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        method: 'post',
                        url: '/user/quiz-results',
                        data: form_data,
                        success: function (data) {
                            $('#parent').html(data.view);
                        }
                    });
                }, 30000);
            }
        });

        $('#quiz').on('submit', function (e) {
            e.preventDefault();
            var form_data = $('#quiz').serialize();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                method: 'post',
                url: '/user/quiz-results',
                data: form_data,
                success: function (data) {
                    $('#parent').html(data.view);
                }
            });
        });
    </script>
@endsection
