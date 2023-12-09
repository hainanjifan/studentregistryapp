@extends('layouts.app')

@section('content')
<div class="text-center">
    <form action="{{ route('students.upload') }}" method="post" enctype="multipart/form-data">
        @csrf

        <h2>Insert your file here!</h2>
        <input type="file" name="file" accept=".xlsx, .csv">

        <br>

        <button type="submit" class="btn btn-primary mt-5">Upload File</button>
    </form>
</div>
@endsection