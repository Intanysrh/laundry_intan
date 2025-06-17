<?php
$hostname = "localhost";
$hostusername = "root";
$hostpassword = "";
$hostdatabase = "laundry_intan";
$config = mysqli_connect($hostname, $hostusername, $hostpassword, $hostdatabase);
if (!$config) {
    echo "koneksi gagal";
}
