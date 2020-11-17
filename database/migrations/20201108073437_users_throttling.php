<?php
/**
 * Auto-Generate Migration
 * This class is auto generated from GenerateCommand command
 * isal.c <isalcahya@gmail.com>
 */

use Phpmig\Migration\Migration;
use Illuminate\Database\Schema\Blueprint;
class UsersThrottling extends Migration
{
    protected $table;
    protected $schema;

     /**
     * Prepare Var
     */
    public function init(){
        $this->table    = 'users_throttling';
        $this->schema   = $this->get( 'schema' );
    }

    /**
     * Do the migration
     */
    public function up()
    {
        $this->schema->create( $this->table, function(Blueprint $table){
            $table->string('bucket',44)->primary();
            $table->float('tokens')->unsigned();
            $table->integer('replenished_at')->unsigned();
            $table->integer('expires_at')->unsigned();
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
