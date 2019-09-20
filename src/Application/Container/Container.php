<?php

namespace CakeParser\Application\Container;


use CakeParser\Application\SourceNotFoundException;
use CakeParser\Config\Source;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 * Class Container
 * @package CakeParser\Application\Container
 * @author Georgiy Korzh <kozhmd@gmail.com>
 */
class Container implements ContainerInterface
{
    private $source;

    public function __construct(Source $source)
    {
        $this->source = $source;
    }

    /**
     * @param string $id
     * @return array|mixed|null
     * @throws \Exception
     */
    public function get($id)
    {
        $result = null;
        $index = $this->findById($id);

        if ($index !== false) {

            $item = $this->getAt($index);

            $result = $this->createByConfigItem($item);

        } else {
            $result = [];
            $indexes = $this->findAllBytags($id);

            if (empty($indexes)) {
                throw new SourceNotFoundException($id);
            }

            foreach ($indexes as $index) {
                $item = $this->getAt($index);
                $result[] = $this->createByConfigItem($item);
            }

        }

        return $result;

    }

    /**
     * @param string $id
     * @return bool
     */
    public function has($id)
    {
        return $this->findById($id) === false;
    }

    /**
     * @param string $id
     * @return false|int
     */
    private function findById(string $id)
    {
        $all = $this->source->getAll();
        $ids = array_column($all, 'id');
        $index = array_search($id, $ids);

        return $index;
    }

    /**
     * @param $tagId
     * @return array
     */
    private function findAllByTags($tagId)
    {
        $all = $this->source->getAll();
        $result = [];

        foreach ($all as $k => $item) {
            $tags = $item['tags'] ?? [];
            if (in_array($tagId, $tags)) {
                $result[] = $k;
            }
        }

        return $result;
    }

    private function createByConfigItem($item)
    {
        list($id, $className, $argIdList, $factoryClassName, $tags) = $item;


        if (is_null($className) && is_null($factoryClassName)) {
            throw new \Exception('You must provide either `factory` or `class` param');
        }

        if (is_object($className)) {
            $result = $className;
        } else {

            $argIdList = $argIdList
                ? (array)$argIdList
                : [];

            $argList = [];

            foreach ($argIdList as $argId) {
                $argList[] = $this->get($argId);
            }

            if ($factoryClassName) {
                /** @var FactoryInterface $factoryObject */
                $factoryObject = !is_object($factoryClassName) ? $this->get($factoryClassName) : $factoryClassName;
                $result = $factoryObject->create($this, $argList);
            } else {
                $result = new $className(...$argList);
            }
        }

        return $result;
    }

    /**
     * @param $index
     * @return array
     */
    private function getAt($index)
    {
        $all = $this->source->getAll();
        $item = $all[$index];
        return [
            $item['id'],
            $item['class'] ?? null,
            $item['argIdList'] ?? null,
            $item['factory'] ?? null,
            $item['tags'] ?? null
        ];
    }

}