<div class="col-lg-3 col-md-4 col-sm-6">
    <div class="card shadow">
        <div class="card-body text-center">
            <i class="fas {{ $icon }} card-icon"></i>
            <h5 class="card-title">{{ $title }}</h5>
            
            {{-- Mulai Tambahan Badge --}}
            @if(isset($status))
                @php
                    $badgeClass = match(strtolower($status)) {
                        'active', 'terbuka' => 'bg-success',
                        'closed', 'ditutup' => 'bg-danger',
                        'pending', 'menunggu' => 'bg-warning text-dark',
                        default => 'bg-secondary',
                    };
                @endphp
                <span class="badge {{ $badgeClass }} mb-3">{{ $status }}</span>
            @endif
            {{-- Akhir Tambahan Badge --}}

            <p class="card-text small">{{ $description }}</p>
            <a href="{{ $link }}" class="btn btn-custom mt-2">Lihat Detail</a>
        </div>
    </div>
</div>