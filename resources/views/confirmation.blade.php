@extends('layouts/layout')

@section('header')
    @include('components/header')
@endsection

@section('content')
    <div class="container confirmation borders border-top">
        <h3>Спасибо за заказ!</h3>
        <h6> Оплатить и оформить его можно <a href="{{route('orders')}}">здесь</a></h6>
        <a href="{{route('main')}}" class="btn">На главную!</a>
    </div>
@endsection
