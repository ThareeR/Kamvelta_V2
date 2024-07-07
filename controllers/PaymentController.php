<?php

include_once (__DIR__. '/../models/Payment.php');

class PaymentController {

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }
    
    // Add new function to get revenue by month
    public function getRevenueByMonth($month, $year) {
        $query = "SELECT SUM(amount) AS total_revenue FROM payments WHERE MONTH(payment_date) = :month AND YEAR(payment_date) = :year";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":month", $month);
        $stmt->bindParam(":year", $year);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];
    }
    
    // Add new function to get revenue by year
    public function getRevenueByYear($year) {
        $query = "SELECT SUM(amount) AS total_revenue FROM payments WHERE YEAR(payment_date) = :year";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":year", $year);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total_revenue'];
    }
    

}

?>