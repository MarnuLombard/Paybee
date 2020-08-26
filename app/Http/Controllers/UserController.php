<?php

namespace PayBee\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use PayBee\Models\Token;
use PayBee\Repositories\CurrencyRepository;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     * @throws \ErrorException
     */
    public function edit()
    {
        $user = \Auth::user();
        $token = Token::forUser($user);
        $currencies = app(CurrencyRepository::class)->getCurrencies();

        return view('users.edit', compact('user', 'token', 'currencies'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     * @throws ValidationException
     */
    public function update(Request $request)
    {
        $currencies = app(CurrencyRepository::class)->getCurrencies();
        $user = \Auth::user();

        $this->validate($request, [
            'name' => 'required|min:3',
            'email' => "required|email|unique:users,email,{$user->id}",
            'currency' => 'required|in:'.implode(',', array_keys($currencies))
        ]);

        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'default_currency' => $request->get('currency'),
        ]);

        return redirect()->route('users.edit')->with(['message' => 'Updated successfully.']);
    }
}
