<?php
    class Book
    {
        private $title;
        private $id;

        function __construct($title, $id = null)
        {
            $this->title = $title;
            $this->id = $id;
        }

        function getTitle()
        {
            return $this->title;
        }

        // function setTitle()
        // {
        //
        // }
        //
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
        // static function getAll()
        // {
        //
        // }
        //
        // static function deleteAll()
        // {
        //
        // }
        //
        // static function find()
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
