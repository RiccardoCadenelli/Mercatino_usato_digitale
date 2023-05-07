<?php

namespace Model;
use Util\Connection;

class TodoRepository{

    public static function listAll(): array{
        $pdo = Connection::getInstance();
        $sql = 'SELECT * FROM oggetto ORDER BY scambio_completato, importanza DESC, data DESC';
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public static function listAllByUser(int $id): array{
        $pdo = Connection::getInstance();
        $sql = 'SELECT * FROM oggetto WHERE id_user=:id ORDER BY scambio_completato, importanza DESC, data DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
                'id' => $id,
            ]
        );
        return $stmt->fetchAll();
    }

    public static function owned(string $id_todo, int $id_user): bool{
        $pdo = Connection::getInstance();
        $sql = 'SELECT id FROM oggetto WHERE id = :id AND id_user = :id_user';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
                'id' => $id_todo,
                'id_user' => $id_user
            ]
        );
        return ($stmt->rowCount() == 1);
    }

    public static function add(string $testo, int $importanza, int $id_user): int{
        $pdo = Connection::getInstance();
        $sql = 'INSERT INTO oggetto (testo, importanza, id_user) VALUES (:testo,:importanza, :id_user)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
                'testo' => $testo,
                'importanza' => $importanza,
                'id_user' => $id_user
            ]
        );
        return $stmt->rowCount();
    }

    public static function completa(int $id): bool{
        $pdo = Connection::getInstance();
        $sql = 'UPDATE oggetto SET scambio_completato = 1 WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        if ($stmt->rowCount() == 1)
            return true;
        return false;
    }

    public static function getTesto(int $id): string{
        $pdo = Connection::getInstance();
        $sql = 'SELECT testo FROM oggetto WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
                'id' => $id
            ]
        );
        $row = $stmt->fetch();
        return $row['testo'];
    }

    public static function getProdotto(int $id): array{
        $pdo = Connection::getInstance();
        $sql = 'SELECT testo, importanza FROM oggetto WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
                'id' => $id
            ]
        );
        $row = $stmt->fetch();
        return $row;
    }


    public static function updateTesto(string $testo, $importanza, int $id): bool{
        $pdo = Connection::getInstance();
        $sql = 'UPDATE oggetto SET testo = :testo, importanza = :importanza WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'testo' => $testo,
            'importanza' => $importanza,
            'id' => $id
        ]);
        if ($stmt->rowCount() == 1)
            return true;
        return false;
    }

    public static function delete(int $id):bool
    {
        $pdo = Connection::getInstance();
        $sql = 'DELETE FROM oggetto WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'id' => $id
        ]);
        if ($stmt->rowCount() == 1)
            return true;
        return false;
    }
}