<?php 

namespace Dxl\Classes\Abstracts;

if( !class_exists('AbstractRepository') )
{
    abstract class AbstractRepository
    {
        /**
         * Repository database class
         *
         * @var [type]
         */
        protected $repository;

        /**
         * primary identifier used in crud actions
         *
         * @var [type]
         */
        protected $primaryIdentifier = "id";

        /**
         * definition of default order used in order statements
         *
         * @var string
         */
        protected $defaultOrder = "ASC";

        /**
         * base query object
         *
         * @var [type]
         */
        protected $query;

        /**
         * query handler
         *
         * @var [type]
         */
        protected $handler;

        /**
         * Abstract repository constructor
         */
        public function __construct()
        {
            $this->setHandler($GLOBALS["wpdb"]);
        }

        /**
         * Set repository handler
         *
         * @param $handler
         * @return void
         */
        public function setHandler($handler) 
        {
            $this->handler = $handler;
        }

        /**
         * set a new column to be handled as a primary identifier
         *
         * @param int $primaryIdentifier
         * @return void
         */
        public function setPrimaryIdentifier($primaryIdentifier)
        {
            $this->primaryIdentifier = $primaryIdentifier;
        }

        /**
         * fetching all records from database table
         *
         * @return void
         */
        public function all() {
            return $this->handler
                ->get_results(
                    "SELECT * FROM " . $this->handler->prefix . "" . $this->repository . " ORDER BY id " . $this->defaultOrder
                );
        }

        /**
         * building a select statement 
         *
         * @param string $fields
         * @return void
         */
        public function select($fields = '*')
        {
            $this->query = "SELECT ";

            if( is_array($fields) ) 
            {
                $fields = (count($fields) > 1 ) ? implode(', ', $fields) : $fields[0];
            }

            $this->query .= $fields . " FROM " . $this->handler->prefix . "" .$this->repository . " ";
            return $this;
        }

        /**
         * Select Json column from database table
         *
         * @param [type] $column
         * @param string $path
         * @return void
         */
        public function selectJsonColumn($column, $path = '$') {
            // $this->query = "SELECT JSON_EXTRACT(" . $column .", $path) FROM " . $this->handler->prefix . "" .$this->repository;
            return $this->handler->get_row(
                "SELECT JSON_EXTRACT(" . $column .", $path) FROM " . $this->handler->prefix . "" .$this->repository
            );
        }
        /**
         * Undocumented function
         *
         * @param [type] $field
         * @param [type] $value
         * @param string $operator
         * @return void
         */
        public function where($field, $value, $operator = "=")
        {
            $this->query .= "WHERE " . $field . " " . $operator . " " . $value . " ";
            return $this;
        }

        /**
         * Extend the query with an OR statement extended to the where statement
         *
         * @param [type] $field
         * @param [type] $value
         * @param string $operator
         * @return void
         */
        public function whereOr($field, $value, $operator = "=")
        {
            $this->query .= "OR " . $field . " " . $operator . " " . $value . " ";
            return $this;
        }

        /**
         * Extend the query with an AND statement extended to the where statement
         *
         * @param [type] $field
         * @param [type] $value
         * @param string $operator
         * @return void
         */
        public function whereAnd($field, $value, $operator = "=")
        {
            $this->query .= "AND " . $field . " " . $operator . " " . $value . " ";
            return $this;
        }

        /**
         * Get limit of records 
         *
         * @param [type] $limit
         * @param [type] $offset
         * @return void
         */
        public function limit($limit, $offset = null) 
        {
            $this->query .= "LIMIT " . $limit;
            if( $offset ) {
                $this->query .= " OFFSET " . $offset;
            }
            return $this;
        }

        /**
         * building an ORDER BY statement to the base query
         *
         * @param [type] $column
         * @return void
         */
        public function orderBy($column)
        {
            $this->query .= " ORDER BY " . $column . " " . $this->defaultOrder;
            return $this;
        }

        /**
         * make the base query select the data in ascending order
         *
         * @param [type] $column
         * @return void
         */
        public function ascending($column)
        {
            $this->query .= " ORDER BY " . $column . " ASC";
            return $this;
        }

        /**
         * make the base query select the data in descending order
         *
         * @param [type] $column
         * @return void
         */
        public function descending($column)
        {
            $this->query .= " ORDER BY " . $column . " DESC ";
            return $this;
        }

        public function debug() {
            return $this->query;
        }

        /**
         * query the database based on the builded base query
         *
         * @return void
         */
        public function get()
        {
            return $this->handler
                ->get_results(
                    $this->query
                );
        }

        /**
         * query only one row based on the base query
         *
         * @return void
         */
        public function getRow()
        {
            return $this->handler
                ->get_row(
                    $this->query
                );
        }

        /**
         * execute a select query base on a specific identifier
         *
         * @param [type] $id
         * @return void
         */
        public function find($id)
        {
            return $this->handler
                ->get_row(
                    $this->handler
                        ->prepare(
                            "SELECT * FROM " . $this->handler->prefix . "" . $this->repository . " WHERE " . $this->primaryIdentifier . " IN(%d)", 
                            (int) $id
                        )
                    );
        }

        /**
         * building the base query as a raw
         *
         * @param [type] $query
         * @param integer $count
         * @return void
         */
        public function rawQuery($query, $count = 1)
        {
            if($count == 1)
            {
                return $this->handler->get_row($query);
            }

            return $this->handler->get_results($query);
        }

        /**
         * Create a new row in the database based on a datalist
         *
         * @param [type] $data
         * @return void
         */
        public function create(array $data): int
        {
            $this->handler
                ->insert(
                    $this->handler->prefix . "" . $this->repository, 
                    $data
                );
            return $this->handler->insert_id;
        }

        /**
         * delete data row from table
         *
         * @param [type] $id
         * @return void
         */
        public function delete(int $id, ?array $fields = [], ?bool $isTrashable = false): bool
        {
            // if the row is trashable then update the time of the deletion of the data // todo
            if( $isTrashable ) 
            {
                return $this->handler->update($this->handler->prefix . $this->repository, ["deleted_at" => time()], [$this->primaryIdentifier => $id]);
            }

            $where = [
                $this->primaryIdentifier => $id
            ];

            if( $fields ) {
                foreach( $fields as $f => $field ) {
                    $where[$f] = $field;
                }
            }

            // otherwise hard remove it from the database
            return $this->handler
                ->delete(
                    $this->handler->prefix . "" . $this->repository, 
                    $where
                );
        }

        /**
         * update existing row of data
         *
         * @param array $data
         * @param [type] $identifier
         * @return void
         */
        public function update(array $data, $identifier) 
        {
            return $this->handler
                ->update(
                    $this->handler->prefix . "" . $this->repository, 
                    $data, 
                    [$this->primaryIdentifier => $identifier]
                );
        }
    }
}

?>