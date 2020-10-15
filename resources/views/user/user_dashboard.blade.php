@extends('layouts.app')

@section('content')
    @if(count($user_q)>0)

        <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1" style="background: white; padding: 10px">
            <h1> {{$user_name}} </h1>
            <table class="table table-responsive table-bordered">
                <thead class="bg-primary">
                <tr>
                    <th class="text-center"> Quiz Category </th>
                    <th class="text-center"> Total Questions </th>
                    <th class="text-center"> Correct Answers </th>
                    <th class="text-center"> Wrong Answers </th>
                    <th class="text-center"> Percentage </th>
                </tr>
                </thead>
                <tbody class="text-center">
                @foreach($user_q as $q)
                    <tr>
                        <td> {{$q->quiz_subcategory}} </td>
                        <td> {{$q->total_questions}} </td>
                        <td> {{$q->correct_answers}} </td>
                        <td> {{$q->wrong_answers}} </td>
                        <td> {{$q->persentage}} <strong>%</strong> </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            <a href="{{route('home')}}" class="btn btn-primary"> Start Quiz</a>
        </div>
    @else
        <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 content-settings">
            <p> Report Not Exist </p>
        </div>

    @endif

@endsection
