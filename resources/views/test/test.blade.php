@extends('layouts.app')

@section('content')

    <div class="form-container">
        <h2>Form Alamat dengan Autocomplete Kode Pos</h2>

        <form action="" method="POST">
            @csrf

            <div class="form-group">
                <label for="alamat">Alamat</label>
                <input type="text" name="alamat" id="alamat" placeholder="Masukkan alamat lengkap">
            </div>

            <div class="form-group autocomplete-wrapper">
                <label for="kode_pos">Kode Pos</label>
                <input type="text" name="kode_pos" id="kode_pos" placeholder="Ketik minimal 3 digit kode pos"
                    autocomplete="off">
                <div id="autocomplete-results" class="autocomplete-results"></div>
                <small class="help-text">Ketik minimal 3 digit untuk mencari</small>
            </div>

            <div class="form-group">
                <label for="provinsi">Provinsi</label>
                <input type="text" name="provinsi" id="provinsi" placeholder="Otomatis terisi">
            </div>

            <div class="form-group">
                <label for="kota">Kota/Kabupaten</label>
                <input type="text" name="kota" id="kota" placeholder="Otomatis terisi">
            </div>

            <div class="form-group">
                <label for="kecamatan">Kecamatan</label>
                <input type="text" name="kecamatan" id="kecamatan" placeholder="Otomatis terisi">
            </div>

            <div class="form-group">
                <label for="kelurahan">Kelurahan/Desa</label>
                <input type="text" name="kelurahan" id="kelurahan" placeholder="Otomatis terisi">
            </div>

            <button type="submit" class="btn-submit">Submit</button>
        </form>
    </div>

    <style>
        .form-container {
            max-width: 600px;
            margin: 30px auto;
            padding: 30px;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            margin-bottom: 25px;
            color: #333;
            font-size: 24px;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 14px;
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            font-size: 14px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.1);
        }

        input[readonly] {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        .help-text {
            display: block;
            margin-top: 5px;
            font-size: 12px;
            color: #999;
        }

        .autocomplete-wrapper {
            position: relative;
        }

        .autocomplete-results {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 2px solid #4CAF50;
            border-top: none;
            border-radius: 0 0 6px 6px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            display: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .autocomplete-results.show {
            display: block;
        }

        .autocomplete-item {
            padding: 12px 15px;
            cursor: pointer;
            border-bottom: 1px solid #f0f0f0;
            transition: background-color 0.2s;
        }

        .autocomplete-item:hover {
            background-color: #f5f5f5;
        }

        .autocomplete-item:last-child {
            border-bottom: none;
        }

        .autocomplete-item .postal-code {
            font-weight: 600;
            color: #4CAF50;
            font-size: 14px;
        }

        .autocomplete-item .address {
            font-size: 13px;
            color: #666;
            margin-top: 3px;
        }

        .no-results {
            padding: 15px;
            text-align: center;
            color: #999;
            font-size: 13px;
        }

        .loading {
            padding: 15px;
            text-align: center;
            color: #4CAF50;
            font-size: 13px;
        }

        .btn-submit {
            width: 100%;
            padding: 14px;
            background: #4CAF50;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-submit:hover {
            background: #45a049;
        }

        .btn-submit:active {
            transform: translateY(1px);
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const kodePostInput = document.getElementById('kode_pos');
            const resultsDiv = document.getElementById('autocomplete-results');
            const provinsiInput = document.getElementById('provinsi');
            const kotaInput = document.getElementById('kota');
            const kecamatanInput = document.getElementById('kecamatan');
            const kelurahanInput = document.getElementById('kelurahan');

            let debounceTimer;

            // Event listener untuk input kode pos
            kodePostInput.addEventListener('input', function () {
                const query = this.value.trim();

                // Clear previous timer
                clearTimeout(debounceTimer);

                // Hide results if query is too short
                if (query.length < 3) {
                    resultsDiv.classList.remove('show');
                    resultsDiv.innerHTML = '';
                    return;
                }

                // Show loading
                resultsDiv.innerHTML = '<div class="loading">Mencari...</div>';
                resultsDiv.classList.add('show');

                // Debounce AJAX call
                debounceTimer = setTimeout(() => {
                    searchPostalCode(query);
                }, 300);
            });

            // Function to search postal code via AJAX
            function searchPostalCode(query) {
                fetch(`/api/postal-code/search?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.length > 0) {
                            displayResults(data.data);
                        } else {
                            resultsDiv.innerHTML = '<div class="no-results">Tidak ada hasil ditemukan</div>';
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        resultsDiv.innerHTML = '<div class="no-results">Terjadi kesalahan</div>';
                    });
            }

            // Function to display results
            function displayResults(results) {
                let html = '';
                results.forEach(item => {
                    html += `
                                <div class="autocomplete-item" data-postal-code="${item.postal_code}" 
                                     data-province="${item.province_name}" 
                                     data-city="${item.city}"
                                     data-district="${item.sub_district}"
                                     data-urban="${item.urban}">
                                    <div class="postal-code">${item.postal_code}</div>
                                    <div class="address">${item.urban}, ${item.sub_district}, ${item.city}</div>
                                </div>
                            `;
                });
                resultsDiv.innerHTML = html;

                // Add click event to each item
                document.querySelectorAll('.autocomplete-item').forEach(item => {
                    item.addEventListener('click', function () {
                        selectPostalCode(this);
                    });
                });
            }

            // Function to select postal code and fill form
            function selectPostalCode(element) {
                kodePostInput.value = element.dataset.postalCode;
                provinsiInput.value = element.dataset.province;
                kotaInput.value = element.dataset.city;
                kecamatanInput.value = element.dataset.district;
                kelurahanInput.value = element.dataset.urban;

                // Hide results
                resultsDiv.classList.remove('show');
                resultsDiv.innerHTML = '';
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function (e) {
                if (!e.target.closest('.autocomplete-wrapper')) {
                    resultsDiv.classList.remove('show');
                    resultsDiv.innerHTML = '';
                }
            });
        });
    </script>

@endsection