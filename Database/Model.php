<?php

declare(strict_types=1);

namespace Core\Database;

class Model implements \JsonSerializable, \ArrayAccess
{
    /** Nom de table (legacy / optionnel) */
    protected static ?string $table = null;

    /** Nom de table si différent du nom de classe */
    protected ?string $tableName = null;

    /** @var string[] champs modifiables */
    protected array $fillable = [];

    /** @var string[] champs à “slugifier” */
    protected array $slugifiable = [];

    /** @var array<string,mixed> sac d’attributs hydratés */
    protected array $attributes = [];

    public function __construct(array $attrs = [])
    {
        if ($attrs) {
            $this->fill($attrs);
        }
    }

    /**
     * Appel statique proxifié vers le QueryBuilder (API existante conservée)
     */
    public static function __callStatic(string $method, array $arguments)
    {
        $class   = get_called_class();
        $dbtable = new $class;

        // Init QueryBuilder avec les fillables existants
        $query = new QueryBuilder($dbtable->fillable);

        // Détermination du nom de table (comme avant)
        $table = !empty($dbtable->tableName) ? $dbtable->tableName : self::getTable();
        $query->from($table);
        $query->setModel($class);
        $query->setFieldstoSlugifier($dbtable->slugifiable);

        // Appel de la méthode demandée sur le builder
        return $query->$method(...$arguments);
    }

    /**
     * Récupère le nom de table par défaut (ex: Users -> users)
     */
    private static function getTable(): string
    {
        return strtolower(str_replace('App\\Model\\', '', get_called_class()));
    }

    /**
     * Nombre d’enregistrements (API existante conservée)
     */
    public static function count(): int
    {
        $count = self::select(['COUNT(*) as nbrec'])->first();
        return (int) ($count->nbrec ?? 0);
    }

    // --------------------------
    //  Sac d'attributs (no dyn props)
    // --------------------------

    public function __get(string $key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function __set(string $key, $value): void
    {
        $this->attributes[$key] = $value;
    }

    public function __isset(string $key): bool
    {
        return array_key_exists($key, $this->attributes);
    }

    public function __unset(string $key): void
    {
        unset($this->attributes[$key]);
    }

    public function fill(array $attrs): static
    {
        foreach ($attrs as $k => $v) {
            $this->attributes[$k] = $v;
        }
        return $this;
    }

    public function toArray(): array
    {
        return $this->attributes;
    }

    public function jsonSerialize(): array
    {
        return $this->attributes;
    }

    // ArrayAccess (PHP 8.1+ signatures)
    public function offsetExists(mixed $offset): bool
    {
        return array_key_exists((string)$offset, $this->attributes);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->attributes[(string)$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        // $offset ne devrait pas être null pour un modèle,
        // on force en string pour uniformiser les clés.
        $this->attributes[(string)$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->attributes[(string)$offset]);
    }
}
