<?php
    /**
     * Näyttää sivun ja syöttää sille arvoja
     * @param type $page näytettävä sivu
     * @param type $data sivulle syötettävä data
     */
    function view($page, $data = array()) {
        $data = (object)$data;
        require 'views/template.php';
        exit();
    }
    
    /**
     * Suorittaa tietokantakyselyn ja mahdollisesti palauttaa jotain arvoja.
     * @param type $sql suoritettava SQL komento
     * @param type $fetch "all" palauttaa kaikki sopivat rivit. "one" palauttaa yhden rivin. "column" palauttaa ensimmäisen sarakkeen. null syöte ei palauta mitään.
     * @param type $params SQL komentoon syötettävät parametrit
     * @return null jos tietokantakysely menee pieleen, muuten $fetch mukaan.
     */
    function sql_query($sql, $fetch, $params = array()) {
        $query = get_db_connection()->prepare($sql);
        $result = $query->execute($params);
        
        if($result == null) {
            return null;
        }
        
        switch($fetch) {
            case "all":
                return $query->fetchAll();
            case "one":
                return $query->fetchObject();
            case "column":
                return $query->fetchColumn();
            default:
                return;
        }
    }

    date_default_timezone_set("Europe/Helsinki");
    