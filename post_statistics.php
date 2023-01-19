<?php
require('mc_table.php');
require_once('connect.php');

date_default_timezone_set("Asia/Jakarta");

class CustomPDF extends PDF_MC_Table {
    function header() {
        $datetime = date("Y-m-d");
        $this->SetFont('Arial','B',18);
        $this->Cell(276, 7, "Disform User Post Statistics", 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial','',12);
        $this->Cell(276, 7, "https://www.google.com", 0, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial','',14);
        $this->Cell(276, 12, "Created in: " . $datetime, 0, 0, 'C');
        $this->Ln(20);
    }

    function tabletitle() {
        $this->SetFont('Times','B',12);
        $this->Cell(20, 5, "User ID", 1, 0, 'C');
        $this->Cell(40, 5, "Full Name", 1, 0, 'C');
        $this->Cell(45, 5, "Email", 1, 0, 'C');
        $this->Cell(30, 5, "Username", 1, 0, 'C');
        $this->Cell(35, 5, "Title", 1, 0, 'C');
        $this->Cell(66, 5, "Content", 1, 0, 'C');
        $this->Cell(15, 5, "Likes", 1, 0, 'C');
        $this->Cell(25, 5, "Comments", 1, 0, 'C');
        $this->Ln();
    }

    function footer() {
        $this->SetY(-15);
        $this->SetFont("Arial", "", 10);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$pdf= new CustomPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L', 'A4', 0);
$pdf->tabletitle();
$pdf->SetFont('Times','',10);

$sql = "
SELECT post.profile_id AS id, 
CONCAT(profile.first_name, ' ', profile.last_name) AS fullname,
user.email AS email,
user.username AS username,
post.title AS title,
post.content AS content,
post.likes AS likes,
post.comments AS comments
FROM post INNER JOIN profile ON post.profile_id = profile.id
          INNER JOIN user ON post.user_id = user.id
ORDER BY post.time DESC";

$hasil = $db->query($sql);

$pdf->SetWidths(array(20, 40, 45, 30, 35, 66, 15, 25));

while ($row = $hasil->fetch(PDO::FETCH_ASSOC)) {
  $pdf->Row(array($row['id'], $row['fullname'], $row['email'], $row['username'], $row['title'], $row['content'], $row['likes'], $row['comments']));
}

require_once('close.php');

$pdf->Output();