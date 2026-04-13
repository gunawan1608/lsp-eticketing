@extends('layouts.app')

@section('title', 'Tambah Jadwal — E-Ticket Pro')

@section('content')

    <div class="form-card">
        <div class="card-header">
            <div style="display:flex;align-items:center;gap:.75rem;">
                <div class="stat-icon stat-icon--blue" style="width:36px;height:36px;border-radius:var(--r-md);">
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </div>
                <div>
                    <div class="card-title">Jadwal Baru</div>
                    <div style="font-size:12px;color:var(--ink-5);margin-top:1px;">Isi detail penerbangan di bawah ini</div>
                </div>
            </div>
        </div>

        <form action="{{ url('/admin/schedules/store') }}" method="POST">
            @csrf
            <div class="form-body">
                <div class="form-group">
                    <label class="form-label" for="plane_name">Maskapai / Pesawat</label>
                    <input type="text" id="plane_name" name="plane_name" class="form-control"
                        placeholder="Garuda Indonesia GA-123" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="origin">Asal (Origin)</label>
                        <input type="text" id="origin" name="origin" class="form-control" placeholder="Jakarta (CGK)"
                            required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="destination">Tujuan (Destination)</label>
                        <input type="text" id="destination" name="destination" class="form-control" placeholder="Bali (DPS)"
                            required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="departure">Waktu Keberangkatan</label>
                    <input type="datetime-local" id="departure" name="departure" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label" for="price">Harga per Tiket</label>
                        <div class="input-prefix-wrap">
                            <span class="input-prefix">Rp</span>
                            <input type="number" id="price" name="price" class="form-control input-has-prefix"
                                placeholder="1500000" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="stock">Stok Kursi</label>
                        <input type="number" id="stock" name="stock" class="form-control" placeholder="50" min="1" required>
                    </div>
                </div>
            </div>
            <div class="form-footer">
                <button type="submit" class="btn btn-primary" style="padding: 0 1.75rem; height:36px;">Simpan
                    Jadwal</button>
                <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
        </form>
    </div>

@endsection
