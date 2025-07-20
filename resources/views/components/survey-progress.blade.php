@props(['progress' => 0, 'size' => 'large', 'showText' => true])

@php
    $sizes = [
        'small' => [
            'width' => 'w-16 h-16',
            'radius' => '32',
            'cx' => '32',
            'cy' => '32',
            'strokeWidth' => '4',
            'fontSize' => 'text-sm',
        ],
        'medium' => [
            'width' => 'w-20 h-20',
            'radius' => '38',
            'cx' => '40',
            'cy' => '40',
            'strokeWidth' => '5',
            'fontSize' => 'text-base',
        ],
        'large' => [
            'width' => 'w-32 h-32',
            'radius' => '52',
            'cx' => '64',
            'cy' => '64',
            'strokeWidth' => '8',
            'fontSize' => 'text-2xl',
        ],
    ];

    $currentSize = $sizes[$size] ?? $sizes['large'];
    $circumference = 2 * pi() * $currentSize['radius'];
    $strokeDashoffset = $circumference - ($circumference * $progress) / 100;
@endphp

<div class="relative {{ $currentSize['width'] }}">
    <svg class="w-full h-full transform -rotate-90">
        <defs>
            <linearGradient id="surveyProgressGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                <stop offset="0%" style="stop-color:#667eea;stop-opacity:1" />
                <stop offset="100%" style="stop-color:#764ba2;stop-opacity:1" />
            </linearGradient>
        </defs>
        <circle stroke="#e5e7eb" stroke-width="{{ $currentSize['strokeWidth'] }}" fill="none"
            r="{{ $currentSize['radius'] }}" cx="{{ $currentSize['cx'] }}" cy="{{ $currentSize['cy'] }}" />
        <circle stroke="url(#surveyProgressGradient)" stroke-width="{{ $currentSize['strokeWidth'] }}" fill="none"
            r="{{ $currentSize['radius'] }}" cx="{{ $currentSize['cx'] }}" cy="{{ $currentSize['cy'] }}"
            stroke-dasharray="{{ number_format($circumference, 2) }}"
            stroke-dashoffset="{{ number_format($strokeDashoffset, 2) }}"
            class="transition-all duration-1000 ease-out" />
    </svg>

    @if ($showText)
        <div class="absolute inset-0 flex items-center justify-center">
            <span class="{{ $currentSize['fontSize'] }} font-bold text-gray-800">
                {{ $progress }}%
            </span>
        </div>
    @endif
</div>
