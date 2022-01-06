<?php
use Pecee\SimpleRouter\SimpleRouter as Router;
use Pecee\Http\Url;
use Pecee\Http\Response;
use Pecee\Http\Request;
use Models\Kelas;

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
    $data = Kelas::find($id);
    return isset($data->nama_kelas) ? $data->nama_kelas : 0;
}

function get_all_kelas () {
    $data = Kelas::all();
    return $data->toArray();
}

function get_all_angkatan_kelas () {
    return array( '7', '8', '9' );
}

function get_all_nama_tagihan () {
    return array(
        'spp' => 'Spp',
        'pramuka' => 'Pramuka',
        'pesantren_kilat' => 'Pesantren Kilat',
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

function get_tagihan_label ( $index ) {

    $label = array(
        'all'       => 'Semua Murid',
        'specific'  => 'Spesifik Murid'
    );

    return isset($label[$index]) ? $label[$index] : '';
}

function wp_send_json( $message, $code = 200 ){
    response()->httpCode($code)->json($message);
}

