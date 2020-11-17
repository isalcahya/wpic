<?php
/**
 * Auto-Generate Migration
 * This class is auto generated from GenerateCommand command
 * isal.c <isalcahya@gmail.com>
 */

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
class UsersRemembered extends Migration
{
    protected $table;
    protected $schema;

     /**
     * Prepare Var
     */
    public function init(){
        $this->table    = 'users_remembered';
        $this->schema   = $this->get( 'schema' );
    }

    /**
     * Do the migration
     */
    public function up()
    {
        $this->schema->create( $this->table, function(Blueprint $table){
            $table->bigIncrements( 'id', 255 );
            $table->integer( 'user' );
            $table->string( 'selector' )->unique();
            $table->string( 'token', 255 );
            $table->integer( 'expires' )->unsigned();
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
