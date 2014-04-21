<?php
    /**
     * Näyttää sivun ja syöttää sille arvoja
     * @param string $page näytettävä sivu
     * @param array $data sivulle syötettävä data
     */
    function view($page, $data = array()) {
        $data = (object)$data;
        require 'views/template.php';
        exit();
    }
    
    /**
     * Kirjaa luettu viestiketju tietokantaan
     * @param int $user_id käyttäjän id
     * @param int $topic_id luetun viestiketjun id
     */
    function add_read($user_id, $topic_id) {
        try {
            sql_query("insert into luettuviesti (käyttäjä, viesti) values (?, ?)", null, array($user_id, $topic_id));
        } catch(PDOException $e) {
            // luultavasti epäonnistu uniikin (viesti, käyttäjä) parin takia
        }
    }
    
    /**
     * Hakee $_GET taulukosta annetun arvon
     * @param string $param haettava numeroarvo
     * @return int arvo
     */
    function parse_id($param) {
        if (empty($_GET[$param])) {
            return 0;
        } else {
            return filter_input(INPUT_GET, $param, FILTER_SANITIZE_NUMBER_INT);
        }
    }
    
    /**
     * Suorittaa tietokantakyselyn ja mahdollisesti palauttaa jotain arvoja.
     * @param string $sql suoritettava SQL komento
     * @param string $fetch "all" palauttaa kaikki sopivat rivit. "one" palauttaa yhden rivin. "column" palauttaa ensimmäisen sarakkeen. null syöte ei palauta mitään.
     * @param array $params SQL komentoon syötettävät parametrit
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
    