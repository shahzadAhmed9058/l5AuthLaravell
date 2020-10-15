@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">User Dashboard</div>

                    <div class="panel-body">
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form action="{{route('user.quiz')}}" method="post">
                            {{csrf_field()}}

                            <div class="form-group{{ $errors->has('subcategory_id') ? ' has-error' : '' }}"> {{-- quiz subcategory --}}
                                <label for=""> SubCategory </label>
                                <select name="subcategory_id" class="form-control">
                                    <option value="default"> Select SubCategory</option>
                                    @foreach($subCats as $subCat)
                                        <option value="{{$subCat->id}}"> {{$subCat->title}} </option>
                                    @endforeach
                                </select>
                                @if($errors->has('subcategory_id'))
                                    <span class="help-block">
                                        <strong>{{$errors->first('subcategory_id')}}</strong>
                                    </span>
                                @endif
                            </div>
                            <button class="btn btn-primary"> Start Quiz</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function () {

        })
    </script>
@endsection
