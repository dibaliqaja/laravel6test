@extends('layout_cms.home')
@section('title_page','Add Student')
@section('content')

    <form action="{{ route('students.store') }}" method="post">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}">

            @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="age">Age</label>
            <input type="number" min="1" max="100" class="form-control @error('age') is-invalid @enderror" name="age" value="{{ old('age') }}">

            @error('age')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="tel" class="form-control @error('phone_number') is-invalid @enderror" name="phone_number" value="{{ old('phone_number') }}">

            @error('phone_number')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}">

            @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <label for="major_id">Major</label>
            <select class="form-control select2 @error('major_id') is-invalid @enderror" name="major_id">
                @foreach ($majors as $major)
                    <option value="{{ $major->id }}">{{ $major->title ." - ". $major->major }}</option>
                @endforeach
            </select>

            @error('major_id')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
        </div>
        <div class="form-group">
            <button class="btn btn-primary">Add</button>
            <a href="{{ route('students.index') }}" class="btn btn-danger">Back</a>
        </div>
    </form>

@endsection
