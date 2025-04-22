@props(['title', 'count', 'color' => 'blue'])

<div class="bg-white shadow-md rounded-2xl p-6 hover:shadow-xl transition">
    <h3 class="text-lg font-semibold text-gray-700">{{ $title }}</h3>
    <p class="text-4xl font-bold text-{{ $color }}-600 mt-2">{{ $count }}</p>
</div>
