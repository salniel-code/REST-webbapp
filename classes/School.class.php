<?php

// Kod skriver av Sally Nielsen | DT173G Projekt
class School extends Database
{

    public $school;
    public $name;
    public $years;


    public function getSchool()
    {
        // Hämtar skola
        $sql =  "SELECT * FROM school";
        $results = $this->connect()->query($sql);
        $school =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $school;
    }

public function getOneSchool($index){
     // Hämtar skola
        $sql =  "SELECT * FROM school WHERE id = '$index'";
        $results = $this->connect()->query($sql);
        $school =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $school;
    
    
}

    public function addSchool()
    {
        // Lägger in i db
        $sql = "INSERT INTO school(school, name, years)VALUES('$this->school', '$this->name', '$this->years')";
        $this->connect()->query($sql);
        return true;
    }

    public function updateSchool($index)
    {

        //Uppdaterar skola 
        $sql = "UPDATE school SET school = '$this->school', name = '$this->name', years= '$this->years' WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }

    public function removeSchool($index)
    {
        // raderar skola
        $sql = "DELETE FROM school WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }
}
