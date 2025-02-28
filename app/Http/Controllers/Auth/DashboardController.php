<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Category;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the dashboard with statistics.
     *
     * @return \Illuminate\View\View
     */
    public function dashboard()
    {
        // Get counts for various models
        $data = [
            'postsCount' => Post::count(),
            'tagsCount' => Tag::count(),
            'categoriesCount' => Category::count(),
            'usersCount' => User::count(),
        ];

        // Pass the data to the dashboard view
        return view('auth.dashboard', $data);
    }
}
