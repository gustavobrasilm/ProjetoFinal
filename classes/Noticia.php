<?php

class Noticia
{
    private $db;
    private $table_name = "noticias";

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function criar($idusu, $data, $titulo, $noticia)
    {
        $query = "INSERT INTO $this->table_name (idusu, data, titulo, noticia) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idusu, $data, $titulo, $noticia]);
        return $stmt;
    }

    public function ler($search = '', $order_by = '')
    {
        $query = "SELECT * FROM $this->table_name";

        if (!empty($search)) {
            $query .= " WHERE titulo LIKE :search OR noticia LIKE :search";
        }

        if ($order_by === 'titulo') {
            $query .= " ORDER BY titulo ASC";
        } else {
            $query .= " ORDER BY data DESC";
        }

        $stmt = $this->db->prepare($query);

        if (!empty($search)) {
            $search = "%{$search}%";
            $stmt->bindParam(':search', $search);
        }

        $stmt->execute();
        return $stmt;
    }

    public function lerPorId($idnot)
    {
        $query = "SELECT * FROM $this->table_name WHERE idnot = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idnot]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($idnot, $titulo, $noticia)
    {
        $query = "UPDATE $this->table_name SET titulo = ?, noticia = ? WHERE idnot = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$titulo, $noticia, $idnot]);
        return $stmt;
    }

    public function deletar($idnot)
    {
        $query = "DELETE FROM $this->table_name WHERE idnot = ?";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$idnot]);
        return $stmt;
    }
}
?>
