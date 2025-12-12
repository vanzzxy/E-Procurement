@switch($status)
    @case('menunggu')
        <span id="status-badge-{{ $id }}" class="badge bg-warning text-dark">Menunggu</span>
        @break

    @case('setuju')
        <span id="status-badge-{{ $id }}" class="badge bg-success">Setuju</span>
        @break

    @case('pengiriman')
        <span id="status-badge-{{ $id }}" class="badge bg-primary">Pengiriman</span>
        @break

    @case('selesai')
        <span id="status-badge-{{ $id }}" class="badge bg-secondary text-light">Selesai</span>
        @break

    @case('diterima')
        <span id="status-badge-{{ $id }}" class="badge bg-info text-dark">Diterima</span>
        @break

    @default
        <span id="status-badge-{{ $id }}" class="badge bg-secondary">{{ ucfirst($status) }}</span>
@endswitch
