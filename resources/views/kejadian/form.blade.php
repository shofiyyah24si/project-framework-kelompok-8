<div class="mb-3">
    <label class="form-label">Jenis Bencana</label>
    <input type="text" name="jenis_bencana" value="{{ old('jenis_bencana', $kejadian->jenis_bencana ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Tanggal</label>
    <input type="date" name="tanggal" value="{{ old('tanggal', $kejadian->tanggal ?? '') }}" class="form-control" required>
</div>

<div class="mb-3">
    <label class="form-label">Lokasi</label>
    <input type="text" name="lokasi_text" value="{{ old('lokasi_text', $kejadian->lokasi_text ?? '') }}" class="form-control" required>
</div>

<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">RT</label>
        <input type="text" name="rt" value="{{ old('rt', $kejadian->rt ?? '') }}" class="form-control">
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label">RW</label>
        <input type="text" name="rw" value="{{ old('rw', $kejadian->rw ?? '') }}" class="form-control">
    </div>
</div>

<div class="mb-3">
    <label class="form-label">Dampak</label>
    <input type="text" name="dampak" value="{{ old('dampak', $kejadian->dampak ?? '') }}" class="form-control">
</div>

{{-- ✅ Dropdown status kejadian --}}
<div class="mb-3">
    <label class="form-label">Status Kejadian</label>
    <select name="status_kejadian" class="form-select" required>
        <option value="" disabled {{ old('status_kejadian', $kejadian->status_kejadian ?? '') == '' ? 'selected' : '' }}>Pilih Status</option>
        <option value="Aktif" {{ old('status_kejadian', $kejadian->status_kejadian ?? '') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
        <option value="Proses" {{ old('status_kejadian', $kejadian->status_kejadian ?? '') == 'Proses' ? 'selected' : '' }}>Proses</option>
        <option value="Selesai" {{ old('status_kejadian', $kejadian->status_kejadian ?? '') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
    </select>
</div>

<div class="mb-3">
    <label class="form-label">Keterangan</label>
    <textarea name="keterangan" class="form-control" rows="3">{{ old('keterangan', $kejadian->keterangan ?? '') }}</textarea>
</div>

{{-- ✅ Input upload foto --}}
<div class="mb-3">
    <label class="form-label">Foto / Berita Acara</label>
    <input type="file" name="foto" class="form-control" accept="image/*" onchange="previewFoto(event)">

    {{-- ✅ Preview foto lama --}}
    @if (!empty($kejadian->foto))
        <div class="mt-3">
            <p class="text-muted mb-1">Foto Sebelumnya:</p>
            <img src="{{ asset('storage/' . $kejadian->foto) }}" alt="Foto Kejadian" width="200" class="rounded shadow-sm border">
        </div>
    @endif

    {{-- ✅ Preview foto baru --}}
    <div class="mt-3" id="preview-container" style="display: none;">
        <p class="text-muted mb-1">Preview Foto Baru:</p>
        <img id="preview-foto" src="" alt="Preview" width="200" class="rounded shadow-sm border">
    </div>
</div>

{{-- ✅ Script JavaScript untuk preview foto sebelum upload --}}
<script>
    function previewFoto(event) {
        const previewContainer = document.getElementById('preview-container');
        const preview = document.getElementById('preview-foto');
        const file = event.target.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.style.display = 'block';
            };
            reader.readAsDataURL(file);
        } else {
            previewContainer.style.display = 'none';
        }
    }
</script>
