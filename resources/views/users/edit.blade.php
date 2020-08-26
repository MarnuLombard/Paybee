@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    <form action="{{ route('users.update') }}" method="POST">
                        @method('PATCH')
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{old('name', $user->name)}}" placeholder="Enter name">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="email">Email address</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{old('email', $user->email)}}" placeholder="Enter email">
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="token">Telegram connect token</label>
                            <input type="text" readonly class="form-control-plaintext mb-0" id="token" name="token" value="{{ $token->token }}">
                            <small class="text-muted">
                                Pass this token to the <a href="https://t.me/NewPayBeeBot" target="_blank">@NewPayBeeBot</a> through the <strong>/connect {token}</strong> command
                            </small>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="currency">Default currency</label>
                            <select id="currency" name="currency" class="custom-select">
                                @foreach($currencies as $code => $currency)
                                    <option value="{{$code}}" {{$code === $user->default_currency ? 'selected' : ''}}>
                                        {{ $currency }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
