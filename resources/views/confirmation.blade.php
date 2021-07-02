@extends('layouts/layout')

@section('header')
    @include('components/header')
@endsection

@section('content')
    <div class="container confirmation borders border-top">
        <h3>Спасибо за покупку!</h3>
        <h6> Наш консультант свяжется с вами в ближайшее время </h6>
        <a href="{{route('main')}}" class="btn">На главную!</a>
    </div>
@endsection
