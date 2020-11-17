<?php
/**
 * Auto-Generate Migration
 * This class is auto generated from GenerateCommand command
 * isal.c <isalcahya@gmail.com>
 */

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
class UsersResets extends Migration
{
    protected $table;
    protected $schema;

     /**
     * Prepare Var
     */
    public function init(){
        $this->table    = 'users_resets';
        $this->schema   = $this->get( 'schema' );
    }

    /**
     * Do the migration
     */
    public function up()
    {
        $this->schema->create( $this->table, function(Blueprint $table){
            $table->bigIncrements('id')->unsigned();
            $table->integer('user')->unsigned();
            $table->string('selector');
            $table->string('token', 255);
            $table->integer('expires')->unsigned();
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
