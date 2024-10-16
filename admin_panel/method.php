<?php
header('Content-Type: text/html; charset=utf-8');
// Veritabanı bağlantısı için gerekli bilgiler
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "e-ticaret_boutique";

// Veritabanı bağlantısı
$conn = mysqli_connect($servername, $username, $password, $dbname);

// Bağlantı hatası kontrolü
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$conn->set_charset("utf8");

// Veri seçme işlemini gerçekleştiren fonksiyon
function selectData($table, $columns, $condition = "") {
    global $conn;
    $sql = "SELECT $columns FROM $table";
    if ($condition != "") {
        $sql .= " WHERE $condition";
    }
    $result = mysqli_query($conn, $sql);

    // Veri dizisi oluşturma
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
    }
    return $data;
}

function selectProcedure($procedure) {
    global $conn;
    $sql = "CALL $procedure()";

    // Önceki sorgunun sonuç kümesini temizle
    while(mysqli_more_results($conn)) {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result);
        }
        if (mysqli_next_result($conn) === false) {
            die("MySQL error: " . mysqli_error($conn));
        }
    }

    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("MySQL error: " . mysqli_error($conn));
    }

    // Veri dizisi oluşturma
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_free_result($result); // Sonuç setini serbest bırak
    }

    return $data;
}



function parProcedure($conn, $procedure, $par) {
    $sql = "CALL `$procedure`($par1);";
   
    $result = mysqli_query($conn, $sql);
    if (!$result) {
        die("MySQL error: " . mysqli_error($conn));
    }

    // Veri dizisi oluşturma
    $data = array();
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        mysqli_free_result($result); // sonuç setini serbest bırak
    }
    
    while(mysqli_next_result($conn)) { // sonraki sonuç setine geç
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result); // sonuç setini serbest bırak
        }
    }
    
    // Geçerli sonuç kümesini temizle
    while(mysqli_more_results($conn)) {
        if ($result = mysqli_store_result($conn)) {
            mysqli_free_result($result); // sonuç setini serbest bırak
        }
        mysqli_next_result($conn);
    }
    
    return $data;
}


//silmek için

function basvuruSil($table, $column, $value)
{
    global $conn;

    // Güvenlik önlemi: SQL enjeksiyon saldırılarına karşı koruma
    $table = mysqli_real_escape_string($conn, $table);
    $column = mysqli_real_escape_string($conn, $column);
    $value = mysqli_real_escape_string($conn, $value);

    $sql = "DELETE FROM $table WHERE $column = '$value'";

    $result = mysqli_query($conn, $sql);

    if ($result) {
        if (mysqli_affected_rows($conn) > 0) {
            echo "Kayıt başarıyla silindi.";
        } else {
            echo "Silinecek kayıt bulunamadı.";
        }
    } else {
        echo "Hata: " . mysqli_error($conn);
    }
}

// Veritabanında bir kaydı güncellemek için fonksiyon
function updateData($table, $column, $newValue, $condition) {
    global $conn; // Veritabanı bağlantısı
    $sql = "UPDATE $table SET $column = $newValue WHERE $condition";
    return mysqli_query($conn, $sql);
}








// Veritabanı bağlantısını kapatın


?>
