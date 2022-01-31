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
			\Midtrans\Config::$serverKey = MIDTRANS_SERVER_KEY;
			\Midtrans\Config::$clientKey = MIDTRANS_CLIENT_KEY;
			// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
			\Midtrans\Config::$isProduction = ( 'production' === ENV );
			// Set sanitization on (default)
			\Midtrans\Config::$isSanitized = true;
			// Set 3DS transaction for credit card to true
			\Midtrans\Config::$is3ds = false;

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
				'snap_token' => $snapToken,
				'client_key' => MIDTRANS_CLIENT_KEY,
				'is_production' => ( 'production' === ENV )
			);

		} catch (\Exception $e) {
			dd( $e->getMessage() );
		}

		view()->render( 'parts/user-dashboard/midtrans', $data );
	}

	public function getUpdate () {

		try {

			\Midtrans\Config::$isProduction = ( 'production' === ENV );
			\Midtrans\Config::$serverKey = MIDTRANS_SERVER_KEY;
			$notif = new \Midtrans\Notification();

			$transaction 	= $notif->transaction_status;
			$type 			= $notif->payment_type;
			$order_id 		= $notif->order_id;
			$fraud 			= $notif->fraud_status;

			$order_format 	= explode( '-', $order_id );
			$order_id 		= (int) end( $order_format );

			$transaksi = Transaksi::findOrFail( $order_id );

			if ( in_array( $transaction , array( 'settlement', 'capture' ) )  ) {
				// For credit card transaction, we need to check whether transaction is challenge by FDS or not
				$transaksi->update( array( 'status' => 'completed' ) );
			}
			elseif ( $transaction === 'pending' ) {
				// processed
				$transaksi->update( array( 'status' => 'on-process' ) );
			} elseif ( in_array( $transaction, array( 'cancel', 'failure' ) ) ) {

				$transaksi->update( array( 'status' => 'failed' ) );

			} else {

				$transaksi->update( array( 'status' => 'pending' ) );
			}

		} catch (\Exception $e) {

		}

		wp_send_json( ['result'=>'ok'] );
	}

	public function cekPayment ( $transaction_id ) {

		try {

			\Midtrans\Config::$isProduction = ( 'production' === ENV );
			\Midtrans\Config::$serverKey = MIDTRANS_SERVER_KEY;

			$order_id = 'spp-o-' . $transaction_id;

			$status_response = \Midtrans\Transaction::status( $order_id );

			$transaction 	= $status_response->transaction_status;
			$type 			= $status_response->payment_type;
			$order_id 		= $status_response->order_id;
			$fraud 			= $status_response->fraud_status;

			$order_format 	= explode( '-', $order_id );
			$order_id 		= (int) end( $order_format );

			$transaksi = Transaksi::findOrFail( $order_id );

			if ( in_array( $transaction , array( 'settlement', 'capture' ) )  ) {
				// For credit card transaction, we need to check whether transaction is challenge by FDS or not
				$transaksi->update( array( 'status' => 'completed' ) );
			}
			elseif ( $transaction === 'pending' ) {
				// processed
				$transaksi->update( array( 'status' => 'on-process' ) );
			} elseif ( in_array( $transaction, array( 'cancel', 'failure' ) ) ) {
				// failed
				$transaksi->update( array( 'status' => 'failed' ) );
			} else {
				// pending
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

			\Midtrans\Config::$isProduction = ( 'production' === ENV );
			\Midtrans\Config::$serverKey = MIDTRANS_SERVER_KEY;

			$order_id = 'spp-o-' . $transaction_id;

			$status_response = \Midtrans\Transaction::status( $order_id );

			$transaction 	= $status_response->transaction_status;
			$type 			= $status_response->payment_type;
			$order_id 		= $status_response->order_id;
			$fraud 			= $status_response->fraud_status;

			$order_format 	= explode( '-', $order_id );
			$order_id 		= (int) end( $order_format );

			$transaksi = Transaksi::findOrFail( $order_id );

			if ( 'settlement' !== $transaction ) {
				throw new \Exception( " Status Transaksi Masih dalam prosess input admin " );
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