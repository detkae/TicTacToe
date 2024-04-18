<?php

include 'db.php';
include 'utils.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $gameID = $_GET['id'];
    if (empty($gameID)) {
        http_response_code(400);
        echo "ID missing";
        exit;
    }
    $query = $db->query('SELECT * FROM `TICTACTOE` WHERE ID = ?', $gameID);
    $response = $query->fetchAll();
    http_response_code(200);
    echo json_encode($response);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameID = $_POST['id'];
    $score = $_POST['score'];
    $playerName = $_POST['name'];
    # game ID given => join if no score is provided, otherwise update score
    if (!empty($gameID)) {
        # game ID given, but no score => join game
        if (empty($score)) {
            if (!empty($playerName)) {
                $query = $db->query('UPDATE `TICTACTOE` SET `PLAYER2`=? WHERE `ID`=?', $playerName, $gameID);
                $response = $query->affectedRows();
                if ($response === 1) {
                    http_response_code(200);
                    echo json_encode($response);
                    exit;
                }
            } else {
                http_response_code(400);
                echo "POST request with gameID, but no score means: Join the game. However, player name was missing";
                exit;
            }
        # game ID and score given => update score
        } else {
            $query = $db->query('UPDATE `TICTACTOE` SET `SCORE`=? WHERE `ID`=?', $score, $gameID);
            $response = $query->affectedRows();
            if ($response === 1) {
                http_response_code(200);
                echo json_encode($response);
                exit;
            }
        }

        http_response_code(500);
        echo json_encode($response);
        exit;
    # no game ID given => create game
    } else {
        if (!empty($playerName)) {
            $query = $db->query('INSERT INTO `TICTACTOE` (`PLAYER1`, `SCORE`) VALUES (?, "[[0,0,0],[0,0,0],[0,0,0]]")', $playerName);
            $response = $db->lastInsertID();
            http_response_code(200);
            echo json_encode($response);
            exit;
        }

        http_response_code(400);
        echo "missing name";
        exit;
    }
}

?>