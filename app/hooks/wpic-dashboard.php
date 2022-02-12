<?php
use Models\Users;
use Models\Siswa;
use Models\Kelas;
use Models\Tagihan;
use Models\Transaksi;
use Models\Wali;
/**
 *
 */
class DashboardApp {
	protected $pathDist;

	// if you want to activated this class just set from unregister to register
	public function register(){
		$this->pathDist = untrailingslashit( WCIC()->get_path( 'dist', true ) );
	}

	public function init(){
		add_action( 'user_init', array( $this, 'add_user_dashboard_page' ) );
		add_action( 'admin_init', array( $this, 'add_menu_dashboard_page' ) );
		add_action( 'render_main_dashboard', array( $this, 'render_data_siswa' ) );
	}

	// Fungsi ini untuk membuat menu dan halaman baru untuk sisi admin dashboard
	public function add_menu_dashboard_page (  ) {

		add_dashboard_page(
			'kelas',
			__( 'Data Kelas Baru', 'wpic' ),
			'manage',
			'kelas',
			array( $this, 'render_kelas_spp' ),
			'ni ni-shop'
		);

		add_dashboard_page(
			'tagihan-spp',
			__( 'Data Tagihan', 'wpic' ),
			'manage',
			'tagihan-spp',
			array( $this, 'render_tagihan_spp' ),
			'ni ni-shop'
		);

		add_dashboard_page(
			'cek-pembayaran',
			__( 'Cek Pembayaran', 'wpic' ),
			'manage',
			'cek-pembayaran',
			array( $this, 'render_cek_pembayaran' ),
			'ni ni-shop'
		);

		add_dashboard_page(
			'laporan-pembayaran',
			__( 'Laporan Transaksi Siswa', 'wpic' ),
			'manage',
			'laporan-pembayaran',
			array( $this, 'render_laporan_pembayaran' ),
			'ni ni-shop'
		);

		add_dashboard_page(
			'kelola-user',
			__( 'Kelola User', 'wpic' ),
			'manage',
			'kelola-user',
			array( $this, 'render_kelola_user' ),
			'ni ni-shop'
		);
	}

	public function render_kelola_user () {
		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $form_url = $user = $extra =array();
		$method 	= '';

		switch ( $context ) {
			case 'add':
				$template = 'add-edit.php';
				$form_url = 'add.user';
				$method   = 'post';
				break;
			case 'edit':
				$template = 'add-edit.php';
				$form_url = 'update.user';
				$form_param = array( 'id' => $id );
				$method   	= 'post';
				$user 		= Users::find( $id );
				break;
			case 'view':
				$template = 'view.php';
				$user 		= Users::find( $id );
				$extra 		= Users::get_columns_fillable();
				break;
			default:
				$form_url 	= '';
				$template 	= 'main.php';
				$method   	= 'get';
				$user 		= Users::all();
				break;
		}

		$data = array(
			'template' 		=> $template,
			'context' 		=> $context,
			'form_url' 		=> array(
				'url' 		=> $form_url,
				'params' 	=> $form_param
			),
			'method' 		=> $method,
			'user' 			=> $user,
			'extra' 		=> $extra,
			'token' 		=> csrf_token()
		);

		view()->render( 'parts/dashboard/spp-user-content', $data );
	}

	// Fungsi ini untuk membuat menu dan halaman baru untuk sisi user dashboard
	public function add_user_dashboard_page( ){

		add_dashboard_page(
			'dashboard.user',
			__( 'Dashboard User', 'wpic' ),
			'manage-account',
			'dashboard',
			array( $this, 'render_user_dashboard' ),
			'ni ni-shop'
		);

		add_dashboard_page(
			'tagihan.user',
			__( 'Tagihan Sekolah', 'wpic' ),
			'manage-account',
			'tagihan-spp',
			array( $this, 'render_user_tagihan_view' ),
			'ni ni-shop'
		);
	}

	function render_laporan_pembayaran ( ) {

		$select_query 	= array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'siswa.kelas_id', 'transaksi.status as status_transaksi', 'tagihan.nama_tagihan', 'tagihan.*' );
		$transaction 	= Transaksi::leftJoin('siswa', function($join) {
        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
        })
        ->leftJoin('tagihan', function($join) {
        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
        })
        ->select($select_query)
        ->get()->toArray();

		view()->render( 'parts/dashboard/spp-laporan-pembayaran', array( 'transactions' => $transaction ) );
	}

	// Fungsi ini diproses ketika menu kelas di tekan
	// Dan fungsi ini menampilkan output html sesuai kontextnya
	public function render_kelas_spp () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $form_url = $kelas = $extra =array();
		$method 	= '';

		switch ( $context ) {
			case 'add':
				$template = 'add-edit.php';
				$form_url = 'add.kelas';
				$method   = 'post';
				break;
			case 'edit':
				$template = 'add-edit.php';
				$form_url = 'update.kelas';
				$form_param = array( 'id' => $id );
				$method   	= 'post';
				$kelas 		= Kelas::find( $id );
				break;
			case 'view':
				$template = 'view.php';
				$kelas 		= Kelas::find( $id );
				$extra 		= Kelas::get_columns_fillable();
				break;
			default:
				$form_url 	= '';
				$template 	= 'main.php';
				$method   	= 'get';
				$kelas 		= Kelas::all();
				break;
		}

		$data = array(
			'template' 		=> $template,
			'context' 		=> $context,
			'form_url' 		=> array(
				'url' 		=> $form_url,
				'params' 	=> $form_param
			),
			'method' 		=> $method,
			'kelas' 		=> $kelas,
			'extra' 		=> $extra,
			'token' 		=> csrf_token()
		);

		view()->render( 'parts/dashboard/spp-kelas-content', $data );
	}

	// Fungsi ini diproses ketika menu tagihan di tekan
	// Dan fungsi ini menampilkan output html sesuai kontextnya
	public function render_tagihan_spp () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $form_url = $tagihan = $extra =array();
		$method 	= '';

		$select_query = array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.kelas_id', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'transaksi.status as status_transaksi', 'transaksi.id as transaksi_id', 'tagihan.nama_tagihan', 'tagihan.*' );

		switch ( $context ) {
			case 'add':
				$template = 'add-edit.php';
				$form_url = 'add.tagihan';
				$method   = 'post';
				break;
			case 'edit':
				$template = 'add-edit.php';
				$form_url = 'update.tagihan';
				$form_param = array( 'id' => $id );
				$method   	= 'post';
				$tagihan 	= Tagihan::find($id);
				break;
			case 'view':
				$template = 'view.php';
				$tagihan  = Tagihan::find( $id );
				$extra 	  = Transaksi::leftJoin('siswa', function($join) {
		        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
		        })
		        ->leftJoin('tagihan', function($join) {
		        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
		        })
		        ->select($select_query)
		        ->where( [
		        	[ 'transaksi.id_tagihan', '=', $id ],
		        	[ 'transaksi.status', '=', 'completed' ]
		        ] )
		        ->get()->toArray();
				break;
			default:
				$form_url = '';
				$method   = 'get';
				$template = 'main.php';
				$tagihan 	= Tagihan::all();
				break;
		}

		$data = array(
			'template' 		=> $template,
			'context' 		=> $context,
			'form_url' 		=> array(
				'url' 		=> $form_url,
				'params' 	=> $form_param
			),
			'method' 		=> $method,
			'tagihan' 		=> $tagihan,
			'extra' 		=> $extra,
			'token' 		=> csrf_token()
		);

		view()->render( 'parts/dashboard/spp-tagihan-spp-content', $data );
	}

	// Fungsi ini diproses ketika menu kelas di tekan
	// Dan fungsi ini menampilkan output html sesuai kontextnya
	public function render_data_siswa () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $form_url = $siswa = $extra = $privelege = array();
		$method 	= '';

		switch ( $context ) {
			case 'add':
				$template = 'add-edit.php';
				$form_url = 'add.siswa';
				$method   = 'post';
				break;
			case 'edit':
				$template = 'add-edit.php';
				$form_url = 'update.siswa';
				$form_param = array( 'id' => $id );
				$method   	= 'post';
				$siswa 		= Siswa::find( $id );
				$privelege 	= Users::find( $siswa->id_privelege );
				break;
			case 'view':
				$template = 'view.php';
				$siswa 		= Siswa::find( $id );
				break;
			default:
				$form_url 	= '';
				$template 	= 'main.php';
				$method   	= 'get';
				$siswa 		= Siswa::all();
				break;
		}

		$data = array(
			'template' 		=> $template,
			'context' 		=> $context,
			'form_url' 		=> array(
				'url' 		=> $form_url,
				'params' 	=> $form_param
			),
			'method' 		=> $method,
			'siswa' 		=> $siswa,
			'privelege' 	=> $privelege,
			'token' 		=> csrf_token()
		);

		view()->render( 'parts/dashboard/spp-user-manage-content', $data );
	}

	// Fungsi ini diproses ketika menu tagihan dari sisi user dashboard di tekan
	// Dan fungsi ini menampilkan output html sesuai kontextnya
	public function render_user_tagihan_view () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$user_id 	= get_current_user_id();
		$siswa 		= Siswa::select('id')->where( 'id_privelege', $user_id )->first()->toArray();
		$siswa_id 	= $siswa['id'];

		$select_query = array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'transaksi.status as status_transaksi', 'transaksi.id as transaksi_id', 'tagihan.nama_tagihan', 'tagihan.*' );

		if ( $context === 'view' ) {

			$transaksi = Transaksi::find( $id );

			if ( empty( $transaksi ) ) {
				throw new \Exception("Transaksi tidak ditemukan", 1);
			}

			$template = 'view-transaksi';

			\Midtrans\Config::$isProduction = ( 'production' === ENV );
			\Midtrans\Config::$serverKey = MIDTRANS_SERVER_KEY;

			$order_id = 'spp-o-' . $id;

			$status_response = (array) \Midtrans\Transaction::status( $order_id );

			$select_query 	= array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'transaksi.status as status_transaksi', 'tagihan.nama_tagihan', 'tagihan.*' );
			$transaction 	= Transaksi::leftJoin('siswa', function($join) {
	        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
	        })
	        ->leftJoin('tagihan', function($join) {
	        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
	        })
	        ->select($select_query)
	        ->where( [
	        	[ 'transaksi.id', '=', $id ]
	        ] )
	        ->first()->toArray();

			$data = array(
				'midtrans' => array(
					'no_rekening_tujuan' 	=> current($status_response['va_numbers'])->va_number,
					'nama_rekening_tujuan' 	=> current($status_response['va_numbers'])->bank,
					'type_pembayaran' 		=> $status_response['payment_type'],
					'status_pembayaran' 	=> $status_response['transaction_status'],
				),
				'tagihan' => $transaction
			);
		} else {

			$template = 'spp-tagihan-content';

			$on_process = Siswa::leftJoin('transaksi', function($join) {
	        	$join->on('siswa.id', '=', 'transaksi.id_siswa');
	        })
	        ->leftJoin('tagihan', function($join) {
	        	$join->on('tagihan.id', '=', 'transaksi.id_tagihan');
	        })
	        ->select($select_query)
	        ->where( [
	        	[ 'siswa.id', '=', $siswa_id ],
	        	[ 'transaksi.status', '=', 'on-process' ]
	        ] )
	        ->get()->toArray();

			$pending = Siswa::leftJoin('transaksi', function($join) {
	        	$join->on('siswa.id', '=', 'transaksi.id_siswa');
	        })
	        ->leftJoin('tagihan', function($join) {
	        	$join->on('tagihan.id', '=', 'transaksi.id_tagihan');
	        })
	        ->select($select_query)
	        ->where( [
	        	[ 'siswa.id', '=', $siswa_id ],
	        	[ 'transaksi.status', '=', 'pending' ]
	        ] )
	        ->get()->toArray();

	        $completed = Siswa::leftJoin('transaksi', function($join) {
	        	$join->on('siswa.id', '=', 'transaksi.id_siswa');
	        })
	        ->leftJoin('tagihan', function($join) {
	        	$join->on('tagihan.id', '=', 'transaksi.id_tagihan');
	        })
	        ->select($select_query)
	        ->where([
	        	[ 'siswa.id', '=', $siswa_id ],
	        	[ 'transaksi.status', '=', 'completed' ]
	        ])
	        ->get()->toArray();

			$data = array(
				'context' => $context,
				'tagihan' => array(
					'on_process' => $on_process,
					'pending' 	=> $pending,
					'completed' => $completed
				)
			);
		}

		view()->render( "parts/user-dashboard/{$template}", $data );
	}

	// Fungsi ini diproses ketika menu cek pembayaran dari sisi admin dashboard di tekan
	// Dan fungsi ini menampilkan output html sesuai kontextnya
	public function render_cek_pembayaran ( ) {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $tagihan = $transaction = array();
		$form_url 	= '';
		$template 	= 'main.php';
		$select_query = array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'transaksi.status as status_transaksi', 'transaksi.id as transaksi_id', 'tagihan.nama_tagihan', 'tagihan.*' );

		switch ( $context ) {
			case 'edit':
				$template = 'edit.php';
				$form_url = 'update.pembayaran';
				$form_param = array( 'id' => $id );
				$method   	= 'post';
				$transaction 	= Transaksi::leftJoin('siswa', function($join) {
		        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
		        })
		        ->leftJoin('tagihan', function($join) {
		        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
		        })
		        ->select($select_query)
		        ->where( [
		        	[ 'transaksi.id', '=', $id ]
		        ] )
		        ->first()->toArray();
				break;
			case 'view':

				if ( isset( $_GET['details-id'] ) ) {

					$transaction_id = (int) $_GET['details-id'];

					$transaksi = Transaksi::find( $transaction_id );

					if ( empty( $transaksi ) ) {
						throw new \Exception("Transaksi tidak ditemukan", 1);
					}

					$template = 'view-transaksi';

					\Midtrans\Config::$isProduction = ( 'production' === ENV );
					\Midtrans\Config::$serverKey = MIDTRANS_SERVER_KEY;

					$order_id = 'spp-o-' . $id;

					$status_response = (array) \Midtrans\Transaction::status( $order_id );

					$select_query 	= array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'transaksi.status as status_transaksi', 'tagihan.nama_tagihan', 'tagihan.*' );
					$transaction 	= Transaksi::leftJoin('siswa', function($join) {
			        	$join->on('transaksi.id_siswa', '=', 'siswa.id');
			        })
			        ->leftJoin('tagihan', function($join) {
			        	$join->on('transaksi.id_tagihan', '=', 'tagihan.id');
			        })
			        ->select($select_query)
			        ->where( [
			        	[ 'transaksi.id', '=', $id ]
			        ] )
			        ->first()->toArray();

					$data = array(
						'midtrans' => array(
							'no_rekening_tujuan' 	=> current($status_response['va_numbers'])->va_number,
							'nama_rekening_tujuan' 	=> current($status_response['va_numbers'])->bank,
							'type_pembayaran' 		=> $status_response['payment_type'],
							'status_pembayaran' 	=> $status_response['transaction_status'],
						),
						'tagihan' => $transaction
					);

					view()->render( 'parts/user-dashboard/view-transaksi', $data );

					exit();
				}

				$template = 'view.php';
				$tagihan['pending'] = Siswa::leftJoin('transaksi', function($join) {
		        	$join->on('siswa.id', '=', 'transaksi.id_siswa');
		        })
		        ->leftJoin('tagihan', function($join) {
		        	$join->on('tagihan.id', '=', 'transaksi.id_tagihan');
		        })
		        ->select($select_query)
		        ->where( [
		        	[ 'siswa.id', '=', $id ],
		        	[ 'transaksi.status', '=', 'pending' ]
		        ] )
		        ->get()->toArray();

		        $tagihan['completed'] = Siswa::leftJoin('transaksi', function($join) {
		        	$join->on('siswa.id', '=', 'transaksi.id_siswa');
		        })
		        ->leftJoin('tagihan', function($join) {
		        	$join->on('tagihan.id', '=', 'transaksi.id_tagihan');
		        })
		        ->select($select_query)
		        ->where([
		        	[ 'siswa.id', '=', $id ],
		        	[ 'transaksi.status', '=', 'completed' ]
		        ])
		        ->get()->toArray();
				break;
		}

		$data = array(
			'template' 		=> $template,
			'context' 		=> $context,
			'form_url' 		=> array(
				'url' 		=> $form_url,
				'params' 	=> $form_param
			),
			'tagihan' => $tagihan,
			'transaction_details' => $transaction
		);

		view()->render( 'parts/dashboard/spp-cek-pembayaran', $data );
	}

	public function render_user_dashboard(){
		$siswa = Siswa::where( 'id_privelege', get_current_user_id() )->first()->toArray();
		view()->render( 'parts/user-dashboard/main-content', [ 'siswa' => $siswa ] );
	}

 	public static function dashboard_content_example(){

 		if ( isset( $_GET['profile'] ) && !empty( $_GET['profile'] ) ) {
 			echo "profile";
 			return;
 		}

 		view()->render( 'parts/dashboard/example' );
 	}
}