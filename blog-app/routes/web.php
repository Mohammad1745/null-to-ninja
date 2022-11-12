<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

require base_path('routes\web\home.php');
require base_path('routes\web\auth.php');
require base_path('routes\web\post.php');
require base_path('routes\web\comment.php');

