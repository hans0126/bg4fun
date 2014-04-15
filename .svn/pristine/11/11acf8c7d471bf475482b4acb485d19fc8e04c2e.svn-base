<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Bgg_Parser_Model extends Ak_Model {

    function __construct() {
        parent::__construct();

    }

    function getGameCategory() {
        $this -> load -> library('simple_html_dom');
        $html = file_get_html('http://boardgamegeek.com/browse/boardgamecategory');
        $arr_return = array();
        foreach ($html->find('#main_content a') as $element) {
            preg_match('/boardgamecategory/', $element -> href, $matches_category);
            if ($matches_category) {
                preg_match('/[0-9][0-9]*/', $element -> href, $matches);
                $category_id = $matches[0];
                //	echo "(".$category_id.")".'-'.$element->innertext."<br/>";
                $arr_return[] = array(
                    "category_id" => $category_id,
                    "category_name" => $element -> innertext
                );

            }

        }

        return $arr_return;

    }

    function getGameMechanic() {
        $this -> load -> library('simple_html_dom');
        $html = file_get_html('http://boardgamegeek.com/browse/boardgamemechanic');
        $arr_return = array();
        foreach ($html->find('#main_content a') as $element) {
            preg_match('/boardgamemechanic/', $element -> href, $matches_category);
            if ($matches_category) {
                preg_match('/[0-9][0-9]*/', $element -> href, $matches);
                $category_id = $matches[0];
                //  echo "(".$category_id.")".'-'.$element->innertext."<br/>";
                $arr_return[] = array(
                    "mechanic_id" => $category_id,
                    "mechanic_name" => $element -> innertext
                );
            }

        }

        return $arr_return;

    }

    function searchFromBgg($keyword) {
        $arr_return = array();
        if ($keyword) {
            if ($xml = simplexml_load_file('http://www.boardgamegeek.com/xmlapi/search?search=' . $keyword)) {
                $arr_return['result'] = array();
                foreach ($xml as $game) {
                    $arr_return['result'][] = array(
                        "name" => (string)$game -> name[0],
                        "game_id" => (string)$game -> attributes() -> objectid,
                        "yearpublished" => (string)$game -> yearpublished
                    );
                }
            } else {
                $arr_return['msg'] = "it's not XML!!";
                exit ;
            }
        } else {
            $arr_return['msg'] = "keyword it empty!!";
        }

        return $arr_return;

    }

    function getGameFromBgg($id) {
        $arr_return = array();
        if ($id) {
            if ($xml = simplexml_load_file('http://www.boardgamegeek.com/xmlapi/boardgame/' . $id)) {
                $result_data = $xml -> boardgame;
                foreach ($result_data->name as $name) {
                    if ($name -> attributes() -> primary) {
                        $arr_return['name'] = (string)$name;
                        break;
                    }
                }

                $arr_return['yearpublished'] = (string)$result_data -> yearpublished;
                $arr_return['minplayers'] = (string)$result_data -> minplayers;
                $arr_return['maxplayers'] = (string)$result_data -> maxplayers;
                $arr_return['playingtime'] = (string)$result_data -> playingtime;
                $arr_return['age'] = (string)$result_data -> age;
                $arr_return['thumbnail'] = (string)$result_data -> thumbnail;
                $arr_return['image'] = (string)$result_data -> image;

                foreach ($result_data->boardgamemechanic as $mechanic) {
                    $arr_return['mechanic'][] = array(
                        "id" => (string)$mechanic -> attributes() -> objectid,
                        "name" => (string)$mechanic
                    );
                }

                foreach ($result_data->boardgamecategory as $category) {
                    $arr_return['category'][] = array(
                        "id" => (string)$category -> attributes() -> objectid,
                        "name" => (string)$category
                    );
                }

                foreach ($result_data->boardgameexpansion as $expansion) {
                    $inbound = 0;
                    if ($expansion -> attributes() -> inbound) {
                        $inbound = 1;
                    }

                    $arr_return['expansion'][] = array(
                        "id" => (string)$expansion -> attributes() -> objectid,
                        "name" => (string)$expansion,
                        "inbound" => $inbound
                    );
                }

            } else {
                $arr_return['msg'] = "it's not XML!!";
                exit ;
            }
        } else {
            $arr_return['msg'] = "ID it empty!!";
        }

        return $arr_return;

    }

    function getImgFromBgg($url) {
        $filename = str_replace('http://cf.geekdo-images.com/images/', "", $url);
        $output = 'upload/' . $filename;
        file_put_contents($output, file_get_contents($url));
        return $filename;
    }

    function createGameId($name) {

        $bad = array(

            "<!--",

            "-->",

            "'",

            "<",

            ">",

            '"',

            '&',

            '$',

            '=',

            ';',
            
            ':',
            
            '?',

            '/',
            
            " ",
            
            "%20",

            "%22",

            "%3c", // <

            "%253c", // <

            "%3e", // >

            "%0e", // >

            "%28", // (

            "%29", // )

            "%2528", // (

            "%26", // &

            "%24", // $

            "%3f", // ?

            "%3b", // ;

            "%3d" // =

        );
     
        $name = str_replace($bad,'-', $name);
        $name=preg_replace('/-+/','-',$name);
        return strtolower($name);

    }

}
