<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Biodata Peserta</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Jenis Kelamin</label>
                    <div class="form-check">
                        <input class="form-check-input" @if (old('jenis_kelamin', @$pegawai->jenis_kelamin) == 'Laki-Laki') checked @endif
                            @if (!isset($peserta)) checked @endif type="radio"
                            name="jenis_kelamin" value="Laki-Laki" id="flexRadioDefault1" />
                        <label class="form-check-label" for="flexRadioDefault1">
                            Laki-Laki
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio"
                            @if (old('jenis_kelamin', @$pegawai->jenis_kelamin) == 'Perempuan') checked @endif name="jenis_kelamin"
                            value="Perempuan" id="flexRadioDefault2" />
                        <label class="form-check-label" for="flexRadioDefault2">
                            Perempuan
                        </label>
                    </div>
                    @error('jenis_kelamin')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input class="form-control" placeholder="NIK..." type="text" name="nik"
                        value="{{ old('nik', @$pegawai->nik) }}" />
                    @error('nik')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Tempat Lahir</label>
                    <input class="form-control" placeholder="Tempat Lahir..." type="text"
                        name="tempat_lahir"
                        value="{{ old('tempat_lahir', @$pegawai->tempat_lahir) }}" />
                    @error('tempat_lahir')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Tanggal Lahir</label>
                    <input class="form-control" placeholder="Tanggal Lahir..." type="date"
                        name="tanggal_lahir"
                        value="{{ old('tanggal_lahir', @$pegawai->tanggal_lahir) }}" />
                    @error('tanggal_lahir')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            
                <div class="form-group">
                    <label>No WA <small class="text-blue-500">(silahkan isi dengan no telp
                            jika no telp & wa sama)</small></label>
                    <input class="form-control" placeholder="08..." type="text" name="no_wa"
                        value="{{ old('no_wa', @$pegawai->no_wa) }}" minlength="1"
                        maxlength="20" />
                    @error('no_wa')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="alamat_rumah">Alamat Rumah</label>
                    <textarea class="form-control" rows="4" id="alamat_rumah" placeholder="Jl.Jalan-jalan..."
                        name="alamat_rumah">{{ old('alamat_rumah', @$pegawai->alamat_rumah) }}</textarea>
                    @error('alamat_rumah')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>


                <div class="form-group">
                    <label>Pendidikan Terakhir</label>
                    <input class="form-control" placeholder="Pendidikan Terakhir..." type="text"
                        name="pendidikan_terakhir"
                        value="{{ old('pendidikan_terakhir', @$pegawai->pendidikan_terakhir) }}"
                        maxlength="100" />
                    @error('pendidikan_terakhir')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>
                        Agama
                    </label>
                    <select name="agama" class="form-control">
                        <option value="">Pilih Agama</option>
                        <option value="Islam" @if (old('agama', @$pegawai->agama) == 'Islam') selected @endif>Islam</option>
                        <option value="Kristen" @if (old('agama', @$pegawai->agama) == 'Kristen') selected @endif>Kristen
                        </option>
                        <option value="Katolik" @if (old('agama', @$pegawai->agama) == 'Katolik') selected @endif>Katolik
                        </option>
                        <option value="Hindu" @if (old('agama', @$pegawai->agama) == 'Hindu') selected @endif>Hindu</option>
                        <option value="Budha" @if (old('agama', @$pegawai->agama) == 'Budha') selected @endif>Budha</option>
                        <option value="Konghucu" @if (old('agama', @$pegawai->agama) == 'Konghucu') selected @endif>Konghucu
                        </option>
                    </select>
                </div>
                <div class="form-group">
                    <label>
                        Status Perkawinan
                    </label>
                    <select name="status_perkawinan" class="form-control">
                        <option value="">Pilih Status Perkawinan</option>
                        <option value="Belum Kawin" @if (old('status_perkawinan', @$pegawai->status_perkawinan) == 'Belum Kawin') selected @endif>Belum
                            Kawin
                        </option>
                        <option value="Kawin" @if (old('status_perkawinan', @$pegawai->status_perkawinan) == 'Kawin') selected @endif>Kawin
                        </option>
                        <option value="Cerai Hidup" @if (old('status_perkawinan', @$pegawai->status_perkawinan) == 'Cerai Hidup') selected @endif>Cerai
                            Hidup
                        </option>
                        <option value="Cerai Mati" @if (old('status_perkawinan', @$pegawai->status_perkawinan) == 'Cerai Mati') selected @endif>Cerai
                            Mati
                        </option>
                    </select>
                </div>
            </div>

        </div>

    </div>
</div>
<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Pekerjaan</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label>NIP</label>
                    <input class="form-control" placeholder="NIP..." type="text" name="nip"
                        value="{{ old('nip', @$pegawai->nip) }}" />
                    @error('nip')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <label>Nama Jabatan</label>
                    <input class="form-control" placeholder="Nama Jabatan..." type="text"
                        name="nama_jabatan"
                        value="{{ old('nama_jabatan', @$pegawai->nama_jabatan) }}" />
                    @error('nama_jabatan')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>Pangkat Golongan</label>
                    {{-- <input class="form-control" placeholder="Pangkat Golongan..." type="text"
                        name="pangkat_golongan"
                        value="{{ old('pangkat_golongan', @$pegawai->pangkat_golongan) }}" /> --}}
                    <select name="pangkat_golongan" class="form-control" id="pangkat_golongan">
                        <option value="">Pilih Pangkat Golongan</option>
                        <option value="ii.a" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'ii.a') selected @endif>Pengatur
                            Muda / II.a</option>
                        <option value="ii.b" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'ii.b') selected @endif>Pengatur
                            Muda Tk. I / II.b</option>
                        <option value="ii.c" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'ii.c') selected @endif>Pengatur /
                            II.c</option>
                        <option value="ii.d" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'ii.d') selected @endif>Pengatur Tk.
                            I / II.d</option>
                        <option value="iii.a" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'iii.a') selected @endif>Penata Muda
                            / III.a</option>
                        <option value="iii.b" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'iii.b') selected @endif>Penata Muda
                            Tk. I / III.b</option>
                        <option value="iii.c" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'iii.c') selected @endif>Penata /
                            III.c</option>
                        <option value="iii.d" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'iii.d') selected @endif>Penata Tk. I
                            / III.d</option>
                        <option value="iv.a" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'iv.a') selected @endif>Pembina /
                            IV.a</option>
                        <option value="iv.b" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'iv.b') selected @endif>Pembina Tk.
                            I / IV.b</option>
                        <option value="iv.c" @if (old('pangkat_golongan', @$pegawai->pangkat_golongan) == 'iv.c') selected @endif>Pembina
                            Utama Muda / IV.c</option>
                    </select>
                    @error('pangkat_golongan')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
            
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Data Login</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">

                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control" placeholder="Username..." type="text" name="username"
                        value="{{ old('username', @$pegawai->loginPegawai->username) }}" minlength="5"/>
                    @error('username')
                        <span class="text-xs text-danger">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
                @if (isset($pegawai))
                    <div class="form-group">
                        <label>Password Baru</label>
                        <input class="form-control" placeholder="Password Baru..." type="password" name="password_baru"  minlength="5"/>
                        @error('password_baru')
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                @else
                    <div class="form-group">
                        <label>Password</label>
                        <input class="form-control" placeholder="Password..." type="password" name="password"  minlength="5"/>
                        @error('password')
                            <span class="text-xs text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                @endif

            </div>
            
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4 class="card-title">Foto</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h5 class="card-title">Foto Diri </h5>
                <p class="card-text">
                    Upload gambar PNG/JPEG maksimal 5MB
                </p>
                <!-- File uploader with image preview -->
                <label class="dropzone" id="dropzone_foto_profil">
                    <h4>Drop & Drag File</h4>
                    <p>Drag and drop file here or click to select file.</p>
                    <input type="file" name="foto_profil" id="foto_profil" style="display: none;"
                        accept="image/*">
                    <img id="preview_foto_profil" src="#" alt="Preview" style="display: none;"
                        class="mx-auto">
                </label>
                @if (isset($pegawai) && $pegawai->link_foto_profil != null)
                    <img src="{{ $pegawai->link_foto_profil }}" alt="foto kegiatan"
                        class="img-fluid">
                @endif
                @error('foto_profil')
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror

            </div>
            <div class="col-md-6">
                <h5 class="card-title">Foto SPT</h5>
                <p class="card-text">
                    Upload gambar PNG/JPEG maksimal 5MB
                </p>
                <!-- File uploader with image preview -->
                <label class="dropzone" id="dropzone_foto_spt">
                    <h4>Drop & Drag File</h4>
                    <p>Drag and drop file here or click to select file.</p>
                    <input type="file" name="foto_spt" id="foto_spt" style="display: none;"
                        accept="image/*">
                    <img id="preview_foto_spt" src="#" alt="Preview" style="display: none;"
                        class="mx-auto">
                </label>
                @if (isset($pegawai) && $pegawai->link_foto_spt != null)
                    <button type="button" class="btn btn-danger btn-sm"
                        onclick="document.getElementById('old_foto_spt').remove();this.remove();"><i
                            class="fas fa-trash"></i> Hapus File</button>
                    <div id="old_foto_spt">
                        <input type="hidden" name="old_foto_spt"
                            value="{{ $pegawai->link_foto_spt }}">
                        <img src="{{ $pegawai->link_foto_spt }}" alt="foto kegiatan"
                            class="img-fluid">
                    </div>
                @endif
                @error('foto_spt')
                    <span class="text-xs text-danger">
                        {{ $message }}
                    </span>
                @enderror


            </div>


        </div>

    </div>
</div>



@push('styles')
        <style>
            .dropzone {
                border: 2px dashed #ccc;
                padding: 25px;
                text-align: center;
                cursor: pointer;
                width: 100%;
            }

            .dropzone img {
                max-width: 100%;
                max-height: 200px;
                margin-top: 10px;
            }
        </style>
    @endpush

    @push('scripts')
        <script type="module">
        $(document).ready(function() {
            
            function initDropzone(id) {
                // Prevent default drag behaviors
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    document.getElementById('dropzone_'+id).addEventListener(eventName, preventDefaults, false);
                    document.body.addEventListener(eventName, preventDefaults, false);
                });

                // Highlight drop zone when item is dragged over it
                ['dragenter', 'dragover'].forEach(eventName => {
                    document.getElementById('dropzone_'+id).addEventListener(eventName, highlight, false);
                });

                // Unhighlight drop zone when item is dragged out of it
                ['dragleave', 'drop'].forEach(eventName => {
                    document.getElementById('dropzone_'+id).addEventListener(eventName, unhighlight, false);
                });

                // Handle dropped files
                document.getElementById('dropzone_'+id).addEventListener('drop', handleDrop, false);

                // Handle file input change
                document.getElementById(id).addEventListener('change', handleFileSelect, false);

                function preventDefaults(e) {
            e.preventDefault();
            e.stopPropagation();
        }

        function highlight(e) {
            document.getElementById('dropzone_'+id).classList.add('bg-light');
        }

        function unhighlight(e) {
            document.getElementById('dropzone_'+id).classList.remove('bg-light');
        }

        function handleDrop(e) {
            let dt = e.dataTransfer;
            let files = dt.files;

            handleFiles(files);
        }

        function handleFileSelect(e) {
            let files = e.target.files;

            handleFiles(files);
        }

        function handleFiles(files) {
            let file = files[0];

            // Check if file is an image
            if (file.type.match(/^image\//)) {
                let reader = new FileReader();

                reader.onload = function(e) {
                    let img = document.getElementById('preview_'+id);
                    img.src = e.target.result;
                    img.style.display = 'block';
                }

                reader.readAsDataURL(file);
            }
        }
            }
            initDropzone('foto_profil');
            initDropzone('foto_spt')
        });

        
    </script>
    @endpush