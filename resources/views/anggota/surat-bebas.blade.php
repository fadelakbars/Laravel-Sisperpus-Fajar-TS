<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Surat Keterangan Bebas Perpustakaan - {{ $user->name }}</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            line-height: 1.6;
            color: #000;
            margin: 0;
            padding: 40px;
            background-color: #fff;
        }
        .header {
            text-align: center;
            border-bottom: 3px double #000;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            font-size: 18pt;
            text-transform: uppercase;
        }
        .header p {
            margin: 5px 0;
            font-size: 11pt;
        }
        .content {
            margin-bottom: 40px;
        }
        .title {
            text-align: center;
            margin-bottom: 30px;
        }
        .title h2 {
            margin: 0;
            font-size: 14pt;
            text-decoration: underline;
            text-transform: uppercase;
        }
        .title p {
            margin: 5px 0;
            font-size: 11pt;
        }
        .details {
            margin-bottom: 30px;
        }
        .details table {
            width: 100%;
            border-collapse: collapse;
        }
        .details td {
            padding: 5px 0;
            vertical-align: top;
        }
        .details td:first-child {
            width: 200px;
        }
        .details td:nth-child(2) {
            width: 20px;
        }
        .signature {
            float: right;
            width: 250px;
            text-align: center;
            margin-top: 50px;
        }
        .footer {
            clear: both;
            margin-top: 50px;
            font-size: 9pt;
            font-style: italic;
            color: #666;
            text-align: center;
        }
        @media print {
            body {
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
        .no-print {
            background-color: #f8fafc;
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 6px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #e2e8f0;
        }
        .btn-print {
            background-color: #4f46e5;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
            font-family: sans-serif;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="no-print">
        <span>Pratinjau Surat Bebas Perpustakaan</span>
        <button onclick="window.print()" class="btn-print">Cetak / Simpan PDF</button>
    </div>

    <div class="header">
        <h1>Sistem Informasi Perpustakaan (Sisperpus)</h1>
        <p>Jl. Pendidikan No. 123, Kota Cerdas, Indonesia</p>
        <p>Telepon: (021) 1234567 | Email: perpustakaan@sisperpus.ac.id</p>
    </div>

    <div class="title">
        <h2>Surat Keterangan Bebas Perpustakaan</h2>
        <p>Nomor: {{ now()->format('Ymd') }}/SKBP/{{ $user->id }}</p>
    </div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini, Kepala Perpustakaan Sisperpus menerangkan bahwa:</p>
        
        <div class="details">
            <table>
                <tr>
                    <td>Nama Lengkap</td>
                    <td>:</td>
                    <td><strong>{{ $user->name }}</strong></td>
                </tr>
                <tr>
                    <td>NIM</td>
                    <td>:</td>
                    <td>{{ $user->nim }}</td>
                </tr>
                <tr>
                    <td>Email</td>
                    <td>:</td>
                    <td>{{ $user->email }}</td>
                </tr>
            </table>
        </div>

        <p>Berdasarkan data pada sistem informasi kami, mahasiswa tersebut di atas dinyatakan telah <strong>BEBAS PERPUSTAKAAN</strong> karena tidak memiliki pinjaman buku yang aktif dan tidak memiliki tunggakan denda.</p>
        
        <p>Surat keterangan ini diberikan sebagai bukti persyaratan administratif dan dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="signature">
        <p>Kota Cerdas, {{ $tanggal->translatedFormat('d F Y') }}</p>
        <p>Kepala Perpustakaan,</p>
        <br><br><br>
        <p><strong>Administrator Sisperpus</strong></p>
        <p>NIP. 198001012005011001</p>
    </div>

    <div class="footer">
        Dicetak secara otomatis oleh Sistem Sisperpus pada {{ now()->format('d/m/Y H:i:s') }}
    </div>

    <script>
        // Auto trigger print dialog
        window.onload = function() {
            // Optional: window.print();
        };
    </script>
</body>
</html>
