<?php

namespace App\Http\Controllers\ProfileUser;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth']);
    }

    public function index()
    {
        return view('admin.users_manipulation.user_profile');
    }
}