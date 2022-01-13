<?php
use Pecee\SimpleRouter\SimpleRouter as Router;

Router::get( '/', 'FrontController@admin' );
Router::get('logout', 'FrontController@logout')->name('logout');
Router::form('login', 'FrontController@login')->name('login.page');
Router::form('register', 'FrontController@register')->name('register.page');

// siswa
Router::delete('siswa/delete/{id}', 'SiswaController@delete')->name('delete.siswa')->where([ 'id' => '[0-9]+' ]);
Router::post('siswa/update/{id}', 'SiswaController@updated')->name('update.siswa')->where([ 'id' => '[0-9]+' ]);
Router::post('siswa/added/', 'SiswaController@added')->name('add.siswa');
Router::post('siswa/search/', 'SiswaController@search')->name('search.siswa');
Router::get('siswa/tagihan/{id}', 'SiswaController@tagihan')->name('tagihan.siswa');

// tagihan
Router::delete('tagihan/delete/{id}', 'TagihanController@delete')->name('delete.tagihan')->where([ 'id' => '[0-9]+' ]);
Router::post('tagihan/update/{id}', 'TagihanController@updated')->name('update.tagihan')->where([ 'id' => '[0-9]+' ]);
Router::post('tagihan/added/', 'TagihanController@added')->name('add.tagihan');

// kelas
Router::delete('kelas/delete/{id}', 'KelasController@delete')->name('delete.kelas')->where([ 'id' => '[0-9]+' ]);
Router::post('kelas/update/{id}', 'KelasController@updated')->name('update.kelas')->where([ 'id' => '[0-9]+' ]);
Router::post('kelas/added/', 'KelasController@added')->name('add.kelas');

// midtrans
Router::get('midtrans/pay/{id}', 'MidtransController@pay')->name('midtrans');
Router::get('midtrans/view/{id}', 'MidtransController@view')->name('midtrans.view');
Router::post('midtrans/retrieve/', 'MidtransController@getUpdate')->name('midtrans.retrieve');
Router::get('midtrans/cek/{id}', 'MidtransController@cekPayment')->name('midtrans.cek');
Router::get('midtrans/confirm/{id}', 'MidtransController@confirmation')->name('midtrans.confirm');