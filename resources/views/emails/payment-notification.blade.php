<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Konfirmasi Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 10px;">
    <div style="max-width: 600px; margin: 0 auto; width: 100%;">
        <div style="background: white; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <!-- Header Section -->
            <div
                style="background: linear-gradient(135deg, #3171DC, #141B9C); color: white; padding: 20px 15px; text-align: center; position: relative; overflow: hidden;">
                <!-- Lingkaran dekoratif -->
                <div
                    style="position: absolute; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; top: -20px; left: -20px;">
                </div>
                <!-- Logo container -->
                <div style="margin-bottom: 10px;">
                    <img src="https://partycolorbderma.com/public/Images/1.png" alt="Party Color Run Logo"
                        style="height: 60px; width: auto; max-width: 100%;">
                </div>
                <!-- Konten teks -->
                <div>
                    <h1
                        style="margin: 0; font-size: clamp(24px, 5vw, 32px); font-weight: bold; position: relative; color: white;">
                        Party Color Run</h1>
                    <p style="font-size: clamp(16px, 4vw, 18px); margin-top: 10px; position: relative; color: white;">
                        Registrasi Anda telah dikonfirmasi</p>
                    <!-- Tambahkan SVG di bawah text -->
                    <img src="https://partycolorbderma.com/public/Images/Route.png" alt="Confirmation Icon"
                        style="height: 60px; width: auto; margin-top: 15px; display: block; margin-left: auto; margin-right: auto;">
                </div>
            </div>

            <!-- Content Section -->
            <div style="padding: 20px 15px; background: linear-gradient(135deg, #ffffff, #F2FCFD);">
                <!-- Status Badge -->
                <div style="text-align: center; margin-bottom: 25px;">
                    <span
                        style="display: inline-block; background: {{ $peserta->status_pembayaran === 'paid' ? 'linear-gradient(135deg, #86efac, #22c55e)' : 'linear-gradient(135deg, #f9a8d4, #ec4899)' }}; color: white; padding: 10px 20px; border-radius: 9999px; font-weight: 600; font-size: clamp(14px, 3vw, 16px); box-shadow: 0 2px 10px {{ $peserta->status_pembayaran === 'paid' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(236, 72, 153, 0.2)' }};">
                        {{ $peserta->status_pembayaran === 'paid' ? 'Pembayaran Lunas' : 'Menunggu Pembayaran' }}
                    </span>
                </div>

                <!-- Data Diri Section -->
                <div
                    style="background: white; border-radius: 1rem; padding: 20px 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <h3
                        style="color: #3171DC; font-size: clamp(18px, 4vw, 20px); font-weight: bold; border-bottom: 2px solid #FFFFFF; padding-bottom: 12px; margin-top: 0;">
                        Data Diri</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; width: 40%; vertical-align: top;">Nama Lengkap
                            </td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->nama_lengkap }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; vertical-align: top;">Email</td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937; word-break: break-all;">
                                {{ $peserta->email }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; vertical-align: top;">No. WhatsApp</td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->no_wa }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; vertical-align: top;">Kategori</td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->kategori }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; vertical-align: top;">Ukuran Jersey</td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">
                                {{ $peserta->size->name ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Alamat Section -->
                <div
                    style="background: white; border-radius: 1rem; padding: 20px 15px; margin-bottom: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <h3
                        style="color: #3171DC; font-size: clamp(18px, 4vw, 20px); font-weight: bold; border-bottom: 2px solid #FFFFFF; padding-bottom: 12px; margin-top: 0;">
                        Alamat & Kontak Darurat</h3>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; width: 40%; vertical-align: top;">Alamat Lengkap
                            </td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->alamat }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; vertical-align: top;">Provinsi</td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->provinsi }}
                            </td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; vertical-align: top;">Kota</td>
                            <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->kota }}</td>
                        </tr>
                        <tr>
                            <td style="padding: 12px 0; color: #6b7280; vertical-align: top;">Kontak Darurat</td>
                            <td style="padding: 12px 0;">
                                <div style="font-weight: 600; color: #1f2937;">{{ $peserta->emergency_nama }}</div>
                                <div style="color: #6b7280; font-size: 14px;">{{ $peserta->emergency_nomor }}</div>
                            </td>
                        </tr>
                    </table>
                </div>

                <!-- Important Notice Section -->
                <div
                    style="background: linear-gradient(135deg, #141B9C, #141B9C); padding: 20px 15px; margin-top: 25px; border-radius: 1rem; border-left: 4px solid #ec4899; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <strong style="color: #be123c; display: block; margin-bottom: 10px;">Penting:</strong>
                    <p style="margin: 10px 0; color: #FFFFFF; font-size: clamp(14px, 3vw, 16px);">Simpan email ini
                        sebagai bukti registrasi Anda. Email ini akan diperlukan saat pengambilan race pack.</p>
                    <p style="margin: 10px 0; color: #FFFFFF; font-size: clamp(14px, 3vw, 16px);">Untuk No BIB Akan
                        Diberikan Pada Saat Pengambilan Race Pack</p>

                    <!-- Check Order Button -->
                    <div style="text-align: center; margin-top: 20px;">
                        <a href="https://partycolorbderma.com/check-order?no_wa={{ $peserta->no_wa }}&email={{ $peserta->email }}"
                            style="display: inline-block; width: 80%; max-width: 300px; background: #ec4899; color: white; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; font-size: clamp(14px, 3vw, 16px);">
                            Cek Status Pendaftaran
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Section -->
            <div
                style="background: linear-gradient(135deg, #3171DC, #141B9C); color: white; text-align: center; padding: 20px 15px; position: relative; overflow: hidden;">
                <div
                    style="position: absolute; width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%; top: 10px; right: -10px;">
                </div>
                <p style="margin: 5px 0; font-size: clamp(14px, 3vw, 16px); position: relative;">
                    <a href="mailto:partycolorbderma@gmail.com"
                        style="color: white; text-decoration: none; word-break: break-all;">partycolorbderma@gmail.com</a>
                </p>
            </div>
        </div>
    </div>
</body>

</html>
