<?php

use app\Models\User;
use App\Models\Comment;
use App\Models\Like;

use PhpParser\Node\Stmt\Foreach_;

?>
<x-guest-layout>
    <main class="w-5/6 flex flex-row justify-center flex-wrap">
        @foreach ($posts as $post)
        <?php
        $postid = $post->id;
        $likes = Like::where('post_id', $postid)->count();

        ?>

        <div>

            <div class="mb-8">
                <!-- <div class="rounded-2xl shadow-xl bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300"> -->
                <div class=" w-96 md:w-80 m-4 rounded-2xl shadow-xl h-fit bg-white text-gray-700">
                    <!-- inside card -->
                    <div class="w-fit rounded overflow-hidden shadow-none">


                        <header class="flex flex-start">
                            <div>

                                <?php
                                if ($post->user->id === auth()->user()->id) {
                                    $route = "/profilePage";
                                } else {
                                    $route = "user/" . strval($post->user->id);
                                }
                                ?>
                                <a href={{$route}} class="cursor-pointer m-4 flex items-center text-sm outline-none focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                    <?php
                                    $userId = $post->user->id;
                                    $user = User::where('id', $userId);
                                    $userImg = User::where('id', $userId)->withCount('posts')->first();

                                    ?>
                                    <img src="{{$userImg->img}}" class="h-9 w-9 rounded-full object-cover" alt="usuario" />
                                    <div>
                                        <p class="block ml-2 text-lg font-bold">{{$post->user->name}}</p>
                                        <span class="block ml-2 text-xs text-gray-600">Published on {{$post->created_at->format('jS \of F Y')}} at {{$post->created_at->format('h:i A')}}</span>
                                    </div>
                                </a>
                            </div>

                        </header>

                        <!-- clickable picture -->
                        <a class="button" href="#{{ $post->id }}">
                            <img class="h-96 md:h-80 object-cover" src="{{ $post->img_url }}" alt="post">
                        </a>

                        <!-- Modal when clicked -->
                        <div id="{{ $post->id }}" class="overlay">
                            <div class="popup">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-body">
                                            <div class="firstFlex">
                                                <img class="w-half max-w-half min-w-half" src="{{ $post->img_url }}" alt="post">
                                            </div>
                                            <div class="commentSection">

                                                <div class="header">
                                                    <img src="{{$userImg->img}}" class="h-6 w-6 rounded-full object-cover float-left mr-2" alt="usuario" />

                                                    <p class="text-md mt-1 font-black text-gray-700">{{$post->user->name}}</p>
                                                    <p class="text-md mt-1 text-gray-500 font-medium ">{{$post->description}}</p>

                                                </div>
                                                <?php
                                                //var_dump($post->comments()->first());
                                                $postCo = Comment::where('post_id', $post->id)->take(5)->get();
                                                foreach ($postCo as $p) :
                                                    $userCo = User::where('id', $p->user_id)->first();
                                                ?>

                                                    <p class="description mb-10 mt-4">
                                                        <img src="{{$userCo->img}}" class="h-6 w-6 rounded-full mr-2 object-cover float-left  " alt="usuario" />
                                                        <span> {{$userCo->name}} </span> {{$p->body}}
                                                    </p>
                                                    <br>

                                                <?php
                                                endforeach;
                                                ?>

                                                <form class="w-full max-w-xl bg-white rounded-lg px-4 pt-2" method="post" action="{{route('addComment.store',$post->id)}}" enctype="multipart/form-data" accept-charset="UTF-8">
                                                    {{ csrf_field()}}
                                                    <div class="flex flex-wrap -mx-3 mb-6">
                                                        <div class="w-full md:w-full px-3 mb-2 mt-2">
                                                            <input class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5" name="body" id="body" placeholder='Add Comment'></input>
                                                        </div>
                                                        <div class="w-full md:w-full flex items-start md:w-full px-3">
                                                            <div class="flex items-start w-1/2 text-gray-700 px-2 mr-auto">
                                                            </div>

                                                            <button type='submit' class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Post</button>

                                                </form>
                                            </div>


                                            <?php
                                            if ($post->user->id === auth()->user()->id) {
                                                $route = "/profilePage";
                                            } else {
                                                $route = "/user/" . strval($post->user->id);
                                            }
                                            ?>
                                            <a href={{$route}} class="cursor-pointer m-4 flex items-center text-sm outline-none focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">
                                                <?php
                                                $userId = $post->user->id;
                                                $user = User::where('id', $userId);
                                                $userImg = User::where('id', $userId)->withCount('posts')->first();

                                                ?>

                                            </a>
                                        </div>
                                    </div>


                                    <div class="modal-footer">
                                        <a class="close btn btn-default" href="#">x</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end of Modal -->

            <div class="px-6 pt-4">
                <div>

                    <div class="flex items-center">
                        <form method="post" action="{{route('dashboard.likePost')}}" enctype="multipart/form-data" accept-charset="UTF-8">
                            {{ csrf_field()}}
                            <button type="submit"> <svg class="heart text-gray-700 mr-1 inline-block h-7 w-7  " xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" id="myTest" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                                </svg></button>
                            <input type="hidden" name="post_id" value="{{ $post->id }}" />
                            {{$likes}}

                        </form>

                    </div>
                </div>

                <div class="mb-6">
                    <div class="text-sm flex flex-start items-center">

                        <p class="font-bold mt-1 mb-6">
                            <a class="cursor-pointer">{{$post->user->name}}:</a>
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
        @endforeach
</x-guest-layout>

<style>
    .header {
        padding: 15px;
        border-bottom: 1px solid #e5e5e5;
    }

    .modal-dialog {
        width: 900px;
        margin: 30px auto;
        height: 550px;

    }

    .modal-content {
        position: relative;
        background-color: #fff;
        -webkit-background-clip: padding-box;
        background-clip: padding-box;
        border: 1px solid #999;
        border: 1px solid rgba(0, 0, 0, .2);
        border-radius: 6px;
        outline: 0;
        -webkit-box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
        box-shadow: 0 3px 9px rgba(0, 0, 0, .5);
    }
    #myTest:hover{
    stroke:none;
    fill:red;
  }

    /* Add the hover effect to the heart */
    .heart:hover {
        /* Scale up the heart */
        transform: scale(1.5);
        /* Change the background color to a lighter red */
    }

    .modal-body {
        height: 600px;
        display: flex;
        flex-direction: row;
        flex-wrap: nowrap;
        justify-content: center;
        align-items: stretch;
        align-content: stretch;
    }

    .modal-body img {
        height: 100%;
    }




    .description {
        margin-left: 15px;
        font-size: 14px;
        line-height: 20px;
        margin-bottom: 10px;
    }

    .description span {
        font-weight: bold;
        margin-right: 1px;
    }

    .modal-title {
        margin: 0;
        line-height: 1.42857143;
    }

    .overlay {
        position: fixed;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background: rgba(0, 0, 0, 0.7);
        transition: opacity 500ms;
        visibility: hidden;
        opacity: 0;
    }

    .overlay:target {
        visibility: visible;
        opacity: 1;
    }

    .popup h2 {
        margin-top: 0;
        color: #333;
        font-family: Tahoma, Arial, sans-serif;
    }

    .popup .close {
        position: absolute;
        top: 8px;
        right: 20px;
        transition: all 200ms;
        font-size: 30px;
        font-weight: bold;
        text-decoration: none;
        color: #333;
    }

    .popup .close:hover {
        color: #06D85F;
    }

    .popup .content {
        max-height: 30%;
        overflow: auto;
    }

    @media screen and (max-width: 700px) {
        .box {
            width: 90%;
        }

        .popup {
            width: 70%;
        }
    }
</style>