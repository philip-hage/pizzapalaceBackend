<?php

class VehicleModel
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getVehicles()
    {
        $this->db->query("SELECT v.vehicleId,
                                 v.vehicleStoreId,
                                 v.vehicleName,
                                 v.vehicleType,
                                 v.vehicleCreateDate,
                                 v.vehicleMaintenanceDate,
                                 s.storeName
                                 FROM vehicles as v
                                 INNER JOIN stores as s ON v.vehicleStoreId = s.storeId
                                 WHERE vehicleIsActive = 1");
        return $this->db->resultSet();
    }

    public function getVehicleById($vehicleId)
    {
        $this->db->query("SELECT v.vehicleId,
        v.vehicleStoreId,
        v.vehicleName,
        v.vehicleType,
        v.vehicleCreateDate,
        v.vehicleMaintenanceDate,
        s.storeName
        FROM vehicles as v
        INNER JOIN stores as s ON v.vehicleStoreId = s.storeId
        WHERE vehicleIsActive = 1 AND v.vehicleId = :id");
        $this->db->bind(":id", $vehicleId);
        return $this->db->single();
    }

    public function create($post)
    {
        global $var;
        $vehicleCreateDate = $var['timestamp']; // Original Unix timestamp for vehicleCreateDate

        // Calculate the DateTime for vehicleCreateDate
        $dateTimeCreateDate = new DateTime("@$vehicleCreateDate");

        // Add three months to the DateTime
        $dateTimeMaintenanceDate = $dateTimeCreateDate->add(new DateInterval('P3M'));

        // Get the Unix timestamp for vehicleMaintenanceDate
        $vehicleMaintenanceDate = $dateTimeMaintenanceDate->getTimestamp();

        $this->db->query("INSERT INTO vehicles (
                                        vehicleId,
                                        vehicleStoreId,
                                        vehicleName,
                                        vehicleType,
                                        vehicleCreateDate,
                                        vehicleMaintenanceDate
                                    ) VALUES (
                                        :id, :vehicleStoreId, :vehicleName, :vehicleType, :vehicleCreateDate, :vehicleMaintenanceDate
                                    )");
        $this->db->bind(":id", $var['rand']);
        $this->db->bind(":vehicleStoreId", $post["vehicleStoreId"]);
        $this->db->bind(":vehicleName", $post["vehicleName"]);
        $this->db->bind(":vehicleType", $post["vehicleType"]);
        $this->db->bind(":vehicleCreateDate", $vehicleCreateDate);
        $this->db->bind(":vehicleMaintenanceDate", $vehicleMaintenanceDate);
        return $this->db->execute();
    }

    public function getVehicleByStore($storeId)
    {
        $this->db->query("SELECT v.vehicleId,
                                 v.vehicleStoreId,
                                 v.vehicleName,
                                 v.vehicleType,
                                 v.vehicleCreateDate,
                                 v.vehicleMaintenanceDate,
                                 s.storeName
                                 FROM vehicles as v
                                 INNER JOIN stores as s ON v.vehicleStoreId = s.storeId
                                 WHERE vehicleIsActive = 1 AND v.vehicleStoreId = :storeId");
        $this->db->bind(':storeId', $storeId);
        return $this->db->resultSet();
    }

    public function update($post)
    {
        $this->db->query("UPDATE vehicles SET vehicleName = :vehicleName,
                                                vehicleStoreId = :vehicleStoreId,
                                                vehicleType = :vehicleType
                    WHERE vehicleId = :id");
        $this->db->bind(':id', $post['id']);
        $this->db->bind(':vehicleName', $post['vehicleName']);
        $this->db->bind(':vehicleStoreId', $post['vehicleStoreId']);
        $this->db->bind(':vehicleType', $post['vehicleType']);
        $this->db->execute();
    }

    public function delete($vehicleId)
    {
        $this->db->query("UPDATE vehicles SET vehicleIsActive = 0 WHERE vehicleId = :id");
        $this->db->bind(':id', $vehicleId);
        $this->db->execute();
    }
}
