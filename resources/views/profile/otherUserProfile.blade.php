<?php

use app\Models\User;
use App\Models\Follow;
use App\Models\Like;


$test = $first->user_id;
$userId = auth()->user()->id;
$userPostCount = User::where('id', $test)->withCount('posts')->first();
$count = Follow::where('followed_id', $test)->count();
$count2 = Follow::where('follower_id', $test)->count();
$userFollows = Follow::where('follower_id', $userId)->where('followed_id', $test)->first();

?>
<x-app-layout>
    <x-guest-layout>

        <main class="bg-gray-50 bg-opacity-25 w-5/6">

            <div class="mb-8">

                <header class="flex flex-wrap items-center justify-center p-4 md:py-8">
                    <style>
                        .pb-full {
                            padding-bottom: 100%;
                        }

                        .heart:hover {
                            /* Scale up the heart */
                            transform: scale(1.5);
                            /* Change the background color to a lighter red */
                        }

                        #myTest:hover {
                            fill: red;
                            stroke:none;

                        }

                        .bioclass {
                            color: #8E8E8E;
                        }

                        /* hide search icon on search focus */
                        .search-bar:focus+.fa-search {
                            display: none;
                        }

                        @media screen and (min-width: 768px) {
                            .post:hover .overlay {
                                display: block;
                            }
                        }
                    </style>
                    @if (session('message'))
                    <div class="alert alert-success">
                        <script>
                            alert("Already liked")
                        </script>
                    </div>
                    @endif
                    <div class="md:mr-10">
                        <!-- profile image -->
                        <img class="w-20 h-20 md:w-40 md:h-40 object-cover rounded-full
                     border-2 border-pink-600 p-1" src="{{$userPostCount->img}}" alt="profile">
                    </div>

                    <!-- profile meta -->
                    <div class="w-8/12 md:w-4/12 ml-4">
                        <div class="md:flex md:flex-wrap md:items-center mb-4">
                            <h2 class="text-3xl inline-block font-light md:mr-2 mb-2 sm:mb-0">
                                {{$userPostCount->name}}

                            </h2>

                            <!-- badge -->
                            <span class="inline-block fas fa-certificate fa-lg text-blue-500 
                               relative mr-6  text-xl transform -translate-y-2" aria-hidden="true">
                                <i class="fas fa-check text-white text-xs absolute inset-x-0
                               ml-1 mt-px"></i>
                            </span>

                            <!-- Edit button -->
                            <form method="post" action="{{route('allposts.follow')}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                {{ csrf_field()}}
                                <input type="hidden" name="followz" value="{{ $userPostCount->id }}" />

                                <button class="bg-blue-500 px-2 py-1 
                        text-white font-semibold text-sm rounded block text-center 
                        sm:inline-block block hover:bg-blue-800" type="submit" <?php if ($userFollows != null) {
                                                                                    echo 'style="display: none;"';
                                                                                } ?>>Follow</button>
                            </form>

                            <form method="post" action="{{route('allposts.unfollow')}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                {{ csrf_field()}}
                                <input type="hidden" name="followed" value="{{ $userPostCount->id }}" />
                                <button class="bg-blue-500 px-2 py-1 
                        text-white font-semibold text-sm rounded block text-center 
                        sm:inline-block block hover:bg-blue-800" <?php if ($userFollows == null) {
                                                                        echo 'style="display: none;"';
                                                                    } ?>>Unfollow</button>
                            </form>
                        </div>

                        <!-- post, following, followers list for medium screens -->
                        <ul class="hidden md:flex space-x-8 mb-4">
                            <li>
                                <span class="font-semibold">{{$userPostCount->posts_count}}</span>
                                posts
                            </li>
                            <li>
                                <form method="get" action="{{route('followers.viewfollowers')}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                    <input type="hidden" name="user_id" value="{{ $userPostCount->id }}" />
                                    <input type="hidden" name="user" value="{{ $first->user_id }}" />
                                    <span class="font-semibold">{{$count}}</span> <button type="submit">followers</button>
                                </form>
                            </li>
                            <li>
                                <form method="get" action="{{route('followed.viewFollowedBy')}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                    <input type="hidden" name="user_id" value="{{ $userPostCount->id }}" />
                                    <input type="hidden" name="user" value="{{ $first->user_id }}" />

                                    <span class="font-semibold">{{$count2}}</span> <button type="submit">following</button>
                                </form>
                        </ul>

                        <!-- user meta form medium screens -->
                        <div class="hidden md:block">
                            <h1 class="font-semibold">{{$userPostCount->username}}</h1>
                            <span class="bioclass">{{$userPostCount->website}}</span>
                            <p>{{$userPostCount->bio}}</p>
                        </div>

                </header>

                <!-- posts -->
                <div class="px-px md:px-3">

                    <!-- user following for mobile only -->
                    <ul class="flex md:hidden justify-around space-x-8 border-t 
                text-center p-2 text-gray-600 leading-snug text-sm">
                        <li>
                            <span class="font-semibold text-gray-800 block">{{$userPostCount->posts_count}}</span>
                            posts
                        </li>
                        <!-- 
          <li>
            <span class="font-semibold text-gray-800 block">50.5k</span>
            followers
          </li>
          <li>
            <span class="font-semibold text-gray-800 block">10</span>
            following
          </li> -->
                    </ul>
                    <br>
                    <br>
                    <!-- insta freatures -->
                    <ul class="flex items-center justify-around md:justify-center space-x-12  
                    uppercase tracking-widest font-semibold text-xs text-gray-600
                    border-t">
                        <!-- posts tab is active -->
                        <li class="md:border-t md:border-gray-700 md:-mt-px md:text-gray-700">
                            <a class="inline-block p-3" href="#">
                                <i class="fas fa-th-large text-xl md:text-xs"></i>
                                <span class="hidden md:inline">posts</span>
                            </a>
                        </li>
                    </ul>
                    <!-- flexbox grid -->
                    <div class="flex flex-wrap justify-center -mx-px md:-mx-3">

                        <!-- column -->
                        <!-- post 1-->
                        @foreach ($posts as $post)
                        <?php
                        $postid = $post->id;
                        $likes = Like::where('post_id', $postid)->count();
                        ?>

                        <div class="w-96 md:w-80 m-4">
                            <div class="rounded-2xl shadow-xl h-fit bg-white text-gray-700">
                                <div class="w-fit rounded overflow-hidden shadow-none">
                                    <header class="flex flex-start">
                                        <div>
                                            <a href="#" class="cursor-pointer m-4 flex items-center text-sm outline-none focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">

                                                <img src="{{$userPostCount->img}}" class="h-9 w-9 rounded-full object-cover" alt="usuario" />
                                                <div>
                                                    <p class="block ml-2 text-sm font-bold">{{$userPostCount->name}}</p>
                                                    <span class="block ml-2 text-xs text-gray-600">Published on {{$post->created_at->format('jS \of F Y')}} at {{$post->created_at->format('h:i A')}}</span>

                                                </div>
                                            </a>
                                        </div>

                                    </header>
                                    <!-- inside card -->

                                    <div class="w-fit rounded overflow-hidden shadow-none">
                                        <header class="flex flex-start">
                                            <div>

                                            </div>
                                        </header>
                                        <img class="h-96 md:h-80 object-cover max-w-full min-w-full" src="{{ $post->img_url }}" alt="post">

                                        <div class="px-6 pt-4">
                                            <div>
                                                <div class="flex items-center">
                                                    <span class="mb-2 mr-2 inline-flex items-center cursor-pointer">
                                                        <form method="post" action="{{route('dashboard.likePost')}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                                            {{ csrf_field()}}
                                                            <input type="hidden" name="post_id" value="{{ $post->id }}" />

                                                            <button type="submit"> <svg class="heart text-gray-700 mr-1 inline-block h-7 w-7 " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" id="myTest"d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                                                </svg>

                                                            </button>
                                                            {{$likes}}


                                                        </form>
                                                    </span>

                                                </div>
                                            </div>

                                            <div class="mb-6">
                                                <div class="text-sm flex flex-start items-center">

                                                    <p class="font-bold mt-1">
                                                        <a class="cursor-pointer">{{$userPostCount->name}}:</a>
                                                        <span class="text-gray-500 font-medium ml-1">
                                                            {{$post->description}}


                                                        </span>
                                                    </p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @endforeach
                    </div>
                </div>
        </main>
    </x-guest-layout>
</x-app-layout>