<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class QrDokter extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id' => [
				'type' 				=> 'INT',
				'contsraint' 		=> 5,
				'unsigned' 			=> true,
				'auto_increment'	=> true
			],
			'id_dokter' => [
				'type'				=> 'INT',
				'constraint'		=> 5,
			],
			'qr_code' => [
				'type'				=> 'VARCHAR',
				'constraint'		=> '255',
				'null'				=> true
			],
			'created_by INT NULL',
			'updated_by INT NULL',
			'created_at DATETIME',
			'updated_at DATETIME null'
		]);
		// Membuat primary key
		$this->forge->addKey('id', TRUE);

		// Membuat tabel news
		$this->forge->createTable('qr_dokter', TRUE);
	}

	//--------------------------------------------------------------------

	public function down()
	{
		$this->forge->dropTable('qr_dokter');
	}
}
