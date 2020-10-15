<div class="col-md-8 col-lg-offset-2 col-md-offset-2" style="background: white">
    <h3 style="margin-bottom: 30px;"> <strong> Result is: </strong> {{$result}} </h3>
    <h3 style="margin-bottom: 30px;"> <strong> Correct Answers: </strong> {{$correct_answers}} </h3>
    <h3 style="margin-bottom: 30px;"> <strong> Wrong Answers: </strong> {{$wrong_answers}} </h3>
    <h3 style="margin-bottom: 30px;"> <strong> Result In Persentage: </strong> {{$persentage}}<strong> % </strong> </h3>
    <a href="{{url('/home')}}" class="btn btn-primary" style="margin-bottom: 30px;"> Start Quiz Again </a>
    <a href="{{route('user.dashboard')}}" class="btn btn-warning" style="margin-bottom: 30px;"> Dashboard </a>
</div>
