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
            return $this->first_name;
        }

        function setFirstName($new_first_name)
        {
            $this->first_name = (string) $new_first_name;
        }

        function getLastName()
        {
            return $this->last_name;
        }

        function setLastName($new_last_name)
        {
            $this->last_name = (string) $new_last_name;
        }

        function getFullName()
        {
            return $this->full_name;
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
