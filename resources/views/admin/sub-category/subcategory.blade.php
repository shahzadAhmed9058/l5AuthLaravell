@extends('layouts.app')

@section('heading')
    <h3 style="color:red"><strong>SubCategory Manager</strong></h3>
@endsection
@section('content')
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 content-settings">
        <table class="table table-responsive table-bordered" id="mytable">
            <thead class="bg-primary">
            <tr>
                <th></th>
                <th class="text-center"> Category </th>
                <th class="text-center"> SubCategory </th>
                <th></th>
            </tr>
            </thead>
            <tbody class="text-center">
            @foreach($subcats as $subcat)
                <tr>
                    <td><a href="#" class="btn btn-info btn-sm"><i class=" fa fa-arrow-right"></i></a></td>
                    <td> {{$subcat->category->title}}</td>
                    <td> {{$subcat->title}}</td>
                    <td><a href="{{route('delete.subcategory',[$subcat->id])}}" class="btn btn-danger btn-sm"><i class=" fa fa-trash"></i></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1">
        <div class="text-center">
            <span>{{$subcats->links()}}</span>
        </div>
    </div>
    <div class="col-md-10 col-sm-10 col-xs-10 col-md-offset-1 col-sm-offset-1 col-xs-offset-1 footer-settings">
        <a href="{{route('create.subcategory')}}" class="btn btn-success pull-right"><i class="fa fa-plus"></i></a>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            $('#mytable').tablesorter();
        });
    </script>
@endsection
