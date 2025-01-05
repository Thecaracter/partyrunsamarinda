<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Konfirmasi Pembayaran</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body style="background: white; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 20px;">
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="background: white; border-radius: 1rem; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <div
                style="background: linear-gradient(135deg, #3171DC, #141B9C); color: white; padding: 20px 20px; text-align: center; position: relative; overflow: hidden;">
                <div
                    style="position: absolute; width: 100px; height: 100px; background: rgba(255,255,255,0.1); border-radius: 50%; top: -20px; left: -20px;">
                </div>
                <div style="margin-bottom: 10px;">
                    <img src="https://res.cloudinary.com/djapytwxw/image/upload/v1735677699/8_qgho4b.png"
                        alt="Party Color Run Logo" style="height: 80px; width: auto;">
                </div>
                <div>
                    <h1 style="margin: 0; font-size: 32px; font-weight: bold; position: relative; color: white;">
                        Party Color Run
                    </h1>
                    <p style="font-size: 18px; margin-top: 10px; position: relative; color: white;">
                        Registrasi Anda telah dikonfirmasi
                    </p>
                </div>

                <div style="padding: 30px; background: linear-gradient(135deg, #ffffff, #F2FCFD);">
                    {{-- <div
                    style="background: linear-gradient(135deg, #3171DC, #141B9C); color: white; padding: 25px; border-radius: 1rem; text-align: center; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(236, 72, 153, 0.2);">
                    <div style="font-size: 20px; color: #FFFFFF;">Nomor BIB</div>
                    <div style="font-size: 36px; font-weight: bold; margin-top: 10px; color: #FFFFFF;">
                        {{ $peserta->kode_bib ?? 'Akan diberikan setelah pembayaran' }}
                    </div>

                </div> --}}
                    <div style="text-align: center; margin-bottom: 30px;">
                        <span
                            style="background: {{ $peserta->status_pembayaran === 'paid' ? 'linear-gradient(135deg, #86efac, #22c55e)' : 'linear-gradient(135deg, #f9a8d4, #ec4899)' }}; color: white; padding: 10px 30px; border-radius: 9999px; font-weight: 600; font-size: 16px; box-shadow: 0 2px 10px {{ $peserta->status_pembayaran === 'paid' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(236, 72, 153, 0.2)' }};">{{ $peserta->status_pembayaran === 'paid' ? 'Pembayaran Lunas' : 'Menunggu Pembayaran' }}</span>
                    </div>
                    <div
                        style="background: white; border-radius: 1rem; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <h3
                            style="color: #3171DC; font-size: 20px; font-weight: bold; border-bottom: 2px solid #FFFFFF; padding-bottom: 12px; margin-top: 0;">
                            Data Diri</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280; width: 140px;">Nama Lengkap</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">
                                    {{ $peserta->nama_lengkap }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280;">Email</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->email }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280;">No. WhatsApp</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->no_wa }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280;">Kategori</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->kategori }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280;">Ukuran Jersey</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">
                                    {{ $peserta->size->name ?? 'N/A' }}</td>
                            </tr>
                        </table>
                    </div>
                    <div
                        style="background: white; border-radius: 1rem; padding: 25px; margin-bottom: 25px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <h3
                            style="color: #3171DC; font-size: 20px; font-weight: bold; border-bottom: 2px solid #FFFFFF; padding-bottom: 12px; margin-top: 0;">
                            Alamat & Kontak Darurat</h3>
                        <table style="width: 100%; border-collapse: collapse;">
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280; width: 140px;">Alamat Lengkap</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->alamat }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280;">Provinsi</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->provinsi }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280;">Kota</td>
                                <td style="padding: 12px 0; font-weight: 600; color: #1f2937;">{{ $peserta->kota }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 12px 0; color: #6b7280;">Kontak Darurat</td>
                                <td style="padding: 12px 0;">
                                    <div style="font-weight: 600; color: #1f2937;">{{ $peserta->emergency_nama }}</div>
                                    <div style="color: #6b7280; font-size: 14px;">{{ $peserta->emergency_nomor }}</div>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div
                        style="background: linear-gradient(135deg, #141B9C, #141B9C); padding: 20px; margin-top: 30px; border-radius: 1rem; border-left: 4px solid #ec4899; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <strong style="color: #be123c;">Penting:</strong>
                        <p style="margin: 10px 0 0 0; color: #FFFFFF;">Simpan email ini sebagai bukti registrasi Anda.
                            Email
                            ini akan diperlukan saat pengambilan race pack.</p>
                        <p style="margin: 10px 0 0 0; color: #FFFFFF;">Untuk No BIB Akan Diberikan Pada Saat Pengambilan
                            Race Pack</p>
                    </div>
                </div>
                <div
                    style="background: linear-gradient(135deg, #3171DC, #141B9C); color: white; text-align: center; padding: 30px; position: relative; overflow: hidden;">
                    <div
                        style="position: absolute; width: 60px; height: 60px; background: rgba(255,255,255,0.1); border-radius: 50%; top: 10px; right: -10px;">
                    </div>
                    <p style="margin: 5px 0; font-size: 16px; position: relative;">
                        <a href="mailto:support@partycolorrun.com"
                            style="color: white; text-decoration: none;">partycolorbderma@gmail.com</a>
                        <br>
                        <span></span>
                    </p>
                </div>
            </div>
        </div>
</body>

</html>
