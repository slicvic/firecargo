<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggerUpdateWarehouseStatusInPackagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		$sql = "
CREATE TRIGGER update_warehouse_status AFTER UPDATE ON packages
FOR EACH ROW
BEGIN

	# Total packages in the warehouse
	DECLARE totalPackages integer;

	# Total packages in the warehouse that have been shipped
	DECLARE totalPackagesShipped integer;

	# Total packages in the warehouse that have NOT been shipped
	DECLARE totalPackagesUnshipped integer;

	# The new warehouse status id
	DECLARE newStatusId integer;

	SET totalPackages := (SELECT COUNT(*) FROM packages WHERE warehouse_id = NEW.warehouse_id);
	SET totalPackagesShipped := (SELECT COUNT(*) FROM packages WHERE warehouse_id = NEW.warehouse_id AND shipment_id IS NOT NULL);
	SET totalPackagesUnshipped = totalPackages - totalPackagesShipped;

	IF totalPackagesUnshipped = 0 THEN
	    # Complete (Green)
	    SET newStatusId = 3;
	ELSEIF totalPackagesUnshipped = totalPackages THEN
	    # Unprocessed (Red)
	    SET newStatusId = 1;
	ELSE
	    # Pending (Yellow)
	    SET newStatusId = 2;
	END IF;

	UPDATE warehouses SET status_id = newStatusId WHERE id = NEW.warehouse_id;

END;
";
		DB::unprepared($sql);
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		DB::unprepared('DROP TRIGGER IF EXISTS packages.update_warehouse_status');
	}
}
