@extends('layouts/layout')

@section('header')
    @include('components/header')
@endsection

@section('navigation')
    @include('components/navigation')
    @include('components/breadcrumbs')
@endsection

@section('content')
    @include('components/product')
@endsection
