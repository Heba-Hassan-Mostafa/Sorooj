<?php

namespace App\Http\Controllers\DashboardWeb\V1\Courses;

use App\Enum\CategoryTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Web\Courses\CourseRequest;
use App\Models\Category;
use App\Models\Course;
use App\Repositories\Contracts\CourseContract;
use App\Repositories\Contracts\SubscriptionContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class CourseSubscriptionController extends Controller
{
    protected SubscriptionContract $repository;

    public function __construct(SubscriptionContract $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subscriptions = $this->repository->all();

        return view('admin.courses.subscriptions.index', compact('subscriptions'));
    }

}

