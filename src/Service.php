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

	/** @var ITranslator */
	private $translator;

	/** @var string */
	protected $name;

	public function __construct(ITranslator $translator)
	{
		if ($this->name === null) {
			$reflection = new ClassType($this);
			$this->name = Strings::firstLower($reflection->shortName);
		}

		$this->translator = $translator;
	}

	/**
	 * @return array[key => class]
	 */
	public static function getEntities(): array
	{
		return [];
	}

	/**
	 * @param int $key
	 * @param Entity $entity
	 */
	public function add(int $key, Entity $entity): void
	{
		if (isset($this->entities[$key])) {
			throw new InvalidArgumentException('Duplicite key!');
		}
		$entity->setService($this);
		$this->entities[$key] = $entity;
		$this->classes[get_class($entity)] = $entity;
	}

	/**
	 * @param Entity $entity
	 * @return string
	 */
	public function translate(Entity $entity): string
	{
		return $this->translator->translate($this->getFullName($entity));
	}

	/**
	 * @param Entity $entity
	 * @return string
	 */
	public function getFullName(Entity $entity): string
	{
		return $this->name . '.' . $entity->entityName;
	}

	/**
	 * @return array
	 */
	public function fetchPairsByName(): array
	{
		$arr = $this->fetchPairsById();
		asort($arr);
		return $arr;
	}

	/**
	 * @return array
	 */
	public function fetchPairsById(): array
	{
		$arr = [];
		foreach ($this->entities as $key => $entity) {
			$arr[$key] = $this->translate($entity);
		}
		return $arr;
	}

	/**
	 * @return array
	 */
	public function fetchUntranslatedPairsById(): array
	{
		$arr = [];
		foreach ($this->entities as $key => $entity) {
			$arr[$key] = $this->getFullName($entity);
		}
		return $arr;
	}

	/**
	 * @param int $id
	 * @return Entity|null
	 */
	public function getById(int $id): ?Entity
	{
		if (isset($this->entities[$id])) {
			return clone $this->entities[$id];
		} else {
			return null;
		}
	}

	/**
	 * @param string $class
	 * @return Entity|null
	 */
	public function getByClass(string $class): ?Entity
	{
		if (isset($this->classes[$class])) {
			return clone $this->classes[$class];
		} else {
			return null;
		}
	}
}