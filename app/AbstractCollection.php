<?php
/**
 * Created by PhpStorm.
 * User: Utilisateur
 * Date: 20/07/2018
 * Time: 19:49
 */

namespace Vittel;

/**
 * Class AbstractCollection
 * @package Snaker\ORM
 */
abstract class AbstractCollection implements \IteratorAggregate, \Countable, \ArrayAccess
{

    /**
     * @var array
     */
    protected $collection = array();

    /**
     * Add Entity to Collection
     *
     * @param $entity
     * @throws InvalidArgumentException
     */
    abstract public function add($entity);

    /**
     * Remove Entity from Collection
     *
     * @param $id
     * @return $this
     */
    public function remove($id)
    {
        if (isset($this->collection[$id])) {
            unset($this->collection[$id]);
        }
        return $this;
    }

    /**
     * Reset Collection
     */
    public function reset()
    {
        $this->collection = array();
    }

    /**
     * Get Iterator Method
     *
     * @return mixed
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Return Size of Collection
     *
     * @return mixed
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * ArrayAccess Method
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->collection[$offset]);
    }

    /**
     * ArrayAccess Method
     *
     * @param mixed $offset
     * @return mixed|null
     */
    public function offsetGet($offset)
    {
        return isset($this->collection[$offset]) ? $this->collection[$offset] : null;
    }

    /**
     * ArrayAccess Method
     *
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->collection[$offset] = $value;
    }

    /**
     * ArrayAccess Method
     *
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        $this->remove($offset);
    }

    /**
     * Merge two collections
     *
     * @param AbstractCollection $collection
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function merge($collection)
    {
        if (!is_a($collection, self::class)) {
            throw new \InvalidArgumentException('Collection must have this class '.self::class);
        }

        if (count($collection) > 0) {
            foreach ($collection as $entity) {
                $this->add($entity);
            }
        }

        return $this;
    }

    /**
     * Return Collection in array
     *
     * @return array
     */
    public function __toArray()
    {
        return $this->collection;
    }

    /**
     * Clone collection
     */
    public function __clone()
    {
        /** @var Coll $item */
        foreach ($this->collection as $key=>$item)
        {
            $this->collection[$key] = clone $item;
        }
    }

    /**
     * Return the first element of the Collection
     *
     * @return mixed
     */
    public function getFirst()
    {
        return $this->collection[array_keys($this->collection)[0]];
    }

    /**
     * Return the filtered Collection
     *
     * @param callable $callback
     * @return AbstractCollection
     */
    public function filterBy($callback)
    {
        $response = clone $this;
        $response->reset();

        foreach ($this->collection as $key=>$element)
        {
            if ($callback($element, $key)) {
                $response->add($element);
            }
        }

        return $response;
    }
}