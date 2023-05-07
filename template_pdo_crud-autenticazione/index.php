<?php

require_once 'vendor/autoload.php';
require_once 'conf/config.php';

use League\Plates\Engine;
use Model\TodoRepository;
use Util\Authenticator;

$template = new Engine('templates','tpl');
//Fa partire il processo di autenticazione
$user = Authenticator::getUser();

if ($user == null){
    echo $template->render('login');
    exit(0);
}

$id_user = $user['user_id'];
$displayed_name = $user['displayed_name'];

if (isset($_GET['action'])){
    if (($_GET['action']) == 'logout'){
        Authenticator::logout();
        echo $template->render('login');
        exit(0);
    }
}
//Gestisce l'aggiunta di un nuovo impegno
if (isset($_POST['prodotto'])){
    $prodotto = $_POST['prodotto'];
    $importanza = $_POST['importanza'];
    if (isset($_POST['id'])){
        $id = $_POST['id'];
        if (TodoRepository::owned($id, $id_user))
            TodoRepository::updateTesto($prodotto, $importanza, $id);
    }
    else if ($prodotto != '') {
        TodoRepository::add($prodotto, $importanza, $id_user);
    }
}

$testo = "";
$importanza = -1;
$id = null;

if (isset($_GET['action'])){
    $azione = $_GET['action'];
    $id = $_GET['id'];
    //Se l'id dell'impegno è corretto può eseguire l'azione, altrimenti no
    if (TodoRepository::owned($id, $id_user)) {
        //Gestisce il completamento di un impegno
        if ($azione == 'completa') {
            TodoRepository::completa($id);
        } //Gestisce il recupero del testo dell'impegno da modificare
        else if ($azione == 'modifica') {
            $prodotto = TodoRepository::getProdotto($id);
            $testo = $prodotto['testo'];
            $importanza = $prodotto['importanza'];
        } //Gestisce l'eliminazione
        else if ($azione == 'elimina') {
            TodoRepository::delete($id);
        }
    }
}

$oggetti = TodoRepository::listAllByUser($user['user_id']);

echo $template->render('crud', [
    'oggetti' => $oggetti,
    'testo' => $testo,
    'importanza' => $importanza,
    'id' => $id,
    'displayed_name' => $displayed_name
]);