@extends('layouts.app')

@section('heading')
    <h3><strong>Quiz Manager</strong></h3>
@endsection
@section('content')
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 content-settings">
        <table class="table table-responsive table-bordered">
            <thead class="bg-primary">
            <tr>
                <th></th>
                <th class="text-center"> Category</th>
                <th class="text-center"> SubCategory</th>
                <th class="text-center"> Description</th>
                <th class="text-center"> Type</th>
                <th class="text-center"> Points</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach($quizes as $quize)
                <tr>
                    <td><a href="{{route('edit.quiz',[$quize->id])}}" class="btn btn-info btn-sm"><i class=" fa fa-arrow-right"></i></a></td>
                    <td> {{$quize->subCategory->category->title}} </td>
                    <td> {{$quize->subCategory->title}} </td>
                    <td> {{$quize->description}} </td>
                    @if($quize->type == 1)
                        <td> Single </td>
                    @else
                        <td> Multiple </td>
                    @endif
                    <td> {{$quize->points}} </td>
                    <td><a href="{{route('delete.quiz',[$quize->id])}}" class="btn btn-danger btn-sm"><i
                                    class=" fa fa-trash"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
        <div class="text-center">
            <span>{{$quizes->links()}}</span>
        </div>
    </div>
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">
        <a href="{{route('create.quiz')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i></a>
    </div>
@endsection

@section('content_footer')

@endsection
