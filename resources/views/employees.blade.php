@extends('root')

@section('title', 'Employees')

@section('content')
    <div class='card'>
        <div class='card-body'>
            <table class='table'>
              
              @foreach ($employees as $employee)
                <tr>
                  <td>
                    <a href='{{ route("employee", $employee->id) }}'>{{ $employee->wonde_id }}</a>
                  </td>
                  <td>{{ $employee->legal_forename }}</td>
                  <td>{{ $employee->legal_surname }}</td>
                </tr>
              @endforeach
            </table>
        </div>
    </div>
@endsection