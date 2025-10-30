<?php

namespace Core\Database;

use Core\Exceptions\DatabaseException;
use Core\Config;

class QueryBuilder
{

    private array $having = [];
    private ?string $model = null;
    private array $fields = [];
    private array $conditions = [];
    private ?string $table = null;
    private array $joins = [];
    private array $order = [];
    private array $groupBy = [];
    private array $fillable = [];
    private array $slugs = [];
    private ?int $limit = null;
    private ?int $offset = null;
    private bool $distinct = false;


    /**
     * Constructeur
     * @method __construct
     * @param  array       $fillable
     */
    public function __construct(array $fillable = [])
    {
        $this->fillable = $fillable;
    }

    /**
     * Setting des champs à slugifier
     * @method setFieldstoSlugifier
     * @param  array                $slugs
     */
    public function setFieldstoSlugifier($slugs = array())
    {
        $this->slugs = $slugs;
    }

    /**
     * Methode magique
     * Retourne la requete sql
     * @return string
     */
    public function __toString()
    {
        return $this->builder();
    }

    /**
     * Ajout de Select
     * @param  array $fields
     * @return instance
     */
    public function select($fields): self
    {
        if (gettype($fields) === 'array') {
            foreach ($fields as $field) {
                $this->fields[] = $field;
            }
            return $this;
        } else {
            throw new \Exception("Variable de type Array demandé");
        }
    }


    /**
     * Ajout des conditions WHERE
     * @param  string $field
     * @param  string $operand
     * @param  string $value
     * @return instance
     */
    public function where($field, $operand, $value): self
    {
        if (strtoupper($operand) === 'IN') {
            $this->conditions[] = $field . ' ' . $operand . ' ' . $value;
        } else {
            $this->conditions[] = $field . ' ' . $operand . ' \'' . $value . '\'';
        }
        return $this;
    }

    /**
     * Ajout des conditions WHERE col is null
     * @param  string $field
     * @return instance
     */
    public function whereIsNull($field): self
    {
        $this->conditions[] = $field . ' is null';
        return $this;
    }

    /**
     * Ajout des conditions WHERE col is not null
     * @param  string $field
     * @return instance
     */
    public function whereIsNotNull($field): self
    {
        $this->conditions[] = $field . ' is not null';
        return $this;
    }

    /**
     * Ajout de FROM
     * @param  string $table
     * @return instance
     */
    public function from($table): self
    {
        $this->table = $table;
        return $this;
    }

    public function groupby($value): self
    {
        $this->groupBy[] = $value;
        return $this;
    }

    /**
     * Ajout de leftjoin
     * @param  string $table
     * @param  string $on    conditions
     * @return instance
     */
    public function leftjoin($table, $on): self
    {
        $this->joins[] = ' LEFT JOIN ' . $table . ' ON ' . $on;
        return $this;
    }

    /**
     * Ajout de join
     * @param  string $table
     * @param  string $on    conditions
     * @return instance
     */
    public function join($table, $on): self
    {
        $this->joins[] = ' JOIN ' . $table . ' ON ' . $on;
        return $this;
    }

    /**
     * Ajout de ORDER By
     * @param  string $order
     * @return instance
     */
    public function order($order): self
    {
        $this->order[] = $order;
        return $this;
    }


    /**
     * constructeur de la requete SQL
     * @return string
     */
    public function builder(): string
    {
        /* Traitement de SELECT */
        $select = "SELECT " . ($this->distinct ? 'DISTINCT ' : '');
        if (empty($this->fields)) {
            $select .= '*';
        } else {
            $select .= implode(', ', $this->fields);
        }

        /* Traitement de WHERE */
        $where = '';
        if (!empty($this->conditions)) {
            $where .= " WHERE " . implode(' AND ', $this->conditions);
        }

        /* Traitement de FROM */
        $from = " FROM " . $this->table;

        /* Traitement de JOIN */
        $joins = '';
        if (!empty($this->joins)) {
            $joins = implode(' ', $this->joins);
        }

        /* Traitement de ORDER BY */
        $order = '';
        if (!empty($this->order)) {
            $order = ' ORDER BY ' . implode(',', $this->order);
        }

        /* Traitement du group by */
        $groupby = '';
        if (!empty($this->groupBy)) {
            $groupby = ' GROUP BY ' . implode(',', $this->groupBy);
        }

        /* Traitement LIMIT */
        $limit = '';
        if (!empty($this->limit)) {
            $limit = ' LIMIT ' . $this->limit;
        }

        /* Traitement OFFSET */
        $offset = '';
        if (!empty($this->offset)) {
            $offset = ' OFFSET ' . $this->offset;
        }

        $having = '';
        if (!empty($this->having)) {
            $having = ' HAVING ' . implode(' AND ', $this->having);
        }

        /* création de la requete */
        $sql = $select . $from . $joins . $where . $groupby . $having . $order . $limit . $offset;

        return $sql;
    }

    /**
     * Retourne l'enregistrement suivant son id
     * @param  int $id
     * @return object
     */
    public function find($id)
    {
        $this->where('id', '=', $id);
        return $this->first();
    }


    /**
     * Retourne tout les enregistrement de la table
     * @return array
     */
    public function all()
    {
        return $this->get();
    }

    /**
     * Identique à All mais permet d'ajouter le nombre de resultat
     * @param  int $nblines Nombre de ligne retourné
     * @return array
     */
    public function get($nblines = null)
    {
        $sql = $this->builder();

        if (!is_null($nblines)) {
            $sql .= ' LIMIT ' . $nblines;
        }

        return Config::GetDb()->db_query($sql, $this->model);
    }

    /**
     * retourne le premier enregistrement trouvé
     * @return $this
     */
    public function first()
    {
        $sql = $this->builder() . ' LIMIT 1';
        return Config::GetDb()->db_query($sql, $this->model, true);
    }

    /**
     * LIMIT QUERY SQL
     * @param  [type] $limit [description]
     * @return instance
     */
    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    /**
     * OFFSET QUERY SQL
     * @param int $offest
     */
    public function offset($offset): self
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * Set model name
     * @param string $model_name
     */
    public function setModel($model_name): self
    {
        $this->model = $model_name;
        return $this;
    }

    /**
     * Insertion d'une ligne dans une table
     * @param  array $fields
     */
    public function insert($fields)
    {
        // Ajout automatique de la date de modification
        $fields['created_at'] = date('Y-m-d H:i:s');

        // traitements des champs
        $fields = $this->getFillandSlug($fields);

        return Config::GetDb()->db_insert($this->table, $fields);
    }

    /**
     * Update table
     * @param  array $fields
     * @param  mixed $id ( soit l'id, soit un array avec la condition )
     * @return Boolean
     */
    public function update($fields, $id)
    {
        // Ajout automatique de la date de modification
        $fields['modified_at'] = date('Y-m-d H:i:s');

        // traitements des champs
        $fields = $this->getFillandSlug($fields);

        if (!empty($fields)) {
            // soit plusieurs conditions soit l'id seulement
            if (is_array($id)) {
                return Config::GetDb()->db_update($id, $fields, $this->table);
            } else {
                return Config::GetDb()->db_update(['id' => $id], $fields, $this->table);
            }
        } else {
            throw new DatabaseException("Aucun champs à mettre à jour, vérifier les champs fillable dans le Model");
        }
    }

    /**
     * Effacement d'une ligne de table
     * @param  mixed(array or int) $id
     */
    public function delete($id)
    {
        if (is_array($id)) {
            return Config::GetDb()->db_delete($this->table, '', $id);
        } else {
            return Config::GetDb()->db_delete($this->table, '', ['id' => $id]);
        }
    }

    /**
     * Vérification des champs modifiable et
     * Slugification des champs à slugifier
     * @param  array $fields
     * @return array
     */
    private function getFillandSlug($fields)
    {
        // verification des champs modifiable
        foreach ($fields as $key => $value) {
            // unset not fillable
            if (!in_array($key, $this->fillable)) {
                unset($fields[$key]);
            }

            // slug
            if (in_array($key, $this->slugs)) {
                $key_slug = array_search($key, $this->slugs);
                if (empty($fields[$key_slug]) || !isset($fields[$key_slug])) {
                    $fields[$key_slug] = \Slug::make($fields[$key]);
                }
            }
        }

        return $fields;
    }

    /**
     * retourne les champs fillable
     * @method getFillable
     * @return array
     */
    public function getFillable()
    {
        return $this->fillable;
    }

    /**
     * Permet de faire une requete MySql
     * @param  string $requestMySql Requete de type SQL
     */
    public function query($requestMySql)
    {
        return Config::GetDb()->db_query($requestMySql, $this->model);
    }

    /**
     * Permet d'ajouter une expression brute dans le select
     */
    public function selectRaw(string $expression): self
    {
        $this->fields[] = $expression;
        return $this;
    }

    /**
     * Ajout des conditions WHERE IN
     */
    public function whereIn(string $field, array $values): self
    {
        $escaped = array_map(fn($v) => "'" . addslashes($v) . "'", $values);
        $this->conditions[] = "$field IN (" . implode(',', $escaped) . ")";
        return $this;
    }

    /**
     * Permet d'ajouter une condition WHERE NOT IN
     */
    public function whereNotIn(string $field, array $values): self
    {
        $escaped = array_map(fn($v) => "'" . addslashes($v) . "'", $values);
        $this->conditions[] = "$field NOT IN (" . implode(',', $escaped) . ")";
        return $this;
    }

    /**
     * Permet d'ajouter une condition OR WHERE
     */
    public function orWhere(string $field, string $operand, string $value): self
    {
        $this->conditions[] = 'OR ' . $field . ' ' . $operand . " '" . addslashes($value) . "'";
        return $this;
    }

    /**
     * Permet d'ajouter une expression brute dans le group by
     */
    public function groupByRaw(string $expression): self
    {
        $this->groupBy[] = $expression;
        return $this;
    }

    /**
     * Permet d'ajouter une condition HAVING après un group by
     */
    public function having(string $field, string $operator, string $value): self
    {
        $this->having[] = "$field $operator '$value'";
        return $this;
    }

    /**
     * Permet d'ajouter une expression brute dans le having
     */
    public function havingRaw(string $expression): self
    {
        $this->having[] = $expression;
        return $this;
    }

    /**
     * Permet d'ajouter le mot clef DISTINCT dans la requete
     */
    public function distinct(): self
    {
        $this->distinct = true;
        return $this;
    }
}
