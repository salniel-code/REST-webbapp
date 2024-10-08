<?php

// Kod skriver av Sally Nielsen | DT173G Projekt
class Portfolio extends Database
{

    public $title;
    public $url;
    public $desc;
    public $image;
     



    public function getPortfolio()
    {
        // Hämtar portfolio
        $sql =  "SELECT * FROM portfolio";
        $results = $this->connect()->query($sql);
        $portfolio =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $portfolio;
    }

    public function getOnePortfolio($index)
    {
        // Hämtar portfolio
        $sql =  "SELECT * FROM portfolio WHERE id = '$index'";
        $results = $this->connect()->query($sql);
        $portfolio =  mysqli_fetch_all($results, MYSQLI_ASSOC);

        return $portfolio;
    }

    public function addPortfolio()
    {
        // Lägger in portfolio 
        $sql = "INSERT INTO portfolio(title, url, description, image)VALUES('$this->title', '$this->url', '$this->desc', '$this->image')";
        $this->connect()->query($sql);
        return true;
    
    }

    public function updatePortfolio($index)
    {

        // Uppdaterar portfolio
        $sql = "UPDATE portfolio SET title = '$this->title', url = '$this->url', description = '$this->desc', image = '$this->image' WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }

    public function removePortfolio($index)
    {
        // Raderar portfolio
        $sql = "DELETE FROM portfolio WHERE id = '$index'";
        $this->connect()->query($sql);
        return true;
    }
}

