@php use Illuminate\Support\Str; @endphp
<div class="flex items-center justify-center gap-4 overflow-hidden">
    @foreach($products as $product)
        <div class="flex-shrink-0">
            @include('user.partials.product_card', ['product' => $product])
        </div>
    @endforeach
</div>