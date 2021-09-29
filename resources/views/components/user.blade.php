<div class="container">
    <h5> Данные пользователя </h5>

    <h6> Имя: </h6>
    <input type="text" name="name" value="{{$user['name']}}">
    <h6> Номер телефона: </h6>
    <input type="tel" name="phone" value="{{$user['phone']}}">
    <h6> Адрес: </h6>
    <input type="text" name="address" value="{{$user['address']}}">
    <h6> email: </h6>
    <input type="email" name="email" value="{{$user['email']}}">
    <button class="btn-success">Сохранить изменения</button>
</div>
