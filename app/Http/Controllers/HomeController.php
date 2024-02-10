<?php

namespace App\Http\Controllers;

use App\Classes\Registry;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $registry = new Registry();
        $registry->name = 'Yusuf';
        $registry->skills = ['Laravel', 'MySQL', 'PHP', 'JavaScript', 'Golang', 'Microservice Architecture'];
        $registry->books = ['One', 'Two', 'Three', 'Four', 'Five'];
        $data =  ['frameworkVersion' => app()->version(), 'name' => $registry->name, 'skills' => $registry->skills, 'books' => $registry->getArray('books')];

        return view('home', $data);
    }
}
