@extends('layouts.app')

@section('heading')
    <h3 style="color:brown;"><strong>Category Manager</strong></h3>
@endsection
@section('content')
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 content-settings">
        <table class="table table-responsive table-bordered">
            <thead class="bg-primary">
            <tr>
                <th></th>
                <th class="text-center"> Category</th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach($cats as $cat)
                <tr>
                    <td><a href="{{route('edit.category',[$cat->id])}}" class="btn btn-info btn-md"><i class=" fa fa-arrow-right"></i></a></td>
                    <td> {{$cat->title}}</td>
                    <td><a href="{{route('delete.category',[$cat->id])}}" class="btn btn-danger btn-md"><i class=" fa fa-trash"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
        <div class="text-center">
            <span>{{$cats->links()}}</span>
        </div>
    </div>
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">
        <a href="{{route('create.category')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i></a>
    </div>
@endsection

@section('content_footer')

@endsection
