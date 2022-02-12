<?php
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;
use Models\Kelas;
use Delight\Cookie\Session;
use Dompdf\Dompdf;

/**
 * Add custom function collections
 *
 * supports the following functions:
 * - wcic-functions
 */
include_once( 'function-collections/wcic-function.php' );

/**
 * Get url for a route by using either name/alias, class or method name.
 *
 * The name parameter supports the following values:
 * - Route name
 * - Controller/resource name (with or without method)
 * - Controller class name
 *
 * When searching for controller/resource by name, you can use this syntax "route.name@method".
 * You can also use the same syntax when searching for a specific controller-class "MyController@home".
 * If no arguments is specified, it will return the url for the current loaded route.
 *
 * @param string|null $name
 * @param string|array|null $parameters
 * @param array|null $getParams
 * @return \Pecee\Http\Url
 * @throws \InvalidArgumentException
 */
function url(?string $name = null, $parameters = null, ?array $getParams = null): Url
{
    return Router::getUrl($name, $parameters, $getParams);
}

/**
 * @return \Pecee\Http\Response
 */
function response(): Response
{
    return Router::response();
}

/**
 * @return \Pecee\Http\Request
 */
function request(): Request
{
    return Router::request();
}

/**
 * Get input class
 * @param string|null $index Parameter index name
 * @param string|null $defaultValue Default return value
 * @param array ...$methods Default methods
 * @return \Pecee\Http\Input\InputHandler|array|string|null
 */
function input($index = null, $defaultValue = null, ...$methods)
{
    if ($index !== null) {
        return request()->getInputHandler()->value($index, $defaultValue, ...$methods);
    }

    return request()->getInputHandler();
}

/**
 * @param string $url
 * @param int|null $code
 */
function redirect(string $url, ?int $code = null): void
{
    if ($code !== null) {
        response()->httpCode($code);
    }

    response()->redirect($url);
}

/**
 * Get current csrf-token
 * @return string|null
 */
function csrf_token(): ?string
{
    $baseVerifier = Router::router()->getCsrfVerifier();
    if ($baseVerifier !== null) {
        return $baseVerifier->getTokenProvider()->getToken();
    }

    return null;
}

if ( ! function_exists( 'dd' ) ) {
    function dd() {
        array_map(function($x) {
            dump($x);
        }, func_get_args());
        die;
    }
 }

function wp_die( $message = "", int $code = 403 ){
    response()->httpCode($code);
    echo $message;
    die();
}

function get_kelas ( $id = 0 ) {
    $data = Kelas::find($id)->toArray();
    return isset($data['nama_kelas']) ? $data['nama_kelas'] : 0;
}

function get_kelas_id ( $nama = 0 ) {
    $data = Kelas::where('nama_kelas', $nama)->first()->toArray();
    return isset($data['id']) ? $data['id'] : 0;
}

function get_all_kelas () {
    $data = Kelas::all();
    return $data->toArray();
}

function get_all_angkatan_kelas () {
    return array( '7', '8', '9' );
}

function get_all_roles () {
    return array(
        1 => 'admin',
        2 => 'siswa',
        3 => 'tu'
    );
}

function get_role_name ( $id = 0 ) {
    $roles = get_all_roles();
    return $roles[$id];
}

function get_list_tahun_ajaran() {
    return array(
        '2021/2022',
        '2022/2023',
        '2023/2024',
        '2025/2026',
        '2026/2027',
        '2026/2028'
    );
}

function get_all_nama_tagihan () {
    return array(
        'spp' => 'Spp',
        // 'pramuka' => 'Pramuka',
        // 'pesantren_kilat' => 'Pesantren Kilat',
    );
}

function get_all_durasi_tagihan () {
    return array(
        'bebas' => 'Bebas',
        'bulanan' => 'Bulanan',
        'tahunan' => 'Tahunan',
    );
}

function get_target_tagihan () {
    return array(
        'all'       => 'Semua Murid',
        'specific'  => 'Spesifik Murid'
    );
}

function get_bulan_tagihan () {
    return array(
        'januari' => 'Januari',
        'februari'=>'Februari',
        'maret' => 'Maret',
        'april' => 'April',
        'mei' => 'Mei',
        'juni' => 'Juni',
        'juli' => 'Juli',
        'agustus' => 'Agustus',
        'septermber' => 'September',
        'oktober' => 'Oktober',
        'november' => 'November',
        'desember' => 'Desember'
    );
}

function get_bulan_name ( $name = '' ) {
    $bulan = get_bulan_tagihan();
    return isset( $bulan[$name] ) ? $bulan[$name] : '';
}

function get_tagihan_label ( $index ) {

    $label = array(
        'all'       => 'Semua Murid',
        'specific'  => 'Spesifik Murid'
    );

    return isset($label[$index]) ? $label[$index] : '';
}

function rupiah($angka){
    $angka = (float) $angka;
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
    return $hasil_rupiah;

}

function wp_send_json( $message, $code = 200 ){
    response()->httpCode($code)->json($message);
}

function render_sukses_notification () {
    if ( Session::has( 'msg.create.data' ) ) :
    $value = Session::get( 'msg.create.data' );
    Session::delete( 'msg.create.data' );
    $type = 'alert-success';
    if ( is_array( $value ) ) {
        $type = 'alert-danger';
        $value = $value['msg'];
    }
    ?>
        <div class="alert <?php echo $type ?>" role="alert">
            <span><?php echo $value ?><span/>
        </div>
        <br/>
    <?php
    endif;
}

function render_cetak_pdf ($data) {

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();

    $content = view()->fetch( 'cetak-pembayaran', $data );

    $dompdf->loadHtml($content);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream( 'cetak.pdf', array( 'Attachment' => false ) );
}

