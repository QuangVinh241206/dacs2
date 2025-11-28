@php use Illuminate\Support\Str; @endphp
<div class="w-64 bg-white border rounded-lg overflow-hidden shadow-sm hover:shadow-md hover:-translate-y-1 transition">
    <a href="{{ route('user.productDetail', $product->slug) }}" class="block">
        <img src="{{ ($product->images->first()) ? (Str::startsWith($product->images->first()->image_url, ['http', '//']) ? $product->images->first()->image_url : asset('storage/' . ltrim($product->images->first()->image_url, '/'))) : asset('images/placeholder.png') }}"
            class="w-full h-40 object-cover">
    </a>
    <div class="p-3">
        <h4 class="text-sm font-medium text-gray-900 leading-snug mb-1">{{ Str::limit($product->name, 40) }}</h4>
        <div class="flex items-center">
            @php $minp = $product->variants->min('price');
            $maxp = $product->variants->max('price'); @endphp
            @if($minp && $maxp && $minp != $maxp)
                <span class="text-base font-bold text-primary">{{ number_format($minp, 0, ',', '.') }}₫</span>
            @else
                <span class="text-base font-bold text-primary">{{ number_format($minp ?: $maxp ?: 0, 0, ',', '.') }}₫</span>
            @endif
            @if($product->discount_percent)
                <span
                    class="ml-2 text-xs text-gray-500 line-through">{{ number_format($product->variants->first()->price ?? 0, 0, ',', '.') }}₫</span>
            @endif
        </div>
    </div>
</div>