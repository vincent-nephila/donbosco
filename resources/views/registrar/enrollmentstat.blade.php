@extends('app')

@section('content')


<div class="container">
  <h2>ENROLLMENT STATISTICS</h2>
  <p>Enrollment Period: </p>
   <table class="table">
    <thead>
      <tr>
        <th>Department</th>  
        <th>Level</th>
        <th>Course</th>
        <th>Strand</th>
        <th>No. of Enrollees</th>
      </tr>
    </thead>
    <tbody>
     @foreach($stats as $stat)
     <tr><td>{{$stat->department}}</td><td>{{$stat->level}} </td><td>{{$stat->course}}</td><td>{{$stat->strand}}</td><td>{{$stat->count}}</td></tr>
     @endforeach
    </tbody>
  </table>
</div>

</table>

@endsection