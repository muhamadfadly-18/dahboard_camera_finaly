<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>A4 Landscape Page</title>
    <style>
        @page {
            size: A4 landscape; /* Mengatur ukuran kertas A4 landscape */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #fff;
            display: flex; /* Mengatur konten di tengah halaman */
            justify-content: center; /* Mengatur konten di tengah halaman */
            align-items: center; /* Mengatur konten di tengah halaman */
            height: 100vh; /* Mengisi tinggi halaman */
        }

        .content {
            text-align: center; /* Mengatur teks di tengah */
            font-size: 575px; /* Ukuran font */
        }

        /* Tambahkan gaya tambahan sesuai kebutuhan Anda */
    </style>
</head>
<body>
    <div class="content">
        @foreach ($data as $item)
        <b><?php echo $item->id;?></b>
        <b><?php echo $item->id;?></b>
        @endforeach
        
    </div>
</body>
</html>
