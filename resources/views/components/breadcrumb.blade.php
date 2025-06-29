@props(['items' => []])

<nav class="flex" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <li class="inline-flex items-center">
            <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600">
                <i class="fas fa-home mr-2"></i>
                Panel de Control
            </a>
        </li>
        
        @foreach($items as $item)
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                    @if(isset($item['url']) && !$loop->last)
                        <a href="{{ $item['url'] }}" class="text-sm font-medium text-gray-700 hover:text-blue-600">
                            {{ $item['label'] }}
                        </a>
                    @else
                        <span class="text-sm font-medium text-gray-500">
                            {{ $item['label'] }}
                        </span>
                    @endif
                </div>
            </li>
        @endforeach
    </ol>
</nav> 