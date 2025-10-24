<?php
session_start();

if (!isset($_SESSION['registrations']) || !is_array($_SESSION['registrations'])) {
    $_SESSION['registrations'] = [];
}
$is_submitted = isset($_POST['submit']);
$last_registration = end($_SESSION['registrations']);
$umur_target = 0;
const MIN_UMUR = 10;
$is_age_error = false;

if ($is_submitted) {
    $umur_raw = $_POST['umur'] ?? '';

    if (empty($umur_raw) || !ctype_digit($umur_raw) || (int)$umur_raw < MIN_UMUR) {
        $is_age_error = true;
        
    } else {
        $umur_post = (int)$umur_raw;
        
        $new_registration = [
            "nama_depan" => $_POST['nama_depan'] ?? 'N/A',
            "nama_belakang" => $_POST['nama_belakang'] ?? 'N/A',
            "umur" => $umur_post, 
            "asal_kota" => $_POST['asal_kota'] ?? 'N/A',
        ];

        $_SESSION['registrations'][] = $new_registration;
        $umur_target = $umur_post;
        $data_diulang = $new_registration; 
    }

} elseif ($last_registration) {
    $umur_target = (int)($last_registration['umur'] ?? 0);
    $data_diulang = $last_registration;
}

?>

<html>
    <head>
        <title>::Data Registrasi::</title>
        <style type="text/css">
            body{
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-size: cover;
                background-image: url("https://cdn.arstechnica.net/wp-content/uploads/2023/06/bliss-update-1440x960.jpg");
                font-family: Arial, Helvetica, sans-serif;
                margin: 0;
                padding: 20px;
            }
            .container{
                background-color: white;
                border: 3px solid grey;
                padding: 30px;
                border-radius: 10px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                max-width: 600px;
                width: 100%;
            }
            h1{
                text-align: center;
                color: #333;
                margin-bottom: 30px;
                font-size: 28px;
            }
            .success-message{
                background-color: #d4edda;
                color: #155724;
                padding: 15px;
                margin-bottom: 20px;
                border: 1px solid #c3e6cb;
                border-radius: 5px;
                text-align: center;
                font-weight: bold;
            }
            table{
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }
            th, td{
                padding: 12px;
                text-align: left;
                border-bottom: 1px solid #ddd;
            }
            th{
                background-color: #f8f9fa;
                font-weight: bold;
                color: #333;
                width: 30%;
            }
            td{
                color: #666;
            }
            .back-button{
                text-align: center;
                margin-top: 20px;
            }
            .back-button a{
                background-color: #007bff;
                color: white;
                padding: 12px 24px;
                text-decoration: none;
                border-radius: 5px;
                display: inline-block;
                transition: background-color 0.3s;
            }
            .back-button a:hover{
                background-color: #0056b3;
            }
        </style>
    </head>
    <body>
        <div class="container">
            <h1>Data Registrasi User</h1>
            
            <?php if ($is_age_error): ?>
                
                <div class="age-error-box">
                    <h3>❌ ERROR!</h3>
                    <p style="font-size: 1.2em; font-weight: bold;">Umur harus minimal <?php echo MIN_UMUR; ?> tahun!</p>
                </div>
                <div class="back-button">
                    <a href="index.html">Kembali ke Form Registrasi</a>
                </div>

            <?php elseif ($umur_target >= MIN_UMUR): ?>
                <table border="1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Depan</th>
                            <th>Nama Belakang</th>
                            <th>Umur</th>
                            <th>Asal Kota</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php for($i = 2; $i <= $umur_target; $i += 2): ?>
                        <?php if ($i !=4 && $i !=8):?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo htmlspecialchars($data_diulang['nama_depan']); ?></td>
                            <td><?php echo htmlspecialchars($data_diulang['nama_belakang']); ?></td>
                            <td><?php echo htmlspecialchars($data_diulang['umur']); ?></td>
                            <td><?php echo htmlspecialchars($data_diulang['asal_kota']); ?></td>
                        </tr>
                        <?php endif; ?>
                    <?php endfor; ?>
                    </tbody>
                </table>
                <div class="back-button">
                    <a href="index.html">Kembali ke Form Registrasi</a>
                </div>

            <?php else: ?>
                <div style="text-align: center; color: #dc3545; padding: 20px;">
                    <h3>Error: Data tidak ditemukan</h3>
                    <p>Silakan isi form registrasi terlebih dahulu.</p>
                    <div class="back-button">
                        <a href="index.html">Kembali ke Form Registrasi</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </body>
</html>
