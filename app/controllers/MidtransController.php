<?php
namespace Controllers;
use Models\Tagihan;
use Models\Siswa;
use Models\Transaksi;
/**
 *
 */
class MidtransController {

	public $default_url = 'wp-admin/tagihan-spp/';

	public function pay ( $id_transaksi ) {

		try {

			// Set your Merchant Server Key
			\Midtrans\Config::$serverKey = 'SB-Mid-server-dNQyfhyfOPr52DOn-R8JicVz';
			\Midtrans\Config::$clientKey = 'SB-Mid-client-1yQTBnMF78t4l6oG';
			// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
			\Midtrans\Config::$isProduction = false;
			// Set sanitization on (default)
			\Midtrans\Config::$isSanitized = true;
			// Set 3DS transaction for credit card to true
			\Midtrans\Config::$is3ds = true;

			$select_query 	= array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'transaksi.status as status_transaksi', 'tagihan.nama_tagihan', 'tagihan.*' );
			$transaction 	= Transaksi::leftJoin('siswa', function($join) {
	        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
	        })
	        ->leftJoin('tagihan', function($join) {
	        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
	        })
	        ->select($select_query)
	        ->where( [
	        	[ 'transaksi.id', '=', $id_transaksi ]
	        ] )
	        ->first()->toArray();

	        if ( empty( $transaction ) ) {
	        	throw new Exception("Transaksi Data Tidak Valid", 1);
	        }

			$params = array(
			    'transaction_details' => array(
			        'order_id' 				=> 'spp-o-' . $id_transaksi,
			        'gross_amount' 			=> $transaction['total_tagihan']
			    ),
			    'item_details' => array(
			    	array(
				    	'id' 		=> $id_transaksi,
				        'price' 	=> (int) $transaction['total_tagihan'],
				        'quantity' 	=> 1,
				        'name' 		=> $transaction['nama_tagihan'],
				    )
			    ),
			    'customer_details' => array(
			    	'first_name' 	=> $transaction['nama_lengkap'],
			    	'last_name'		=> '',
			    )
			);

			$snapToken = \Midtrans\Snap::getSnapToken($params);

			$data = array(
				'snap_token' => $snapToken
			);

		} catch (\Exception $e) {
			dd( $e->getMessage() );
		}

		view()->render( 'parts/user-dashboard/midtrans', $data );
	}

	public function getUpdate () {

		try {

			\Midtrans\Config::$isProduction = false;
			\Midtrans\Config::$serverKey = 'SB-Mid-server-dNQyfhyfOPr52DOn-R8JicVz';
			$notif = new \Midtrans\Notification();

			$transaction 	= $notif->transaction_status;
			$type 			= $notif->payment_type;
			$order_id 		= $notif->order_id;
			$fraud 			= $notif->fraud_status;

			$order_format 	= explode( '-', $order_id );
			$order_id 		= (int) end( $order_format );

			$transaksi = Transaksi::findOrFail( $order_id );

			if ($transaction == 'capture') {

				// For credit card transaction, we need to check whether transaction is challenge by FDS or not
				$transaksi->update( array( 'status' => 'completed' ) );

			} elseif ( in_array( $transaction, array( 'cancel', 'failure' ) ) ) {

				$transaksi->update( array( 'status' => 'failed' ) );

			} else {

				$transaksi->update( array( 'status' => 'pending' ) );
			}

		} catch (\Exception $e) {

		}

		wp_send_json( ['result'=>'ok'] );
	}

	public function view ( $id ) {
		echo $id;
	}

	public function cekPayment ( $transaction_id ) {

		try {

			\Midtrans\Config::$isProduction = false;
			\Midtrans\Config::$serverKey = 'SB-Mid-server-dNQyfhyfOPr52DOn-R8JicVz';

			$order_id = 'spp-o-' . $transaction_id;

			$status_response = \Midtrans\Transaction::status( $order_id );

			$transaction 	= $status_response->transaction_status;
			$type 			= $status_response->payment_type;
			$order_id 		= $status_response->order_id;
			$fraud 			= $status_response->fraud_status;

			$order_format 	= explode( '-', $order_id );
			$order_id 		= (int) end( $order_format );

			$transaksi = Transaksi::findOrFail( $order_id );

			if ( 'capture' !== $transaction ) {
				$transaksi->update( array( 'status' => 'pending' ) );
			}

			$response = array(
				'success' => true,
				'type'    => 'success',
				'title'   => 'Success',
				'message' => 'Transaksi Ditemukan dan Berhasil Di update'
			);

		} catch (\Exception $e) {

			$response = array(
				'success' => false,
				'type'    => 'error',
				'title'   => 'Error',
				'message' => 'Anda Belum Melakukan proses transaksi untuk tagihan ini'
			);

		}

		wp_send_json( $response );
	}

	public function confirmation ( $transaction_id ) {
		try {

			\Midtrans\Config::$isProduction = false;
			\Midtrans\Config::$serverKey = 'SB-Mid-server-dNQyfhyfOPr52DOn-R8JicVz';

			$order_id = 'spp-o-' . $transaction_id;

			$status_response = \Midtrans\Transaction::status( $order_id );

			$transaction 	= $status_response->transaction_status;
			$type 			= $status_response->payment_type;
			$order_id 		= $status_response->order_id;
			$fraud 			= $status_response->fraud_status;

			$order_format 	= explode( '-', $order_id );
			$order_id 		= (int) end( $order_format );

			$transaksi = Transaksi::findOrFail( $order_id );

			if ( 'capture' !== $transaction ) {
				throw new Exception( " Status Transaksi Masih dalam prosess input admin " );
			} else {
				$transaksi->update( array( 'status' => 'completed' ) );
			}

			$response = array(
				'success' => true,
				'type'    => 'success',
				'title'   => 'Success',
				'message' => 'Transaksi Ditemukan dan Sudah Terkonfirmasi di bayar'
			);

		} catch (\Exception $e) {

			$response = array(
				'success' => false,
				'type'    => 'error',
				'title'   => 'Error',
				'message' => $e->getMessage()
			);

		}

		wp_send_json( $response );
	}
}