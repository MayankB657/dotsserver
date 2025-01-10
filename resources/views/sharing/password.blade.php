<!DOCTYPE html>
@extends('layouts.common')
@section('title', 'Dashboard')
@section('styles')
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'dashbord.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'filemanager.css') }}">
    <link rel="stylesheet" href="{{ asset($constants['CSSFILEPATH'] . 'semantic.min.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
@endsection
@section('content')
    <div class="container mt-10">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Password</div>
            </div>
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('verifyPassword', $id) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Enter Password" name="password">
                    </div>
                    <div class="row text-end">
                        <div class="form-group">
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
