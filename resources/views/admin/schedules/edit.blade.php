@extends('layouts.app')

@section('title', 'Edit Jadwal — E-Ticket Pro')

@section('content')

    <a href="{{ url('/dashboard') }}" class="back-link">
        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor"
            stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
            <line x1="19" y1="12" x2="5" y2="12" />
            <polyline points="12 19 5 12 12 5" />
        </svg>
        Dashboard Admin
    </a>

    <div class="form-card">
        <div class="card-header">
            <div style="display:flex;align-items:center;gap:.75rem;flex:1;">
                <div class="stat-icon stat-icon--amber" style="width:36px;height:36px;border-radius:var(--r-md);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                    </svg>
                </div>
                <div>
                    <div class="card-title">Edit Jadwal</div>
                    <div style="font-size:12px;color:var(--ink-5);margin-top:1px;">{{ $schedule->plane_name }}</div>
                </div>
            </div>
            <span class="id-chip"># {{ $schedule->id }}</span>
        </div>

        <form action="{{ url('/admin/schedules/update/' . $schedule->id) }}" method="POST">
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label class="form-label" for="plane_name">Maskapai / Pesawat</label>
                    <input type="text" id="plane_name" name="plane_name" class="form-control"
                        value="{{ $schedule->plane_name }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="origin">Asal (Origin)</label>
                        <input type="text" id="origin" name="origin" class="form-control" value="{{ $schedule->origin }}"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="destination">Tujuan (Destination)</label>
                        <input type="text" id="destination" name="destination" class="form-control"
                            value="{{ $schedule->destination }}" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="departure">Waktu Keberangkatan</label>
                    <input type="datetime-local" id="departure" name="departure" class="form-control"
                        value="{{ date('Y-m-d\TH:i', strtotime($schedule->departure)) }}" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="price">Harga per Tiket</label>
                        <div class="input-prefix-wrap">
                            <span class="input-prefix">Rp</span>
                            <input type="number" id="price" name="price" class="form-control input-has-prefix"
                                value="{{ $schedule->price }}" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="stock">Stok Kursi</label>
                        <input type="number" id="stock" name="stock" class="form-control" value="{{ $schedule->stock }}"
                            min="0" required>
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary" style="padding: 0 1.75rem; height:36px;">Simpan
                    Perubahan</button>
                <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>

@endsection
