<?php
/**
 * Questo commento serve solo a eliminare l'indicazione di errore
 * da parte di PHPStorm per la variabile $studenti
 * @var $todos
 * @var $testo
 * @var $id
 * @var $importanza
 * @var $displayed_name
 */
?>

<?php $this->layout('home', ['titolo' => 'Esempio CRUD']) ?>

<header class="navbar">
    <section class="navbar-section">

    </section>

    <section class="navbar-section">
        <span class="label label-rounded label-primary m-2">
            Hello <?=$displayed_name?>
        </span>
        <button class="btn btn-action tooltip tooltip-bottom" data-tooltip="Logout">
            <a href="index.php?action=logout">
                <i class="icon icon-share"></i>
            </a>
        </button>
    </section>
</header>

<h1>Cose da fare</h1>

<form method="post" action="index.php">
    <div class="form-group">
        <label for="todo">

        </label><textarea name="impegno" class="form-input form" id="todo" placeholder="Aggiungi un impegno" rows="3">
<?php if ($testo != ''):?>
<?=$this->e($testo)?>
<?php endif;?></textarea>
    </div>
    <?php if ($id != null):?>
        <input type="hidden" name="id" value="<?=$id?>">
    <?php endif; ?>
    <div class="form-group">
        <select class="form-select" name="importanza">
            <?php for($i = 1; $i <= 5; $i++):?>
                <option <?php if ($importanza == $i) echo 'selected'?> >
                    <?=$i?>
                </option>
            <?php endfor;?>
        </select>
    </div>


    <button>
        <?php if ($testo == ''):?>
            Aggiungi un impegno
        <?php else:?>
            Modifica il testo
        <?php endif; ?>
    </button>
</form>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Da fare</th>
            <th>Importanza</th>
            <th>Data</th>
            <th>Completato</th>
            <th>Modifica</th>
            <th>Elimina</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($todos as $todo):?>
        <tr>
            <td>
                <?php if($todo['completato'] == 1):?>
                    <s><?=$this->e($todo['testo'])?></s>
                <?php else:?>
                    <?=$this->e($todo['testo'])?>
                <?php endif;?>
            </td>
            <td><?=$todo['importanza']?></td>
            <td><?=date('d-m-Y', strtotime($todo['data']))?></td>
            <?php if($todo['completato'] == 1):?>
                <td><i class="icon icon-check text-success"></i></td>
                <td><i class="icon icon-cross"></i></td>
                <td><a href="?action=elimina&id=<?=$todo['id']?>"><i class="icon icon-delete"></i></a></td>
            <?php else:?>
                <td><a href="?action=completa&id=<?=$todo['id']?>"><i class="icon icon-flag text-error"></i></a></td>
                <td><a href="?action=modifica&id=<?=$todo['id']?>"><i class="icon icon-edit"></i></a></td>
                <td><a href="?action=elimina&id=<?=$todo['id']?>"><i class="icon icon-delete"></i></a></td>
            <?php endif;?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>


