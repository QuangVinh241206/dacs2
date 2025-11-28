@foreach(($reviews ?? collect()) as $review)
    <div class="border-b pb-4">
        <div class="flex items-center mb-2">
            <div class="flex text-yellow-400">
                @for($i = 0; $i < 5; $i++)
                    @if($i < $review->rating)
                        <i class="ri-star-fill"></i>
                    @else
                        <i class="ri-star-line"></i>
                    @endif
                @endfor
            </div>
            <span class="ml-2 text-sm text-gray-500">{{ $review->user->name ?? 'Khách' }} -
                {{ (\Carbon\Carbon::parse($review->created_at))->format('d/m/Y') }}</span>
        </div>
        <p class="text-gray-700">{{ $review->comment }}</p>
    </div>
@endforeach