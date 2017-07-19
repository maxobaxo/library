<?php
    class Author
    {
        private $first_name;
        private $last_name;
        private $id;

        function __construct($first_name, $last_name, $id = null)
        {
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->full_name = $first_name . $last_name;
            $this->id = $id;
        }

        function getFirstName()
        {

        }

        function setFirstName()
        {

        }

        function getLastName()
        {

        }

        function setLastName()
        {

        }

        function getFullName()
        {

        }

        // function getId()
        // {
        //
        // }
        //
        // function save()
        // {
        //
        // }
        //
        // function getAll()
        // {
        //
        // }
        //
        // function deleteAll()
        // {
        //
        // }
        //
        // function find()
        // {
        //
        // }
        //
        // function update()
        // {
        //
        // }
        //
        // function delete()
        // {
        //
        // }
    }
?>
