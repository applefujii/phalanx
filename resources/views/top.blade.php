@extends('layouts.app')
@section('content')

<u class="sp"><center>私たちがサポートします</u><br><br><br><br>
どの事業所が自分に合っているのか判定！<br><br>

<p>
  <a class="btn btn-success" role="button" href="{{ route('aptitude_question_form.index') }}">適性診断</a>
</p>
<p>
<a class="btn btn-primary" role="button" href="{{ route('trial_application_form.index') }}">体験・見学申し込み</a>
</p>
</center>

@endsection