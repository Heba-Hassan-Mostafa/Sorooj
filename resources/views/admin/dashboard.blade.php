@extends('admin.layouts.master')
@section('title')
    {{ trans('dashboard.main') }}
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <div class="col-xl-4 mb-4 col-lg-5 col-12">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-7">
                            <div class="card-body text-nowrap">
                                <h5 style="width: fit-content" class="card-title mb-2">{{ trans('dashboard.welcome') }}
                                    {{ auth()->user()->first_name }}! 🎉</h5>
                                <p class="mb-2">
                                    @if (!empty(auth()->user()->getRoleNames()))
                                        @foreach (auth()->user()->getRoleNames() as $role)
                                            @php
                                                // Decode the JSON role name to get the translations
                                                $roleTranslations = json_decode($role, true);
                                                // Fetch the name based on the current locale
                                                $translatedRole = $roleTranslations[Illuminate\Support\Facades\App::getLocale()] ?? $role;
                                            @endphp
                                            <label class="btn btn-sm btn-success pe-none">{{ $translatedRole }}</label>
                                        @endforeach
                                    @endif

                                </p>
                                <a href="{{ route('admin.profile') }}"
                                   class="btn btn-primary waves-effect waves-light">{{ trans('dashboard.sidebar.view_profile') }}</a>
                            </div>
                        </div>
                        <div class="col-5 text-center text-sm-left">
                            <div class="card-body pb-0 px-0 px-md-4">
                                <img src="{{ asset('assets/admin/img/illustrations/card-advance-sale.png') }}" height="140"
                                     alt="view sales">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php
            $members = App\Models\ManagementMember::latest()->get();
            ?>
                <!-- Website Analytics -->
            <div class="col-lg-7 mb-4">
                <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg"
                     id="swiper-with-pagination-cards">
                    <div class="swiper-wrapper">
                        @foreach ($members as $member)
                            <div class="swiper-slide">
                                <div class="row">
                                    <div class="col-12">
                                        <h5 class="text-white mb-0 mt-2 mb-2">{{ trans('dashboard.sidebar.management-members') }}</h5>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-7 col-md-9 col-12 order-2 order-md-1">
                                            <h6 class="text-white mt-0 mt-md-3 mb-3">{{ trans('dashboard.members.name') }}:
                                                {{ $member->name }}</h6>
                                            <div class="row">
                                                <div class="col-6">
                                                    <ul class="list-unstyled mb-0">
                                                        <li class="d-flex mb-4 align-items-center">
                                                            <p class="mb-0">{{ trans('dashboard.members.position') }}:
                                                                {{ $member->position }}</p>
                                                        </li>

                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-3 col-12 order-1 order-md-2 my-4 my-md-0 text-center">
                                            @if (!empty($member->avatar))
                                                <img src="{{ asset($member->avatar) }}"
                                                     alt="Website Analytics" width="150" height="150px"
                                                     class="card-website-analytics-img rounded-circle" />
                                            @else
                                                    <img src="{{ asset('assets/avatar.png') }}" alt=""
                                                         width="150" height="150px" class="card-website-analytics-img">
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach


                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <!--/ Website Analytics -->

            {{-- Statistics --}}
            <div class="col-12 mb-4">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between mb-3">
                            <h5 class="card-title mb-0">{{ trans('dashboard.sidebar.statistics') }}</h5>
                            <small class="text-muted">{{ trans('dashboard.sidebar.last_updated') }}</small>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row gy-3">
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-file-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ App\Models\User::whereType(\App\Enum\UserTypeEnum::ADMIN)->count() }}</h5>
                                        <small>{{ trans('dashboard.sidebar.admins') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-file-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ App\Models\User::whereType(\App\Enum\UserTypeEnum::CLIENT)->count() }}</h5>
                                        <small>{{ trans('dashboard.sidebar.clients') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-file-dollar ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ App\Models\Subscriber::count() }}</h5>
                                        <small>{{ trans('dashboard.sidebar.subscribers') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">

                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-primary me-3 p-2">
                                        <i class="ti ti-medical-cross ti-sm"></i>
                                    </div>

                                    <div class="card-info">
                                        <h5 class="mb-0">{{ App\Models\Book::count() }}</h5>
                                        <small>{{ trans('dashboard.sidebar.books') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-info me-3 p-2">
                                        <i class="ti ti-brand-youtube ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ App\Models\Course::count() }}</h5>
                                        <small>{{ trans('dashboard.sidebar.courses') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-danger me-3 p-2">
                                        <i class="ti ti-highlight ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">{{ App\Models\Blog::count() }}</h5>
                                        <small>{{ trans('dashboard.sidebar.blogs') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-photo ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">
                                            {{ App\Models\Video::where('videoable_type', 'Video')->count() }}
                                        </h5>
                                        <small>{{ trans('dashboard.sidebar.videos') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-photo ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">
                                            {{ App\Models\Audio::where('audioable_type', 'Audio')->count() }}
                                        </h5>
                                        <small>{{ trans('dashboard.sidebar.audios') }}</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2 col-6">
                                <div class="d-flex align-items-center">
                                    <div class="badge rounded-pill bg-label-success me-3 p-2">
                                        <i class="ti ti-photo ti-sm"></i>
                                    </div>
                                    <div class="card-info">
                                        <h5 class="mb-0">
                                            {{ App\Models\FatwaQuestion::count() }}
                                        </h5>
                                        <small>{{ trans('dashboard.sidebar.questions') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {{-- Statistics --}}
                @php
                $courses = \App\Models\Course::orderBy('id', 'desc')->limit(3)->get();
                $books = \App\Models\Book::orderBy('id', 'desc')->limit(3)->get();
                $blogs = \App\Models\Blog::orderBy('id', 'desc')->limit(3)->get();
                @endphp
            <div class="col-lg-12">
                <small class="text-light fw-medium">{{trans('dashboard.sidebar.last_updated')}}</small>
                <div class="demo-inline-spacing mt-3">
                    <div class="list-group list-group-horizontal-md text-md-center">
                        <a
                            class="list-group-item list-group-item-action active"
                            id="home-list-item"
                            data-bs-toggle="list"
                            href="#horizontal-home"
                        >{{trans('dashboard.sidebar.courses')}}</a>
                        <a
                            class="list-group-item list-group-item-action"
                            id="profile-list-item"
                            data-bs-toggle="list"
                            href="#horizontal-profile"
                        >{{trans('dashboard.sidebar.books')}}</a>
                        <a
                            class="list-group-item list-group-item-action"
                            id="messages-list-item"
                            data-bs-toggle="list"
                            href="#horizontal-messages"
                        >{{trans('dashboard.sidebar.blogs')}}</a>
                    </div>
                    <div class="tab-content px-0 mt-0">
                        <div class="tab-pane fade show active" id="horizontal-home">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('dashboard.courses.course_image') }}</th>
                                    <th>{{ trans('dashboard.courses.course_name') }}</th>
                                    <th>{{ trans('dashboard.courses.course_category') }}</th>
                                    <th>{{ trans('dashboard.courses.author_name') }}</th>
                                    <th>{{ trans('dashboard.courses.publish_date') }}</th>
                                    <th>{{ trans('dashboard.status') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($courses as $course)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (!empty($course->image))
                                                <img src="{{ asset($course->image) }}" style="width:50px;height:50px;"  alt=""/>
                                            @else
                                                <img src="{{ asset('assets/admin/images/courses.webp') }}" style="width:50px;height:50px;"  alt=""/>
                                            @endif
                                        </td>
                                        <td>{{ $course->course_name }}</td>
                                        <td>{{ $course->category?->name }}</td>
                                        <td>{{ $course->author_name }}</td>
                                        <td>{{ $course->publish_date }}</td>
                                        <td>{{$course->status()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="tab-pane fade" id="horizontal-profile">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('dashboard.books.book_image') }}</th>
                                    <th>{{ trans('dashboard.books.book_name') }}</th>
                                    <th>{{ trans('dashboard.books.book_category') }}</th>
                                    <th>{{ trans('dashboard.books.author_name') }}</th>
                                    <th>{{ trans('dashboard.books.publish_date') }}</th>
                                    <th>{{ trans('dashboard.status') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($books as $book)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (!empty($book->image))
                                                <img src="{{ asset($book->image) }}" style="width:50px;height:50px;"  alt=""/>
                                            @else
                                                <img src="{{ asset('assets/admin/images/books.webp') }}" style="width:50px;height:50px;"  alt=""/>
                                            @endif

                                        </td>
                                        <td>{{ $book->book_name }}</td>
                                        <td>{{ $book->category?->name }}</td>
                                        <td>{{ $book->author_name }}</td>
                                        <td>{{ $book->publish_date }}</td>
                                        <td>{{$book->status()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                        <div class="tab-pane fade" id="horizontal-messages">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ trans('dashboard.blogs.blog_image') }}</th>
                                    <th>{{ trans('dashboard.blogs.blog_name') }}</th>
                                    <th>{{ trans('dashboard.blogs.blog_category') }}</th>
                                    <th>{{ trans('dashboard.blogs.author_name') }}</th>
                                    <th>{{ trans('dashboard.blogs.publish_date') }}</th>
                                    <th>{{ trans('dashboard.status') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($blogs as $blog)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if (!empty($blog->image))
                                                <img src="{{ asset($blog->image) }}" style="width:50px;height:50px;"  alt=""/>
                                            @else
                                                <img src="{{ asset('assets/admin/images/blogs.webp') }}" style="width:50px;height:50px;"  alt=""/>
                                            @endif

                                        </td>
                                        <td>{{ $blog->blog_name }}</td>
                                        <td>{{ $blog->category?->name }}</td>
                                        <td>{{ $blog->author_name }}</td>
                                        <td>{{ $blog->publish_date }}</td>

                                        <td>{{$blog->status()}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- mostViewed--}}
            <div class="col-md-6  mb-4">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="card-title m-0 me-2">
                            <h5 class="m-0 me-2">{{__('Most Viewed')}}</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            @foreach($mostViewed as $view)
                            <li class="d-flex mb-4 pb-1">
                                <div class="me-3">
                                    @if($view->image)
                                    <img src="{{$view->image}}" alt="img" class="rounded" width="46">
                                    @else
                                    <img src="{{asset('assets/admin/images/audios.webp')}}" alt="img" width="46">
                                    @endif
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{\Illuminate\Support\Str::limit($view->name, 30)}}</h6>
                                        <small class="text-muted d-block">{{__($view->type)}}</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0 fw-medium">{{$view->view_count}}</p>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
             </div>
        {{-- mostFavorite--}}
        <div class="col-md-6  mb-4">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between">
                    <div class="card-title m-0 me-2">
                        <h5 class="m-0 me-2">{{__('Most Favorite')}}</h5>
                    </div>
                </div>
                <div class="card-body">
                    <ul class="p-0 m-0">
                        @foreach ($result as $item)
                            <li class="d-flex mb-4 pb-1">
                                <div class="me-3">
                                        <img src="{{$item['image']}}" alt="img" class="rounded" width="46">
                                </div>
                                <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                    <div class="me-2">
                                        <h6 class="mb-0">{{$item['name']}}</h6>
                                        <small class="text-muted d-block">{{__($item['type'])}}</small>
                                    </div>
                                    <div class="user-progress d-flex align-items-center gap-1">
                                        <p class="mb-0 fw-medium">{{$item['total'] }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>

            <?php
            $contacts = App\Models\Contact::latest()
                ->limit(5)
                ->get();
            ?>
            {{-- contact-us --}}
            <div class="col-lg-8 mb-4 mb-lg-0">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <h5 class="card-title m-0 me-2">{{ trans('dashboard.sidebar.contacts') }}</h5>

                    </div>
                    <div class="table-responsive">
                        <table class="table table-borderless border-top">
                            <thead class="border-bottom">
                            <tr>
                                <th>{{ trans('dashboard.admins.name') }}</th>
                                <th>{{ trans('dashboard.admins.email') }}</th>
                                <th>{{ trans('dashboard.admins.mobile') }}</th>
                                <th>{{ trans('dashboard.admins.message') }}</th>
                                <th>{{ trans('dashboard.admins.message_type') }}</th>
                                <th>{{ trans('dashboard.options') }}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($contacts as $contact)
                                <tr>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            {{ $contact->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex flex-column">
                                            <p class="mb-0 fw-medium">{{ $contact->email }}</p>
                                        </div>
                                    </td>
                                    <td><span class="badge bg-label-success">{{ $contact->mobile }}</span></td>
                                    <td>
                                        <p class="mb-0 fw-medium">
                                            {{ \Illuminate\Support\Str::limit($contact->message, 40) }}</p>
                                    </td>
                                    <td>
                                        <p class="mb-0 fw-medium">
                                            {{ __($contact->type) }}</p>
                                    </td>
                                    <td>
                                        <button class="btn btn-warning btn-sm text-white" data-bs-toggle="modal"
                                                data-bs-target="#modalCenter-{{ $contact->id }}">
                                            <i class="fa fa-eye"></i>
                                            <span class="text"></span>
                                        </button>
                                    </td>
                                </tr>
                                <!-- Modal -->
                                @include('admin.contacts.showContactUsModal')
                                <!-- modal -->
                            @empty
                            @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- end contact-us --}}
        </div>
@endsection
