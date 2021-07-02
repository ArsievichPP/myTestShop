@extends('layouts/layout')

@section('header')
    @include('components/header')
@endsection

@section('navigation')
    @include('components/navigation')
@endsection

@section('content')
    @include('components/cart')
    @include('components/checkout')
@endsection
