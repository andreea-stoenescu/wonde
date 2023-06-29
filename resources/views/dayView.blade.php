@extends('root')

@section('title', 'DayView')

@section('content')
    <div class='card'>
        <div class='card-header'>
          <h1>{{ $employee->legal_forename }} {{ $employee->legal_surname }} - {{ $date->format('d-m-Y (D)') }}</h1>
        </div>
        <div class='card-body'>
            @foreach ($lessons as $lesson)
              <div class='card card-body'>
                <div>Internal ID: {{ $lesson->class->id }}</div>
                <div>Class name: {{ $lesson->class->name }}</div>
                <div>Start at: {{ $lesson->start_at->format('H:i') }}</div>
                <div>Room ID: {{ $lesson->class->wonde_room_id }}</div>
                <div>Description: {{ $lesson->class->description }}</div>
                <div>
                  <h3>Students</h3>
                  <table>
                    @foreach ($lesson->class->students as $student)
                      <tr>
                        <td>{{ $student->forename }} {{ $student->surname }}</td>
                      </tr>
                    @endforeach
                  </table>
                </div>
              </div>
            @endforeach
        </div>
    </div>
@endsection