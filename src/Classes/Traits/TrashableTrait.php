<?php 

namespace Dxl\Classes\Traits;

if(!trait_exists('TrashableTrait')) {

    /**
     * Trait to allow to soft delete a data row
     */
    trait TrashableTrait {

        /**
         * deleted_at field
         *
         * @var string
         */
        protected $deleted_at = 'deleted_at';

        /**
         * soft delete an data row from repository
         *
         * @param [type] $identifer
         * @return void
         */
        public function softDelete($identifer) 
        {
            return $this->handler->update($this->handler->prefix . $this->repository, ["deleted_at" => time()], [$this->primaryIdentifier => $id]);
        }
    }
}

?>