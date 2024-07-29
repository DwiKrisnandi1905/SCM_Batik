
```sql
Table Users {
    user_id INT [pk, increment]
    name VARCHAR
    role VARCHAR
    address VARCHAR
    registration_date DATE
}

Table Harvest {
    harvest_id INT [pk, increment]
    user_id INT [ref: > Users.user_id]
    material_type VARCHAR
    quantity FLOAT
    quality VARCHAR
    delivery_info VARCHAR
    delivery_date DATETIME
}

Table Factory {
    factory_id INT [pk, increment]
    user_id INT [ref: > Users.user_id]
    harvest_id INT [ref: > Harvest.harvest_id]
    received_date DATETIME
    initial_process VARCHAR
    semi_finished_quantity FLOAT
    semi_finished_quality VARCHAR
}

Table Craftsman {
    craftsman_id INT [pk, increment]
    user_id INT [ref: > Users.user_id]
    factory_id INT [ref: > Factory.factory_id]
    production_details VARCHAR
    finished_quantity FLOAT
    completion_date DATETIME
}

Table Certification {
    certification_id INT [pk, increment]
    user_id INT [ref: > Users.user_id]
    craftsman_id INT [ref: > Craftsman.craftsman_id]
    test_results VARCHAR
    certificate_number VARCHAR
    issue_date DATE
}

Table WasteManagement {
    waste_id INT [pk, increment]
    user_id INT [ref: > Users.user_id]
    waste_type VARCHAR
    management_method VARCHAR
    management_results VARCHAR
}

Table Distribution {
    distribution_id INT [pk, increment]
    user_id INT [ref: > Users.user_id]
    craftsman_id INT [ref: > Craftsman.craftsman_id]
    destination VARCHAR
    quantity FLOAT
    shipment_date DATETIME
    tracking_number VARCHAR
    received_date DATETIME
    receiver_name VARCHAR
    received_condition VARCHAR
}

Table Monitoring {
    monitoring_id INT [pk, increment]
    harvest_id INT [ref: > Harvest.harvest_id]
    factory_id INT [ref: > Factory.factory_id]
    craftsman_id INT [ref: > Craftsman.craftsman_id]
    certification_id INT [ref: > Certification.certification_id]
    waste_id INT [ref: > WasteManagement.waste_id]
    distribution_id INT [ref: > Distribution.distribution_id]
    status VARCHAR
    last_updated DATETIME
}
```
