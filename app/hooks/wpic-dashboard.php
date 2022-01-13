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

	public function add_menu_dashboard_page (  ) {

		add_dashboard_page(
			'kelas',
			__( 'Data Kelas', 'wpic' ),
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
	}

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

	public function render_kelas_spp () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $kelas = array();

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
			'token' 		=> csrf_token()
		);

		view()->render( 'parts/dashboard/spp-kelas-content', $data );
	}

	public function render_tagihan_spp () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $tagihan = array();

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
			'token' 		=> csrf_token()
		);

		view()->render( 'parts/dashboard/spp-tagihan-spp-content', $data );
	}

	public function render_data_siswa () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		if ( input()->exists('id') ) {
			$id = input()->get('id')->value;
		}

		$form_param = $siswa = $privelege = array();

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

	public function render_user_tagihan_view () {

		$context = $id = null;

		if ( input()->exists('context') ) {
			$context = input()->get('context')->value;
		}

		$user_id 	= get_current_user_id();
		$siswa 		= Siswa::select('id')->where( 'id_privelege', $user_id )->first()->toArray();
		$siswa_id 	= $siswa['id'];

		$select_query = array( 'siswa.nama_lengkap', 'siswa.nis', 'siswa.nama_wali', 'siswa.jenis_kelamin', 'siswa.tahun_ajaran', 'transaksi.status as status_transaksi', 'transaksi.id as transaksi_id', 'tagihan.nama_tagihan', 'tagihan.*' );

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

		view()->render( 'parts/user-dashboard/spp-tagihan-content', $data );
	}

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
		view()->render( 'parts/dashboard/main-content' );
	}

 	public static function dashboard_content_example(){

 		if ( isset( $_GET['profile'] ) && !empty( $_GET['profile'] ) ) {
 			echo "profile";
 			return;
 		}

 		view()->render( 'parts/dashboard/example' );
 	}
}