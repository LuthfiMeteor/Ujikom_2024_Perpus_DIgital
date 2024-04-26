<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
                CREATE TRIGGER log_update_buku AFTER UPDATE ON `buku` FOR EACH ROW
                    BEGIN
                        INSERT INTO log_buku (`nama_buku`, `kategori`, `aksi`, `updated_at`)
                        VALUES (new.judul, new.kategori, "update buku",now());
                    END
                ');
    }

    public function down()
    {
        DB::unprepared('DROP TRIGGER `log_update_buku`');
    }
};
