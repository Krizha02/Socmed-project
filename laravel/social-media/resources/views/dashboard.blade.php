<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            @if(Auth::user()->profile && Auth::user()->profile->profile_picture)
                <!-- Profile Picture -->
                <img src="{{ Storage::url('public/profile_picture/' . Auth::user()->profile->profile_picture) }}" alt="Profile Picture" class="w-20 h-20 rounded-full">
            @else
                <!-- Default Profile Picture (if user hasn't uploaded one) -->
                <img src="{{ asset('images/default-profile.png') }}" alt="Default Profile Picture" class="w-12 h-12 rounded-full">
            @endif
            <!-- User's Name -->
            <div>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ Auth::user()->name }}
                </h2>
            </div>
        </div>

        <!-- Button to go to post creation page -->
        <div class="flex justify-content-center mb-4">
            <i class="fas fa-edit mr-2"></i>
            <a href="{{ url('posts/index.html') }}" class="bg-transparent border py-2 px-4 rounded-full hover:bg-blue-500 hover:text-white transition duration-300 inline-block">
                <i class="fas fa-edit mr-2"></i>
                <span class="text-lg">What's on your mind?</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="font-semibold text-lg mt-6">Your Feed</h3>
                    <!-- Display the posts here -->
                    @if ($posts->isEmpty())
                        <p class="text-gray-600">No posts yet.</p>
                    @else
                        <ul class="space-y-4 mt-4">
                            @foreach ($posts as $post)
                                <li class="bg-white shadow-md rounded-lg p-4">
                                    <p class="text-gray-800">{{ $post->content }}</p>
                                    <small class="text-gray-500">By {{ $post->user->name }} on {{ $post->created_at->format('d-m-Y H:i') }}</small>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
