@extends('root')

@section('title', 'Employees')

@section('content')
    <div class='card'>
        <div class='card-body'>
            <table>
              @foreach ($dates as $date)
                <tr>
                  <td>
                    <a href='{{ route("employee-lessons", ["employee" => $employee->id, "date" => $date->format("d-m-Y")]) }}'>{{ $date->format("d-m-Y (D)") }}</a>
                  </td>
                </tr>
              @endforeach
            </table>
        </div>
    </div>
@endsection