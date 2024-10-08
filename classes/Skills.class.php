<?php

// Kod skriver av Sally Nielsen | DT173G Projekt
class Skills extends Database
{

    public $language;
    public $description;
     



    public function getSkills()
    {
        // Hämtar skills
        $sql =  "SELECT * FROM skills";
        $results = $this->connect()->query($sql);
        $skills =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $skills;
    }

    public function getOneSkill($index)
    {
        // Hämtar skills
        $sql =  "SELECT * FROM skills WHERE id = '$index'";
        $results = $this->connect()->query($sql);
        $skills =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $skills;
    }

    public function addskills()
    {
        // Lägger in skills 
        $sql = "INSERT INTO skills(lang, description)VALUES('$this->language', '$this->description')";
        $this->connect()->query($sql);
        return true;
    
    }

    public function updateskills($index)
    {

        // Uppdaterar skills
        $sql = "UPDATE skills SET lang = '$this->language', description = '$this->description' WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }

    public function removeskills($index)
    {
        // Raderar skills
        $sql = "DELETE FROM skills WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }
}