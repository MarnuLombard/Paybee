<?php

namespace PayBee\Http\Controllers;

use Illuminate\Http\RedirectResponse;

class IndexController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @return RedirectResponse
     */
    public function __invoke()
    {
        return redirect(route('login'), 301);
    }
}
