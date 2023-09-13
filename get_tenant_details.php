<?php
// Include your database connection code here
require 'includes/dbh.inc.php';

// Get the selected tenant ID from the AJAX request
$selectedTenantId = $_GET['tenant_id'];

// Fetch tenant details from the rental_tbl based on renterid
$sql = "SELECT rt.stallname, rt.stallno, rt.marketfee, rt.rent_started, t.tenant_lname
        FROM rental_tbl rt
        INNER JOIN tenants t ON rt.renterid = t.tenantid
        WHERE rt.renterid = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $selectedTenantId);
$stmt->execute();
$stmt->bind_result($stallname, $stallno, $marketfee, $rent_started, $tenant_lname);

// Check if a tenant with the given ID exists
if ($stmt->fetch()) {
    // Calculate the number of months between rent_started and the current date
    $rentStartedDate = new DateTime($rent_started);
    $currentDate = new DateTime();
    $monthsDiff = $rentStartedDate->diff($currentDate)->m + ($rentStartedDate->diff($currentDate)->y * 12);

    // Calculate unpaid amount based on monthsDiff
    $unpaidAmount = $monthsDiff > 0 ? $marketfee : 0;

    // Close the previous statement and result set
    $stmt->close();

    // Check if there are existing payments for this tenant
    $sql = "SELECT SUM(p.amount) AS totalPaidAmount
            FROM rental_tbl rt
            LEFT JOIN payments_tbl p ON rt.rentalid = p.stall_id
            WHERE rt.renterid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $selectedTenantId);
    $stmt->execute();
    $stmt->bind_result($totalPaidAmount);

    if ($stmt->fetch()) {
        // Deduct the total paid amount from the unpaid amount
        $unpaidAmount -= $totalPaidAmount;
    }

    // Calculate payment status
    $paymentStatus = '';
    if ($unpaidAmount <= 0) {
        $paymentStatus = 'Paid';
    } elseif ($monthsDiff > 0) {
        $paymentStatus = 'Unpaid';
    } elseif ($monthsDiff == 0 && $currentDate->format('d') <= 20) {
        $paymentStatus = 'Unpaid';
    } elseif ($monthsDiff == 0 && $currentDate->format('d') > 20) {
        $paymentStatus = 'Overdue';
    }

    // Return the tenant details as HTML
    echo "<h5>Details:</h5>";
    echo "<p>Tenant Name: $tenant_lname</p>"; // Tenant Name
    echo "<p>Stall Name: $stallname</p>";       // Stall Name
    echo "<p>Stall No: $stallno</p>";           // Stall No
    echo "<p>Market Fee: $marketfee</p>";       // Market Fee
    echo "<p>Unpaid Amount: $unpaidAmount</p>"; // Unpaid Amount
    echo "<p>Payment Status: $paymentStatus</p>"; // Payment Status
} else {
    echo "Tenant not found";
}

// Close the statement and database connection
$stmt->close();
$conn->close();
?>
