<?php

declare(strict_types=1);

namespace NAttreid\ReferenceService;

use InvalidArgumentException;
use NAttreid\Utils\Strings;
use Nette\Localization\ITranslator;
use Nette\Reflection\ClassType;

/**
 * Class Service
 *
 * @author Attreid <attreid@gmail.com>
 */
abstract class Service
{
	/** @var Entity[] */
	private $entities = [];

	/** @var Entity[] */
	private $classes = [];

	/** @var string */
	protected $name;

	public function __construct()
	{
		if ($this->name === null) {
			$reflection = new ClassType($this);
			$this->name = Strings::firstLower($reflection->shortName);
		}
	}

	/**
	 * @return array[key => class]
	 */
	public static function getEntities(): array
	{
		return [];
	}

	/**
	 * @return Entity[]
	 */
	public function findAll(): array
	{
		return $this->entities;
	}

	public function add(int $key, Entity $entity): void
	{
		if (isset($this->entities[$key])) {
			throw new InvalidArgumentException('Duplicite key!');
		}
		$entity->setup($key, $this->name);
		$this->entities[$key] = $entity;
		$this->classes[get_class($entity)] = $entity;
	}

	public function fetchPairsByName(): array
	{
		$arr = $this->fetchPairsById();
		asort($arr);
		return $arr;
	}

	public function fetchPairsById(): array
	{
		$arr = [];
		foreach ($this->entities as $key => $entity) {
			$arr[$key] = $entity->prototype;
		}
		return $arr;
	}

	public function getById(int $id): ?Entity
	{
		if (isset($this->entities[$id])) {
			return clone $this->entities[$id];
		} else {
			return null;
		}
	}

	public function getByClass(string $class): ?Entity
	{
		if (isset($this->classes[$class])) {
			return clone $this->classes[$class];
		} else {
			return null;
		}
	}
}