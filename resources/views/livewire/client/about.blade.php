<div class="min-h-screen bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto">
        <div class="text-center mb-16">
            <h1 class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-purple-400 to-pink-600 mb-4">
                About Us
            </h1>
            <div class="w-24 h-1 bg-gradient-to-r from-purple-500 to-pink-500 mx-auto rounded-full"></div>
        </div>

        <div class="bg-gray-800 rounded-2xl shadow-2xl border border-gray-700 p-8 md:p-12 transform transition hover:scale-[1.01] duration-300">
            @if($settings && $settings->about_us)
                <div class="prose prose-invert max-w-none text-gray-300 leading-relaxed text-lg">
                    {!! nl2br(e($settings->about_us)) !!}
                </div>
            @else
                <div class="text-center text-gray-500 italic">
                    <p>Information about our company will be available soon.</p>
                </div>
            @endif
        </div>

        <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            <div class="p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-lg">
                <div class="text-purple-500 text-4xl mb-4">
                    <i class="fas fa-rocket"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Innovation</h3>
                <p class="text-gray-400">Pushing boundaries with cutting-edge solutions.</p>
            </div>
            <div class="p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-lg">
                <div class="text-pink-500 text-4xl mb-4">
                    <i class="fas fa-heart"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Passion</h3>
                <p class="text-gray-400">Dedicated to delivering the best experience.</p>
            </div>
            <div class="p-6 bg-gray-800 rounded-xl border border-gray-700 shadow-lg">
                <div class="text-blue-500 text-4xl mb-4">
                    <i class="fas fa-shield-alt"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Integrity</h3>
                <p class="text-gray-400">Building trust through transparency.</p>
            </div>
        </div>
    </div>
</div>
