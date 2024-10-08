<?php

// Kod skriver av Sally Nielsen | DT173G Projekt
class Experience extends Database
{

    public $workplace;
    public $title;
    public $years;


    public function getExperience()
    {
        // Hämtar erfarenhet
        $sql =  "SELECT * FROM experience";
        $results = $this->connect()->query($sql);
        $experience =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $experience;
    }

    public function getOneExperience($index)
    {
        // Hämtar  // Hämtar erfarenhet
        $sql =  "SELECT * FROM experience WHERE id = '$index'";
        $results = $this->connect()->query($sql);
        $experience =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $experience;
    }
    public function addExp()
    {
        // Lägger in erfarenhet
        $sql = "INSERT INTO experience(workplace, title, years)VALUES('$this->workplace', '$this->title', '$this->years')";
        $this->connect()->query($sql);
        return true;
    }

    public function updateExp($index)
    {

        // Uppdaterar erfarenhet
        $sql = "UPDATE experience SET workplace = '$this->workplace', title = '$this->title', years = '$this->years' WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }

    public function removeExperience($index)
    {
        // Raderar erfarenhet
        $sql = "DELETE FROM experience WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }
}

