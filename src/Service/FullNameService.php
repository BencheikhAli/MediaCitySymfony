<?php 

namespace App\Service;

class FullNameService{
        function getFullName(string $nom, string $prenom){
            return $prenom . " " . $nom;
        }
    }
?>