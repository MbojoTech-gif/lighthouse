<?php
require('fpdf/fpdf.php');

// Create new PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10); // Add margins

// Title Styling
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 51, 102); // Dark Blue Color
$pdf->Cell(0, 10, 'Terms of Use', 0, 1, 'C');
$pdf->Ln(5); // Line break

// Effective Date
$pdf->SetFont('Arial', 'I', 12);
$pdf->SetTextColor(100, 100, 100); // Gray color
$pdf->Cell(0, 10, 'Effective Date: 2/4/2025', 0, 1, 'C');
$pdf->Ln(5); // Line break

// Reset font for body text
$pdf->SetFont('Arial', '', 12);
$pdf->SetTextColor(0, 0, 0); // Black color

// Function to add formatted section headers
function addSectionTitle($pdf, $title) {
    $pdf->SetFont('Arial', 'B', 13);
    $pdf->SetTextColor(0, 51, 102); // Dark Blue
    $pdf->Cell(0, 8, $title, 0, 1);
    $pdf->Ln(2);
    $pdf->SetFont('Arial', '', 12); // Reset font
    $pdf->SetTextColor(0, 0, 0); // Black
}

// Function to add normal text with indentation
function addContent($pdf, $text) {
    $pdf->SetX(15); // Indentation
    $pdf->MultiCell(0, 7, $text);
    $pdf->Ln(2);
}

// Terms of Use Content with Formatting
addSectionTitle($pdf, "1. Acceptance of Terms");
addContent($pdf, "By accessing and using the Lighthouse Ministers website, you agree to comply with these Terms of Use. If you do not agree, please do not use our website.");

addSectionTitle($pdf, "2. Changes to Terms");
addContent($pdf, "We reserve the right to modify these Terms at any time. Any changes will be posted on this page, and continued use of the website constitutes acceptance of the revised terms.");

addSectionTitle($pdf, "3. User Responsibilities");
addContent($pdf, "- You must use this website for lawful purposes only.");
addContent($pdf, "- You may not engage in activities that could harm the website or interfere with its functionality.");

addSectionTitle($pdf, "4. Intellectual Property");
addContent($pdf, "All content on this website, including text, graphics, logos, and images, is the property of Lighthouse Ministers and protected by intellectual property laws. Unauthorized use is prohibited.");

addSectionTitle($pdf, "5. Limitation of Liability");
addContent($pdf, "Lighthouse Ministers is not responsible for any damages resulting from the use or inability to use this website. We do not guarantee uninterrupted or error-free service.");

addSectionTitle($pdf, "6. Privacy Policy");
addContent($pdf, "Your use of our website is also governed by our Privacy Policy. Please review it to understand how we collect and use your information.");

addSectionTitle($pdf, "7. Governing Law");
addContent($pdf, "These Terms are governed by the laws of [Your Country/State]. Any disputes will be resolved in the appropriate courts of jurisdiction.");

addSectionTitle($pdf, "8. Contact Us");
addContent($pdf, "If you have any questions about these Terms of Use, please contact us at:");
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 51, 102); // Dark Blue
$pdf->Cell(0, 8, "Lighthouseministers23@gmail.com", 0, 1);
$pdf->Ln(5);

// Output PDF for download
$pdf->Output('terms-of-use.pdf', 'D');
?>
