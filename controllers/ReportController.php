<?php
class ReportController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAnnualRoomRevenue($year) {
        $query = "SELECT SUM(total_charge) as revenue 
                  FROM reservation_items 
                  JOIN reservations ON reservation_items.reservation_id = reservations.reservation_id
                  WHERE YEAR(reservations.booking_date) = :year";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['revenue'];
    }
    

    public function getAnnualBanquetRevenue($year) {
        $query = "SELECT SUM(amount) as revenue 
                  FROM payments 
                  WHERE YEAR(payment_date) = :year AND reservation_id IS NULL"; // Assuming banquet hall reservations don't have reservation_id
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['revenue'];
    }
    

    public function getMonthlyRoomRevenue($year, $month) {
        $query = "SELECT SUM(total_charge) as revenue 
                  FROM reservation_items 
                  JOIN reservations ON reservation_items.reservation_id = reservations.reservation_id
                  WHERE YEAR(reservations.booking_date) = :year AND MONTH(reservations.booking_date) = :month";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['revenue'];
    }
    
    public function getMonthlyRoomRevenueForYear($year) {
        $query = "SELECT MONTH(reservations.booking_date) as month, SUM(total_charge) as revenue 
                  FROM reservation_items 
                  JOIN reservations ON reservation_items.reservation_id = reservations.reservation_id
                  WHERE YEAR(reservations.booking_date) = :year
                  GROUP BY MONTH(reservations.booking_date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getMonthlyBanquetRevenue($year, $month) {
        $query = "SELECT SUM(amount) as revenue 
                  FROM payments 
                  WHERE YEAR(payment_date) = :year AND MONTH(payment_date) = :month AND reservation_id IS NULL"; // Assuming banquet hall reservations don't have reservation_id
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->bindParam(':month', $month);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['revenue'];
    }
    

    public function getRoomTypeBookings() {
        $query = "SELECT room_type.type_name, COUNT(*) as bookings 
                  FROM reservation_items 
                  JOIN room_type ON reservation_items.room_type_id = room_type.room_type_id 
                  GROUP BY room_type.type_name";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getMonthlyRoomReservationsForYear($year) {
        $query = "SELECT 
                    MONTH(reservations.booking_date) as month, 
                    COUNT(reservations.reservation_id) as reservation_count
                  FROM reservations
                  WHERE YEAR(reservations.booking_date) = :year
                  GROUP BY MONTH(reservations.booking_date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
        // Function to get annual revenue for each hall
    public function getAnnualBanquetRevenueForYear($year) {
        $query = "SELECT 
                    b.hall_id,
                    b.hall_name,
                    SUM(r.total_charge) as revenue
                FROM banquet_hall_reservations r
                JOIN banquet_hall b ON r.hall_id = b.hall_id
                WHERE YEAR(r.event_date) = :year
                GROUP BY b.hall_id, b.hall_name";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Function to get monthly revenue for each hall
    public function getMonthlyBanquetRevenueForYear($year) {
        $query = "SELECT 
                    b.hall_id,
                    b.hall_name,
                    MONTH(r.event_date) as month,
                    SUM(r.total_charge) as revenue
                FROM banquet_hall_reservations r
                JOIN banquet_hall b ON r.hall_id = b.hall_id
                WHERE YEAR(r.event_date) = :year
                GROUP BY b.hall_id, b.hall_name, MONTH(r.event_date)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':year', $year);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    
}
?>
