<?php

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
class Users extends Migration
{
    protected $table;
    protected $schema;

    public function init(){
        $this->table    = 'users';
        $this->schema   = $this->get( 'schema' );
    }
    /**
     * Do the migration
     */
    public function up()
    {
        $this->schema->create( $this->table, function(Blueprint $table){
            $table->increments('id');
            $table->string('email', 248)->unique();
            $table->string('password', 255);
            $table->string('username', 100)->unique();
            $table->tinyInteger('status')->unsigned()->default(0);
            $table->tinyInteger('verified')->unsigned()->default(0);
            $table->tinyInteger('resettable')->unsigned()->default(1);
            $table->integer('roles_mask')->unsigned()->default(0);
            $table->integer('registered')->unsigned();
            $table->integer('last_login')->unsigned()->nullable()->default(null);
            $table->mediumInteger('force_logout')->unsigned()->default(0);
            $table->timestamps(null);
            $table->softDeletes();
        });
    }

    /**
     * Undo the migration
     */
    public function down()
    {
        $this->schema->drop( $this->table );
    }
}
