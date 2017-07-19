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

        function setTitle($new_title)
        {
            $this->title = $new_title;
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
