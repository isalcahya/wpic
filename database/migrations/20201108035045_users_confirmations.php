<?php
/**
 * Auto-Generate Migration
 * This class is auto generated from GenerateCommand command
 * isal.c <isalcahya@gmail.com>
 */

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
class UsersConfirmations extends Migration
{
    protected $table;
    protected $schema;

     /**
     * Prepare Var
     */
    public function init(){
        $this->table    = 'users_confirmations';
        $this->schema   = $this->get( 'schema' );
    }

    /**
     * Do the migration
     */
    public function up()
    {
        $this->schema->create( $this->table, function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('email', 249)->unique();
            $table->string('selector', 16)->unique();
            $table->string('token', 255);
            $table->integer('expires');
            $table->timestamps();
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
