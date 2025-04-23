<?php
require('fpdf/fpdf.php');

// Create new PDF document
$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetMargins(10, 10, 10); // Add margins

// Title Styling
$pdf->SetFont('Arial', 'B', 16);
$pdf->SetTextColor(0, 51, 102); // Dark Blue Color
$pdf->Cell(0, 10, 'Privacy Policy', 0, 1, 'C');
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

// Privacy Policy Content with Formatting
addSectionTitle($pdf, "1. Information We Collect");
addContent($pdf, "- Personal Information: Name, email address, phone number, and other contact details when you voluntarily provide them.");
addContent($pdf, "- Usage Data: Information about your interactions with our website, such as IP address, browser type, and pages visited.");

addSectionTitle($pdf, "2. How We Use Your Information");
addContent($pdf, "- Provide and improve our services.");
addContent($pdf, "- Respond to your inquiries and communicate with you.");
addContent($pdf, "- Ensure website security and prevent fraudulent activity.");

addSectionTitle($pdf, "3. Data Protection");
addContent($pdf, "We take reasonable security measures to protect your personal data from unauthorized access, disclosure, or destruction. However, no internet transmission is completely secure.");

addSectionTitle($pdf, "4. Cookies and Tracking Technologies");
addContent($pdf, "Our website may use cookies to enhance user experience. You can adjust your browser settings to refuse cookies, but some website features may not function properly.");

addSectionTitle($pdf, "5. Third-Party Services");
addContent($pdf, "We may use third-party services for analytics, payment processing, or other functionalities. These services have their own privacy policies, which we encourage you to review.");

addSectionTitle($pdf, "6. Your Rights");
addContent($pdf, "- Access, update, or delete your personal data.");
addContent($pdf, "- Withdraw consent for data processing.");
addContent($pdf, "- Lodge a complaint with a data protection authority.");

addSectionTitle($pdf, "7. Changes to This Policy");
addContent($pdf, "We may update this Privacy Policy periodically. Any changes will be posted on this page with an updated effective date.");

addSectionTitle($pdf, "8. Contact Us");
addContent($pdf, "If you have any questions about this Privacy Policy, please contact us at:");
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetTextColor(0, 51, 102); // Dark Blue
$pdf->Cell(0, 8, "Lighthouseministers23@gmail.com", 0, 1);
$pdf->Ln(5);

// Output PDF for download
$pdf->Output('privacy-policy.pdf', 'D');
?>
